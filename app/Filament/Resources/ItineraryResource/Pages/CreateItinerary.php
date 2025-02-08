<?php

namespace App\Filament\Resources\ItineraryResource\Pages;

use Filament\Actions;
use App\Models\Transport;
use App\Models\CityDistance;
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
          // Load the full record with relationships
    $itinerary = $this->record->load([
        'transport', // so we can get fuel_consumption
        'itineraryItems.cityDistance', // so each item can retrieve distance_km
    ]);

    $totalDistance = 0;

    // Sum up distances from each itinerary item
    foreach ($itinerary->itineraryItems as $item) {
        $totalDistance += $item->cityDistance->distance_km ?? 0;
    }

    // For example, if `transport->fuel_consumption` is liters-per-km:
    $fuelConsumption = $itinerary->transport->fuel_consumption/100 ?? 0;
    $fuelExpenditure = $totalDistance * $fuelConsumption;

    // Update the itinerary with the computed value
    $itinerary->update([
        'fuel_expenditure' => $fuelExpenditure,
    ]);

        // Now that Repeater items are saved, we can safely generate the PDF.
        GenerateItineraryPdf::dispatch($this->record);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
