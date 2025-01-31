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

            $daysRemaining = now()->diffInDays($nextChangeDate, false); // Negative if overdue
            $kmRemaining = $nextChangeMileage - $transport->current_mileage;

            Log::info('Calculated remaining intervals', [
                'days_remaining' => $daysRemaining,
                'km_remaining' => $kmRemaining
            ]);

            // Check if days remaining is 3, 2, or 1 OR if mileage is within 300 KM
            if (($daysRemaining <= 3 && $daysRemaining >= 1) || $kmRemaining <= 300) {
                Log::info('Conditions met. Sending data to webhook', [
                    'transport_id' => $transport->id
                ]);

                $this->sendToN8nWebhook(
                    $transport,
                    $lastOilChange,
                    $daysRemaining,
                    $kmRemaining,
                    $nextChangeDate
                );
            } else {
                Log::info('Conditions NOT met. No webhook sent', [
                    'days_remaining' => $daysRemaining,
                    'km_remaining' => $kmRemaining,
                    'transport_id' => $transport->id
                ]);
            }
        }

        Log::info('=== Oil change due check completed ===');
        $this->info('Oil change due check completed.');
    }

    /**
     * Send data to the N8N webhook.
     */
    protected function sendToN8nWebhook($transport, $lastOilChange, $daysRemaining, $kmRemaining, $nextChangeDate)
    {
        // 1) Calculate a more precise "days and hours" difference
        //    This counts total hours, splits into days & hours
        $totalHours = now()->diffInHours($nextChangeDate, false);
        $daysPart   = intdiv($totalHours, 24);
        $hoursPart  = $totalHours % 24;

        // Build a human-friendly time string: "1 день и 20 часов"
        // (Very simplified Russian pluralization)
        $timeString = '';
        if ($daysPart > 0) {
            // For 1 day vs. multiple days
            $timeString .= ($daysPart === 1)
                ? '1 день'
                : $daysPart . ' дней';
        }
        if ($hoursPart > 0) {
            if (!empty($timeString)) {
                $timeString .= ' и ';
            }
            // For 1 hour vs. multiple hours
            $timeString .= ($hoursPart === 1)
                ? '1 час'
                : $hoursPart . ' часов';
        }

        // If there's no days or hours left (maybe already overdue?), fallback
        if (!$timeString) {
            // Could show "0 дней" or handle overdue scenario
            $timeString = 'меньше 24 часов';
        }

        // 2) Format dates in a "Январь 3, 2025" style
        //    Make sure your server/container is set to locale "ru_RU" or similar
        Carbon::setLocale('ru'); // sets Carbon’s locale for month names, etc.

        $formattedNextChangeDate = $nextChangeDate->isoFormat('MMMM D, YYYY');
        $formattedLastChangeDate = Carbon::parse($lastOilChange->oil_change_date)
                                         ->isoFormat('MMMM D, YYYY');

        // 3) Build a single text message
        $message = 
            "Замена масла для транспорта: {$transport->plate_number}\n" .
            "Должна быть выполнена через {$timeString} или {$kmRemaining} км.\n\n" .
            "Последняя замена масла: {$formattedLastChangeDate}\n" .
            "Следующая замена масла: {$formattedNextChangeDate} или при пробеге " .
            "{$lastOilChange->next_change_mileage} км.";

        // 4) Log & send it to your webhook
        Log::debug('Sending POST request to webhook with message', ['message' => $message]);

        // You can send this entire $message, or pass it as multiple fields.
        // Example: Put the entire text in "message"
        $response = Http::post(
            'https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0',
            [
                'message'               => $message,
                'plate_number'          => $transport->plate_number,
                'due_in_days'           => $daysRemaining,
                'due_in_km'             => $kmRemaining,
                'oil_change_date'       => $lastOilChange->oil_change_date,
                'next_change_date'      => $lastOilChange->next_change_date,
                'next_change_mileage'   => $lastOilChange->next_change_mileage,
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
