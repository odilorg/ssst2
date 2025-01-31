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
                'oil_change_date'     => $lastOilChange->oil_change_date,
                'next_change_date'    => $lastOilChange->next_change_date,
                'next_change_mileage' => $lastOilChange->next_change_mileage,
            ]);

            $nextChangeDate    = Carbon::parse($lastOilChange->next_change_date);
            $nextChangeMileage = $lastOilChange->next_change_mileage;

            // Days remaining (integer) was giving decimals in your logs
            // We'll do total hours for a better breakdown.
            $totalHours  = now()->diffInHours($nextChangeDate, false); // can be negative if overdue
            $kmRemaining = $nextChangeMileage - $transport->current_mileage;

            // Log raw intervals
            Log::info('Calculated remaining intervals', [
                'total_hours'  => $totalHours,
                'km_remaining' => $kmRemaining
            ]);

            // If you still want to check "days <= 3", you can convert total hours:
            $daysRemaining = intdiv($totalHours, 24); // integer division

            if (($daysRemaining <= 3 && $daysRemaining >= 1) || $kmRemaining <= 300) {
                Log::info('Conditions met. Sending data to webhook', [
                    'transport_id' => $transport->id
                ]);
                
                // Pass the $totalHours so we can format "X дней и Y часов"
                $this->sendToN8nWebhook(
                    $transport,
                    $lastOilChange,
                    $totalHours,
                    $daysRemaining,
                    $kmRemaining
                );
            } else {
                Log::info('Conditions NOT met. No webhook sent', [
                    'days_remaining' => $daysRemaining,
                    'km_remaining'   => $kmRemaining,
                    'transport_id'   => $transport->id
                ]);
            }
        }

        Log::info('=== Oil change due check completed ===');
        $this->info('Oil change due check completed.');
    }

    protected function sendToN8nWebhook($transport, $lastOilChange, $totalHours, $daysRemaining, $kmRemaining)
    {
        // Split total hours into days + hours
        $daysPart  = intdiv($totalHours, 24);
        $hoursPart = $totalHours % 24;

        // Build a "days and hours" string in Russian
        // For simplistic plural forms (not perfect Russian grammar):
        $timeString = '';
        
        if ($daysPart > 0) {
            // For 1 day vs multiple days
            $timeString .= ($daysPart === 1)
                ? "1 день"
                : "{$daysPart} дней";
        }

        if ($hoursPart > 0) {
            // If we already have days, add " и "
            if (!empty($timeString)) {
                $timeString .= " и ";
            }
            // For 1 hour vs multiple hours
            $timeString .= ($hoursPart === 1)
                ? "1 час"
                : "{$hoursPart} часов";
        }

        // If totalHours is negative or zero, you might need a fallback
        if ($totalHours <= 0 && empty($timeString)) {
            $timeString = "меньше 24 часов"; 
        } elseif (empty($timeString)) {
            // If it's less than 1 day but still positive
            $timeString = "меньше 24 часов";
        }

        // Format the dates in Russian style "Февраль 3, 2025"
        // Make sure your server has 'ru_RU' or similar installed
        Carbon::setLocale('ru');

        // If lastOilChange->oil_change_date is not null, parse & format
        $lastChangeDate = $lastOilChange->oil_change_date
            ? Carbon::parse($lastOilChange->oil_change_date)->isoFormat('MMMM D, YYYY')
            : 'неизвестно';

        $nextChangeDate = $lastOilChange->next_change_date
            ? Carbon::parse($lastOilChange->next_change_date)->isoFormat('MMMM D, YYYY')
            : 'неизвестно';

        // Construct the final output message
        $message =
            "Замена масла для транспорта: {$transport->plate_number}\n" .
            "Должна быть выполнена через {$timeString} или {$kmRemaining} км.\n\n" .
            "Последняя замена масла: {$lastChangeDate}\n" .
            "Следующая замена масла: {$nextChangeDate} или при пробеге " .
            "{$lastOilChange->next_change_mileage} км.";

        Log::debug('Sending POST request to webhook with message', ['message' => $message]);

        // Send the entire message plus separate data fields
        $response = Http::post('https://jahongir-app.uz/n8n/webhook/35f85b50-628f-4bdc-b0dd-6cf57ed392a0', [
            'message'             => $message,
            'plate_number'        => $transport->plate_number,
            'days_remaining'      => $daysRemaining,    // integer days
            'total_hours'         => $totalHours,       // total hours left
            'due_in_km'           => $kmRemaining,
            'oil_change_date'     => $lastOilChange->oil_change_date,
            'next_change_date'    => $lastOilChange->next_change_date,
            'next_change_mileage' => $lastOilChange->next_change_mileage,
        ]);

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
