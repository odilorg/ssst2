<?php

namespace App\Mail;

use App\Models\BookingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class SendBookingRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public BookingRequest $bookingRequest;

    public function __construct(BookingRequest $bookingRequest)
    {
        $this->bookingRequest = $bookingRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Booking Request: ' . $this->bookingRequest->tour->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.booking-request',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path(
                    'app/booking_requests/' . $this->bookingRequest->file_name
                ))
                ->as('booking_request_'.$this->bookingRequest->id.'.pdf')
                ->mime('application/pdf'),
        ];
    }
}
