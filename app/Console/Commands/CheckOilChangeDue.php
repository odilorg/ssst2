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
        $transports = Transport::all();

        foreach ($transports as $transport) {
            $lastOilChange = OilChange::where('transport_id', $transport->id)
                ->latest('oil_change_date')
                ->first();

            if ($lastOilChange) {
                $nextChangeDate = Carbon::parse($lastOilChange->next_change_date);
                $nextChangeMileage = $lastOilChange->next_change_mileage;

                $dueDate = $nextChangeDate->subDays(3);
                $dueMileage = $nextChangeMileage - 300;

                if (Carbon::now() >= $dueDate || $transport->current_mileage >= $dueMileage) {
                    // Oil change is due, send data to n8n webhook
                    $this->sendToN8nWebhook($transport, $lastOilChange);
                }
            }
        }

        $this->info('Oil change due check completed.');
    }

    protected function sendToN8nWebhook($transport, $lastOilChange)
    {
        // Prepare the data to send to n8n
        $data = [
            'plate_number' => $transport->plate_number,
            'due_in_days' => 3,
            'due_in_km' => 300,
            'oil_change_date' => $lastOilChange->oil_change_date,
            'next_change_date' => $lastOilChange->next_change_date,
            'next_change_mileage' => $lastOilChange->next_change_mileage,
        ];

        // Send the POST request to the n8n webhook URL
        $response = Http::post('https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0', $data);

        // Log the response for debugging
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
