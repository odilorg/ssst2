<?php

namespace App\Filament\Resources\CityDistanceResource\Pages;

use App\Filament\Resources\CityDistanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCityDistance extends EditRecord
{
    protected static string $resource = CityDistanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
