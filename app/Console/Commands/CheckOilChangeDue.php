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
            Log::info('Processing transport', [
                'transport_id' => $transport->id,
                'plate_number' => $transport->plate_number
            ]);

            $lastOilChange = OilChange::where('transport_id', $transport->id)
                ->latest('oil_change_date')
                ->first();
            
            if (!$lastOilChange) {
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

            // We use floatDiffInDays so we get a decimal value, then round to 1 digit
            $daysDecimal = now()->floatDiffInDays($nextChangeDate, false); 
            $daysRemaining = round($daysDecimal, 1);  // e.g. 2.6 days

            $kmRemaining = $nextChangeMileage - $transport->current_mileage;

            Log::info('Calculated remaining intervals', [
                'days_remaining_decimal' => $daysRemaining,
                'km_remaining' => $kmRemaining
            ]);

            // Our existing condition
            if (($daysRemaining <= 3 && $daysRemaining >= 1) || $kmRemaining <= 300) {
                Log::info('Conditions met. Sending data to webhook', [
                    'transport_id' => $transport->id
                ]);
                
                $this->sendToN8nWebhook(
                    $transport,
                    $lastOilChange,
                    $daysRemaining,
                    $kmRemaining
                );
            } else {
                Log::info('Conditions NOT met. No webhook sent', [
                    'days_remaining_decimal' => $daysRemaining,
                    'km_remaining' => $kmRemaining,
                    'transport_id' => $transport->id
                ]);
            }
        }

        Log::info('=== Oil change due check completed ===');
        $this->info('Oil change due check completed.');
    }

    protected function sendToN8nWebhook($transport, $lastOilChange, $daysRemaining, $kmRemaining)
    {
        // Format the dates as dd-mm-yyyy
        $formattedLastChangeDate = Carbon::parse($lastOilChange->oil_change_date)
            ->format('d-m-Y');
        $formattedNextChangeDate = Carbon::parse($lastOilChange->next_change_date)
            ->format('d-m-Y');

        // Build the final text message
        $message = 
            "Замена масла для транспорта : {$transport->plate_number}\n" .
            "Должна быть выполнена через  {$daysRemaining} дней или {$kmRemaining} км.\n" .
            "Последняя замена масла: {$formattedLastChangeDate}\n" .
            "Следующая замена масла:{$formattedNextChangeDate}  или при пробеге {$lastOilChange->next_change_mileage} км.\n\n" .
            "This message was sent automatically with n8n (https://n8n.io/?utm_source=n8n-internal&utm_medium=powered_by&utm_campaign=n8n-nodes-base.telegram)";

        // Log for debugging
        Log::debug('Sending POST request to webhook with message', ['message' => $message]);

        // Send it
        $response = Http::post(
            'https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0',
            [
                // Could pass the entire text as "message", plus any fields you want
                'message' => $message,

                // Additional fields:
                'plate_number'        => $transport->plate_number,
                'due_in_days'         => $daysRemaining,
                'due_in_km'           => $kmRemaining,
                'oil_change_date'     => $lastOilChange->oil_change_date,
                'next_change_date'    => $lastOilChange->next_change_date,
                'next_change_mileage' => $lastOilChange->next_change_mileage,
            ]
        );

        if ($response->successful()) {
            Log::info('Webhook request sent successfully', [
                'transport_id'    => $transport->id,
                'response_status' => $response->status(),
            ]);
        } else {
            Log::error('Failed to send webhook request', [
                'transport_id' => $transport->id,
                'status'       => $response->status(),
                'response'     => $response->body(),
            ]);
        }
    }
}
