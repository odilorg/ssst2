<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\OilChange;
use App\Models\Transport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CheckOilChangeDue extends Command
{
    protected $signature = 'check:oil-change-due';
    protected $description = 'Check for due oil changes and notify users';

    public function handle()
{
    Log::info('Starting oil change due check.');
    $transports = Transport::all();
    Log::info('Total transports:', ['count' => $transports->count()]);

    foreach ($transports as $transport) {
        $lastOilChange = OilChange::where('transport_id', $transport->id)
            ->latest('oil_change_date')
            ->first();

        if ($lastOilChange) {
            $nextChangeDate = Carbon::parse($lastOilChange->next_change_date);
            $nextChangeMileage = $lastOilChange->next_change_mileage;

            // Calculate days remaining dynamically
            $daysRemaining = now()->diffInDays($nextChangeDate, false); // Negative if overdue
            $kmRemaining = $nextChangeMileage - $transport->current_mileage;

            // Check if days remaining is 3, 2, or 1 (or mileage within 300 KM)
            if (($daysRemaining <= 3 && $daysRemaining >= 1) || $kmRemaining <= 300) {
                $this->sendToN8nWebhook(
                    $transport,
                    $lastOilChange,
                    max($daysRemaining, 0), // Prevent negative days
                    max($kmRemaining, 0) // Prevent negative KM
                );
            }
        }
    }

    $this->info('Oil change due check completed.');
}

protected function sendToN8nWebhook($transport, $lastOilChange, $daysRemaining, $kmRemaining)
{
    $data = [
        'plate_number' => $transport->plate_number,
        'due_in_days' => $daysRemaining,
        'due_in_km' => $kmRemaining,
        'oil_change_date' => $lastOilChange->oil_change_date,
        'next_change_date' => $lastOilChange->next_change_date,
        'next_change_mileage' => $lastOilChange->next_change_mileage,
    ];

    $response = Http::post('https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0', $data);

    if ($response->successful()) {
        Log::info('Webhook request sent successfully:', $data);
    } else {
        Log::error('Failed to send webhook request:', [
            'status' => $response->status(),
            'response' => $response->body(),
        ]);
    }
}

    
}
