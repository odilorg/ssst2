<?php

namespace App\Filament\Resources\CompanyResource\Pages;

use App\Models\Hotel;
use Filament\Actions;
use App\Jobs\GenerateVoucherTemplatePdf;
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
    

    protected function getActions(): array
{
    return [
        // … your existing save, delete, etc.

        \Filament\Actions\Action::make('regenerateVoucher')
            ->label('Regenerate Voucher Template')
            ->icon('heroicon-o-document-text')
            ->requiresConfirmation()
            ->action(fn() => GenerateVoucherTemplatePdf::dispatch())
            ->successNotificationTitle('Voucher template regeneration queued'),
    ];
}
}
