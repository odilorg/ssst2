<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Models\Tour;
use Filament\Actions;
use App\Filament\Resources\TourResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTour extends CreateRecord
{
    protected static string $resource = TourResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

   
   protected function mutateFormDataBeforeCreate(array $data): array
    {
        // take first 2 letters of country, uppercase
        $countryCode = strtoupper(substr($data['country'], 0, 2));

        // get the next ID (note: simple approach—if you need true atomicity, consider nullable + afterCreate)
        $nextId = Tour::max('id') + 985;

        $data['tour_number'] = "{$countryCode}-" . str_pad($nextId, 5, '0', STR_PAD_LEFT);

        return $data;
    }
}
