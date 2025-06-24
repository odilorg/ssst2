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

        

// After:
$tour = $this->record->tour()
    ->with([
        'tourDays.cities',  // ✅ load your belongsToMany
        'tourDays.guide',
    ])
    ->first();

    // Then immediately below, build a comma list of guide names:
$guides = $tour->tourDays
    ->pluck('guide.full_name')     // pulls full_name from each related Guide
    ->filter()                     // remove nulls if any days have no guide
    ->unique()                     // drop duplicates if same guide on multiple days
    ->implode(', ');


// After:
$cities = $tour->tourDays
    ->flatMap(fn($day) => $day->cities->pluck('name'))
    ->unique()
    ->implode(', ');

        // “today” for the voucher header
        $today = Carbon::now()->format('d.m.Y');
 // number of blanks per page
        $count = 6;
        /* -----------------------------------------------------------
         | 2) Render PDF
         * -------------------------------------------------------- */
       // And pass it into your view data:
$pdf = PDF::loadView('vouchers.dynamic_tour_voucher', [
    'company' => $company,
    'tour'    => $tour,
    'today'   => $today,
    'cities'  => $cities,
    'guides'  => $guides,
    'count'   => $count,
])->setPaper('a4', 'portrait');

        /* -----------------------------------------------------------
         | 3) Store & update BookingRequest
         * -------------------------------------------------------- */
        $filename = 'tour_voucher_' . $this->record->id . '.pdf';
        Storage::put('booking_requests/' . $filename, $pdf->output());

        $this->record->update(['tour_voucher_file' => $filename]);
    }
}
