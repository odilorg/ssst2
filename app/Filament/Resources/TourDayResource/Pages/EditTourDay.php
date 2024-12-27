<?php

namespace App\Filament\Resources\TourDayResource\Pages;

use App\Filament\Resources\TourDayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourDay extends EditRecord
{
    protected static string $resource = TourDayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
