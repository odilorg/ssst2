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
        Log::info('=== Starting oil change due check ===');
        
        $transports = Transport::all();
        Log::info('Total transports found', ['count' => $transports->count()]);

        foreach ($transports as $transport) {
            // Log the transport being processed
            Log::info('Processing transport', [
                'transport_id' => $transport->id,
                'plate_number' => $transport->plate_number
            ]);

            $lastOilChange = OilChange::where('transport_id', $transport->id)
                ->latest('oil_change_date')
                ->first();
            
            if (!$lastOilChange) {
                // Log if no oil change record is found for this transport
                Log::info('No OilChange record found', [
                    'transport_id' => $transport->id
                ]);
                continue;
            }

            // Log the last known oil change details
            Log::info('Last oil change details', [
                'oil_change_date' => $lastOilChange->oil_change_date,
                'next_change_date' => $lastOilChange->next_change_date,
                'next_change_mileage' => $lastOilChange->next_change_mileage,
            ]);

            $nextChangeDate = Carbon::parse($lastOilChange->next_change_date);
            $nextChangeMileage = $lastOilChange->next_change_mileage;

            $daysRemaining = now()->diffInDays($nextChangeDate, false); // Negative if overdue
            $kmRemaining = $nextChangeMileage - $transport->current_mileage;

            // Log the dynamic calculation
            Log::info('Calculated remaining intervals', [
                'days_remaining' => $daysRemaining,
                'km_remaining' => $kmRemaining
            ]);

            // Check if days remaining is 3, 2, or 1 or mileage within 300 KM
            if (($daysRemaining <= 3 && $daysRemaining >= 1) || $kmRemaining <= 300) {
                Log::info('Conditions met. Sending data to webhook', [
                    'transport_id' => $transport->id
                ]);
                $this->sendToN8nWebhook(
                    $transport,
                    $lastOilChange,
                    max($daysRemaining, 0), // Prevent negative days
                    max($kmRemaining, 0)    // Prevent negative KM
                );
            } else {
                Log::info('Conditions NOT met. No webhook sent', [
                    'days_remaining' => $daysRemaining,
                    'km_remaining' => $kmRemaining,
                    'transport_id' => $transport->id
                ]);
            }
        }

        // Log the completion of the check
        Log::info('=== Oil change due check completed ===');
        $this->info('Oil change due check completed.');
    }

    protected function sendToN8nWebhook($transport, $lastOilChange, $daysRemaining, $kmRemaining)
    {
        $data = [
            'plate_number'      => $transport->plate_number,
            'due_in_days'       => $daysRemaining,
            'due_in_km'         => $kmRemaining,
            'oil_change_date'   => $lastOilChange->oil_change_date,
            'next_change_date'  => $lastOilChange->next_change_date,
            'next_change_mileage' => $lastOilChange->next_change_mileage,
        ];

        Log::debug('Sending POST request to webhook', ['url' => 'https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0', 'payload' => $data]);

        $response = Http::post('https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0', $data);

        if ($response->successful()) {
            Log::info('Webhook request sent successfully', [
                'transport_id' => $transport->id,
                'response_status' => $response->status(),
            ]);
        } else {
            // Log an error if the webhook request fails
            Log::error('Failed to send webhook request', [
                'transport_id' => $transport->id,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
        }
    }
}
