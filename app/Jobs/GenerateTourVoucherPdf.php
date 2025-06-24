<?php

namespace App\Jobs;

use App\Models\BookingRequest;
use App\Models\Company;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\TourDay;

class GenerateTourVoucherPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public BookingRequest $record;

    public function __construct(BookingRequest $record)
    {
        $this->record = $record;
    }

    public function handle(): void
    {
        /* -----------------------------------------------------------
         | 1) Gather everything we need
         * -------------------------------------------------------- */
        $company = Company::whereNotNull('is_operator')->first();


        // 1) Eager‐load just the days we care about:
        $tour = $this->record->tour()
            ->with(['tourDays.guide', 'tourDays.cities', 'tourDays.monuments'])
            ->first();

        // 2) Build one entry per Monument‐TourDay pairing
        $voucherData = collect();
        foreach ($tour->tourDays as $day) {
            // filter only voucher‐enabled monuments
            $day->monuments
                ->where('voucher', true)
                ->each(function ($mon) use ($day, &$voucherData, $tour) {
                    $voucherData->push([
                        'guide'         => optional($day->guide)->name ?: '—',
                        'city'          => $day->cities->pluck('name')->implode(', '),
                        'monument'      => $mon->name,
                        'tour_number'   => $tour->tour_number,
                        'country'       => $tour->country,
                        'number_people' => $tour->number_people,
                        'date'          => now()->format('d.m.Y'),
                    ]);
                });
        }


        // “today” for the voucher header
        $today = Carbon::now()->format('d.m.Y');
        // number of blanks per page

        /* -----------------------------------------------------------
         | 2) Render PDF
         * -------------------------------------------------------- */
        // And pass it into your view data:
        // 3) Send to Blade
        $pdf = PDF::loadView('vouchers.dynamic_tour_voucher', [
            'company'     => Company::where('is_operator', true)->first(),
            'vouchers'    => $voucherData,
            'today'       => $today,
        ])->setPaper('a4', 'portrait');

        /* -----------------------------------------------------------
         | 3) Store & update BookingRequest
         * -------------------------------------------------------- */
        $filename = 'tour_voucher_' . $this->record->id . '.pdf';
        Storage::put('booking_requests/' . $filename, $pdf->output());

        $this->record->update(['tour_voucher_file' => $filename]);
    }
}
