<?php

namespace App\Filament\Resources\TransportPriceResource\Pages;

use App\Filament\Resources\TransportPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransportPrices extends ListRecords
{
    protected static string $resource = TransportPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
