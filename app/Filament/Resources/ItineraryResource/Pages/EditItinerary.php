<?php

namespace App\Filament\Resources\ItineraryResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ItineraryResource;
use App\Jobs\GenerateItineraryPdf;
use Illuminate\Support\Facades\Log;

class EditItinerary extends EditRecord
{
    protected static string $resource = ItineraryResource::class;

    protected function afterSave(): void
    {
        Log::info('EditItinerary: afterSave started.', [
            'itinerary_id' => $this->record->id
        ]);

        // 1) Load relationships
        $itinerary = $this->record->load([
            'transport',
            'itineraryItems.cityDistance',
        ]);

        // 2) Sum up distance from itinerary items
        $totalDistance = 0;
        foreach ($itinerary->itineraryItems as $item) {
            $distance = $item->cityDistance->distance_km ?? 0;
            $totalDistance += $distance;
        }

        // 3) Convert fuel consumption from L/100km to L/km
        $fuelConsumptionPerKm = ($itinerary->transport->fuel_consumption ?? 0) / 100;

        // 4) Theoretical (notional) fuel usage
        $theoreticalFuelExpenditure = $totalDistance * $fuelConsumptionPerKm;

        // 5) Actual usage from odometer
        $kmStart = (float)($itinerary->km_start ?? 0);
        $kmEnd   = (float)($itinerary->km_end   ?? 0);
        $actualDistance = $kmEnd - $kmStart;

        $actualFuelExpenditure = $actualDistance * $fuelConsumptionPerKm;

        // 6) Round or keep decimals as needed for theoretical and actual
        //    (Here, we round to 2 decimals for clarity.)
        $theoreticalFuelExpenditure = round($theoreticalFuelExpenditure, 2);
        $actualFuelExpenditure      = round($actualFuelExpenditure, 2);

        // 7) Calculate leftover or shortfall in liters (can be negative)
        $remainingFuel = $theoreticalFuelExpenditure - $actualFuelExpenditure;

        // 8) Convert the leftover liters to an integer
        //    (this will either truncate or round, depending on your preference)
        //    Below we do a full round, then cast to int:
        $remainingFuelInt = (int) round($remainingFuel);

        // 9) Update the itineraries table
        //    - 'fuel_expenditure' for the theoretical usage
        //    - 'fuel_expenditure_factual' for the actual usage
        $itinerary->update([
            'fuel_expenditure'        => $theoreticalFuelExpenditure,  // existing column
            'fuel_expenditure_factual'=> $actualFuelExpenditure,       // new column
        ]);

        // 10) Update the transports table for the remaining fuel (integer)
        $transport = $itinerary->transport;
        if ($transport) {
            $transport->update([
                'fuel_remaining_liter' => $remainingFuelInt,
            ]);
        }

        // 11) Log
        Log::info('Updated itinerary & transport', [
            'itinerary_id'              => $itinerary->id,
            'theoreticalFuelExp'        => $theoreticalFuelExpenditure,
            'actualFuelExp'             => $actualFuelExpenditure,
            'transport_id'              => $transport->id ?? null,
            'fuel_remaining_liter_int'  => $remainingFuelInt,
        ]);

        // 12) Regenerate PDF
        GenerateItineraryPdf::dispatch($itinerary);

        Log::info('EditItinerary afterSave: calculations done & PDF generated.', [
            'itinerary_id' => $itinerary->id,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
