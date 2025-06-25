<?php

namespace App\Filament\Resources\TourResource\Pages;

use App\Filament\Resources\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTour extends EditRecord
{
    protected static string $resource = TourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

      protected function mutateFormDataBeforeSave(array $data): array
    {
        // only if they actually changed the country
        if (isset($data['country']) && $data['country'] !== $this->record->country) {
            $code = strtoupper(substr($data['country'], 0, 2));
            $data['tour_number'] = "{$code}-" . str_pad($this->record->id, 5, '0', STR_PAD_LEFT);
        }

        return $data;
    }
}
