<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Models\Hotel;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CompanyResource;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeSave(array $data): array
{
    // remove hotel_ids before writing to companies table
    unset($data['hotel_ids']);
    return $data;
}

protected function afterSave(): void
{
    $ids = $this->form->getState()['hotel_ids'] ?? [];
    Hotel::where('company_id', $this->record->id)->update(['company_id' => null]);
    if ($ids) Hotel::whereIn('id', $ids)->update(['company_id' => $this->record->id]);
}
}
