<?php

namespace App\Filament\Resources\ItineraryResource\Pages;

use Filament\Actions;
use App\Jobs\GenerateItineraryPdf;
use Illuminate\Support\Facades\Log;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ItineraryResource;

class CreateItinerary extends CreateRecord
{
    protected static string $resource = ItineraryResource::class;
    /**
     * Runs after the form fields are saved to the database,
     * including any Repeater "itineraryItems".
     */
    protected function afterCreate(): void
    {
        // $this->record is the newly created Itinerary model instance
        // with all relationships saved.
        
        Log::info('afterCreate hook fired for Itinerary', [
            'id' => $this->record->id,
        ]);

        // Now that Repeater items are saved, we can safely generate the PDF.
        GenerateItineraryPdf::dispatch($this->record);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
