<?php

namespace App\Jobs;

use App\Models\Tour;
use App\Models\Estimate;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateEstimatePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $estimate;

    /**
     * Create a new job instance.
     */
    public function __construct(Estimate $estimate)
    {
        $this->estimate = $estimate;
        Log::info('GenerateEstimatePdf job instantiated', ['estimate_id' => $estimate->id]);
    }

    /**
     * Execute the job.
     */
    public function handle()
{
    Log::info('GenerateEstimatePdf job started', ['estimate_id' => $this->estimate->id]);

    try {
        // Preload necessary relationships
        $tour = Tour::with([
            'tourDays.tourDayHotels.hotel.hotelRooms.roomType', // Preload hotel details and associated rooms and their types
            'tourDays.tourDayHotels.hotelRooms.room.roomType', // Preload hotel room relationships for nested repeaters
            'tourDays.tourDayTransports.transportType.transportPrices', // Preload transport details, type, and prices
            'tourDays.cities', // Preload cities for tour days
            'tourDays.guide.languages', // Preload guide and their languages
            'tourDays.mealTypeRestaurantTourDays.mealType', // Preload meal types for restaurants
            'tourDays.monuments', // Preload monuments
        ])->find($this->estimate->tour_id);
            // Log the content of $tour
                Log::info('Tour Details:', [
                    'tour' => $tour
                ]);

        if (!$tour) {
            Log::error('Tour not found', ['tour_id' => $this->estimate->tour_id]);
            return;
        }

        // Log the loaded $tour object
        Log::info('Loaded Tour Data:', ['tour' => $tour->toArray()]);

         // Render the HTML and debug it
        //  $html = view('estimates.estimate', compact('tour'))->render();
        //  dd($html); // Debug and stop execution here to inspect the rendered HTML

        // Generate the PDF
        $pdf = Pdf::loadView('estimates.estimate', compact('tour'));

        // Save the PDF to storage
        $fileName = 'estimate_' . $this->estimate->id . '.pdf';
        $filePath = 'estimates/' . $fileName;
        Storage::put($filePath, $pdf->output());

        // Update the estimate record with the file name
        $this->estimate->update(['file_name' => $fileName]);
        Log::info('Estimate updated with file name', ['estimate_id' => $this->estimate->id, 'file_name' => $fileName]);
    } catch (\Exception $e) {
        // Log any errors
        Log::error('Error in GenerateEstimatePdf job', [
            'estimate_id' => $this->estimate->id,
            'error' => $e->getMessage(),
            'stack_trace' => $e->getTraceAsString(),
        ]);

        throw $e; // Re-throw the exception to let the job fail and retry
    }

    Log::info('GenerateEstimatePdf job completed', ['estimate_id' => $this->estimate->id]);
}


}
