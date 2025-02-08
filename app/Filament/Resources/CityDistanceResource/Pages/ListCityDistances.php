<?php

namespace App\Filament\Resources\CityDistanceResource\Pages;

use App\Filament\Resources\CityDistanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCityDistances extends ListRecords
{
    protected static string $resource = CityDistanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
