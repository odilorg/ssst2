<?php

namespace App\Filament\Resources\BookingRequestResource\Pages;

use Filament\Actions;
use App\Models\BookingRequest;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\BookingRequestResource;

class CreateBookingRequest extends CreateRecord
{
    protected static string $resource = BookingRequestResource::class;
     protected function mutateFormDataBeforeCreate(array $data): array
    {
        // YYYYMMDD-NNNN format
        $date      = now()->format('Ymd');
        $count     = BookingRequest::whereDate('created_at', now())->count() + 1;
        $sequence  = str_pad($count, 4, '0', STR_PAD_LEFT);
        $data['request_number'] = "{$date}-{$sequence}";

        return $data;
    }
}
