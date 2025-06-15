{{-- resources/views/pdf/booking-request.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Request — {{ $tour->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h2, h3 { margin-bottom: .25em; }
        table { width: 100%; border-collapse: collapse; margin: .75em 0; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background: #eee; }
        .no-data { font-style: italic; color: #666; margin-bottom: 1em; }
    </style>
</head>
<body>
    <h1>Booking Request</h1>

    @foreach($tour->tourDays as $day)
        <h2>Day {{ $day->day_number }}: {{ $day->name }}</h2>
@dump($day->rooms->map(fn($r) => [
    'room'     => $r->roomType->type ?? '(no type)',
    'quantity' => $r->pivot->quantity,
]))

        @php
            // Build a map: [ 'twin' => x, 'single' => y, 'double' => z ]
            $counts = collect([
                'twin'   => 0,
                'single' => 0,
                'double' => 0,
            ]);
            foreach ($day->rooms as $room) {
                $type = strtolower($room->roomType->type);
                if ($counts->has($type)) {
                    $counts[$type] += $room->pivot->quantity;
                }
            }
        @endphp

        {{-- Hotel & Room Breakdown --}}
        @if($day->tourDayHotels->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Group</th>
                        <th>Country</th>
                        <th>Guests</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Twin</th>
                        <th>Single</th>
                        <th>Double</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $tour->tour_number }}</td>
                        <td>{{ $tour->country }}</td>
                        <td>{{ $tour->number_people }}</td>
                        <td>{{ $day->check_in->format('Y-m-d H:i') }}</td>
                        <td>{{ $day->check_out->format('Y-m-d H:i') }}</td>
                        <td>{{ $counts['twin'] }}</td>
                        <td>{{ $counts['single'] }}</td>
                        <td>{{ $counts['double'] }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="no-data">No hotel scheduled for this day.</p>
        @endif

        {{-- Transport Booking --}}
        <h3>Transport Booking</h3>
        @if($day->tourDayTransports->isNotEmpty())
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Vehicle Type</th>
                        <th>Pickup</th>
                        <th>Drop-off</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($day->tourDayTransports as $tdt)
                        <tr>
                            <td>{{ ucfirst($tdt->category) }}</td>
                            <td>{{ $tdt->transportType->type }}</td>
                            <td>{{ $day->check_in->format('Y-m-d H:i') }}</td>
                            <td>{{ $day->check_out->format('Y-m-d H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="no-data">No transport scheduled for this day.</p>
        @endif
    @endforeach

    <p style="font-size:10px; text-align:center;">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </p>
</body>
</html>
