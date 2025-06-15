<?php

namespace App\Jobs;

use App\Models\BookingRequest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateBookingRequestPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public BookingRequest $request;

    public function __construct(BookingRequest $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $tour = $this->request->tour()->with([
            'tourDays',
            'tourDays.tourDayHotels.hotel',
        ])->first();

        $pdf = PDF::loadView('pdf.booking-request', [
            'tour'    => $tour,
            'request' => $this->request,
        ]);

        $filename = 'booking_request_'.$this->request->id.'.pdf';
        Storage::put('booking_requests/'.$filename, $pdf->output());

        $this->request->update(['file_name' => $filename]);
    }
}
