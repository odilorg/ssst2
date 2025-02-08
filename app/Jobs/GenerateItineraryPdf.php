<?php

namespace App\Jobs;

use App\Models\Itinerary;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateItineraryPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Itinerary $itinerary;

    /**
     * Create a new job instance.
     */
    public function __construct(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Log::info('GenerateItineraryPdf job started!', ['itinerary_id' => $this->itinerary->id]);

        try {
            // 1) Load all relationships we need for the PDF:
            //    "tour", "transport", and "itineraryItems" (plus anything else you need).
            $this->itinerary->load([
                'tour',
                'transport',
                'itineraryItems',
            ]);

            // 2) Generate the PDF from the Blade view,
            //    passing the fully loaded $this->itinerary.
            $pdf = PDF::loadView('itineraries.itinerary', [
                'itinerary' => $this->itinerary,
            ]);

            // 3) Build a filename & store the file in storage
            $fileName = 'itinerary_' . $this->itinerary->id . '.pdf';
            $filePath = 'itineraries/' . $fileName;
            Log::info('Attempting to store PDF', ['path' => $filePath]);
            Storage::put($filePath, $pdf->output());
            Log::info('PDF stored successfully');
            Storage::put($filePath, $pdf->output());

            // 4) Update the itinerary record with the file name
            $this->itinerary->update(['file_name' => $fileName]);
        } catch (\Exception $e) {
            // If something goes wrong, rethrow so the job can fail & retry
            throw $e;
        }
    }
}
