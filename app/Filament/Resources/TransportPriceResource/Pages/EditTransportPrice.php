<?php

namespace App\Filament\Resources\TransportPriceResource\Pages;

use App\Filament\Resources\TransportPriceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransportPrice extends EditRecord
{
    protected static string $resource = TransportPriceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
