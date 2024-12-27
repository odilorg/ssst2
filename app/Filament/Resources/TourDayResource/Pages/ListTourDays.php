<?php

namespace App\Filament\Resources\TourDayResource\Pages;

use App\Filament\Resources\TourDayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourDays extends ListRecords
{
    protected static string $resource = TourDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
