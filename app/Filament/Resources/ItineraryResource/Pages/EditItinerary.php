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

        // 2) Calculate total "theoretical" distance
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

        // 6) Round or keep decimals as needed
        $theoreticalFuelExpenditure = round($theoreticalFuelExpenditure, 2);
        $actualFuelExpenditure      = round($actualFuelExpenditure, 2);

        // 7) Difference (if negative => actual usage exceeded theoretical)
        $remainingFuel = $theoreticalFuelExpenditure - $actualFuelExpenditure;
        // We'll convert difference to an integer (truncate or rounding)
        $remainingFuelInt = (int) round($remainingFuel);

        // 8) Update ONLY the itineraries table columns
        $itinerary->update([
            'fuel_expenditure'          => $theoreticalFuelExpenditure,
            'fuel_expenditure_factual'  => $actualFuelExpenditure,
            'fuel_remaining_liter'  => $remainingFuelInt,
        ]);

        // 9) Add the difference (remainingFuelInt) to the existing transport's fuel_remaining_liter
        $transport = $itinerary->transport;
        if ($transport) {
            // If null, cast to 0
            $oldValue = (int) $transport->fuel_remaining_liter;
            $newValue = $oldValue + $remainingFuelInt; 
            // newValue can go up or down depending on sign of $remainingFuelInt

            $transport->update([
                'fuel_remaining_liter' => $newValue,
            ]);

            Log::info('Updated transport fuel_remaining_liter', [
                'transport_id' => $transport->id,
                'old_value'    => $oldValue,
                'delta'        => $remainingFuelInt,
                'new_value'    => $newValue,
            ]);
        }

        Log::info('Updated itinerary', [
            'itinerary_id' => $itinerary->id,
            'theoretical_fuel_expenditure' => $theoreticalFuelExpenditure,
            'actual_fuel_expenditure'      => $actualFuelExpenditure,
            'fuel_difference_int'          => $remainingFuelInt,
        ]);

        // 10) Regenerate PDF
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
