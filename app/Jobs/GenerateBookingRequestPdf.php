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
        // 1) Load the tour with all the hotel / room relationships
        $tour = $this->request
            ->tour()
            ->with([
                'tourDays',
                'tourDays.tourDayHotels.hotel',
                'tourDays.tourDayHotels.hotelRooms.room.roomType',
            ])
            ->first();

        // 2) Grab your “operator” company profile
        $company = Company::where('is_operator', true)->first();

        // 3) Generate the PDF, passing tour, request, and company into the view
        $pdf = PDF::loadView('pdf.booking-request', [
            'tour'    => $tour,
            'request' => $this->request,
            'company' => $company,
        ]);

        // 4) Save and update the booking_request record
        $filename = 'booking_request_' . $this->request->id . '.pdf';
        Storage::put('booking_requests/' . $filename, $pdf->output());
        $this->request->update(['file_name' => $filename]);
    }
}
