<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Models\Hotel;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CompanyResource;

class CreateCompany extends CreateRecord
{
    protected static string $resource = CompanyResource::class;

     protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['hotel_ids']);
        return $data;
    }

    protected function afterCreate(): void
    {
        $hotelIds = $this->form->getState()['hotel_ids'] ?? [];

        if (!empty($hotelIds)) {
            Hotel::whereIn('id', $hotelIds)->update(['company_id' => $this->record->id]);
        }
    }
}
