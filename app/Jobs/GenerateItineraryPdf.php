<?php

namespace App\Jobs;

use App\Models\Tour;
use App\Models\Estimate;
use App\Models\Itinerary;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateItineraryPdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $itinerary;

    /**
     * Create a new job instance.
     */
    public function __construct(Itinerary $itinerary)
    {
        $this->itinerary = $itinerary;
       // Log::info('GenerateitineraryPdf job instantiated', ['itinerary_id' => $itinerary->id]);
    }

    /**
     * Execute the job.
     */
    public function handle()
{
    //Log::info('GenerateitineraryPdf job started', ['itinerary_id' => $this->itinerary->id]);

    try {
        // Preload necessary relationships
        $itinerary = Itinerary::with([           
            'tour', // Preload monuments
            'transport', // Preload transport
        ])->find($this->itinerary->itinerary_id);
            // Log the content of $tour
                // Log::info('Tour Details:', [
                //     'tour' => $tour
                // ]);

        // if (!$tour) {
        //     Log::error('Tour not found', ['tour_id' => $this->itinerary->tour_id]);
        //     return;
        // }

        // Log the loaded $tour object
       // Log::info('Loaded Tour Data:', ['tour' => $tour->toArray()]);

         // Render the HTML and debug it
        //  $html = view('itinerarys.itinerary', compact('tour'))->render();
        //  dd($html); // Debug and stop execution here to inspect the rendered HTML
            $itinerary = $this->itinerary;
        // Generate the PDF
        // Ensure that each guide's price_types field is available
// $tour->tourDays->each(function ($day) {
//     if ($day->guide) {
//         $day->guide->price_types = is_array($day->guide->price_types) 
//             ? $day->guide->price_types 
//             : json_decode($day->guide->price_types, true);
//     }
// });
// $tour->tourDays->each(function ($day) {
//     if ($day->guide) {
//         $day->guide->price_types = is_array($day->guide->price_types) 
//             ? $day->guide->price_types 
//             : json_decode($day->guide->price_types, true) ?? [];
//     }
// });


        $pdf = Pdf::loadView('itineraries.itinerary', compact( 'itinerary'));

        // Set paper size to A4 and orientation to landscape
        $pdf->setPaper('a4', 'landscape');
        // Save the PDF to storage
        $fileName = 'itinerary_' . $this->itinerary->id . '.pdf';
        $filePath = 'itineraries/' . $fileName;
        Storage::put($filePath, $pdf->output());

        // Update the itinerary record with the file name
        $this->itinerary->update(['file_name' => $fileName]);
      //  Log::info('itinerary updated with file name', ['estimate_id' => $this->estimate->id, 'file_name' => $fileName]);
    } catch (\Exception $e) {
        // Log any errors
        // Log::error('Error in GenerateEstimatePdf job', [
        //     'estimate_id' => $this->estimate->id,
        //     'error' => $e->getMessage(),
        //     'stack_trace' => $e->getTraceAsString(),
        // ]);

        throw $e; // Re-throw the exception to let the job fail and retry
    }

    //Log::info('GenerateEstimatePdf job completed', ['estimate_id' => $this->estimate->id]);
}


}
