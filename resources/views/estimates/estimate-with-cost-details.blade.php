<!DOCTYPE html>
<html>
<head>
    <title>Estimate for {{ $tour->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Estimate for {{ $tour->name }}</h1>
    <p><strong>Description:</strong> {{ $tour->description }}</p>
    <p><strong>Duration:</strong> {{ $tour->duration }} days</p>
    <p><strong>Start Date:</strong> {{ $tour->start_date }}</p>
    <p><strong>End Date:</strong> {{ $tour->end_date }}</p>

    <h2>Tour Days</h2>
    @php
        $totalCost = 0; // Initialize total cost
    @endphp

    @foreach ($tour->tourDays as $day)
        <h3>Day {{ $loop->iteration }}: {{ $day->name }}</h3>
        <p><strong>Description:</strong> {{ $day->description }}</p>

        @php
            $dayCost = 0; // Initialize daily cost
        @endphp

        <p><strong>Guide:</strong> {{ $day->guide?->name ?? 'Not Assigned' }} 
            @if ($day->guide)
                (Daily Rate: ${{ number_format($day->guide->daily_rate, 2) }})
                @php
                    $dayCost += $day->guide->daily_rate;
                @endphp
            @endif
        </p>

        <h4>Transport Details</h4>
        <table>
            <thead>
                <tr>
                    <th>Transport Type</th>
                    <th>Model</th>
                    <th>Price Type</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($day->tourDayTransports as $transport)
                    @php
                        $transportPrice = $transport->transport->transportType->transportPrices
                            ->where('price_type', $transport->price_type)
                            ->first()?->cost ?? 0;

                        $dayCost += $transportPrice;
                    @endphp
                    <tr>
                        <td>{{ $transport->transport->transportType->type ?? 'N/A' }}</td>
                        <td>{{ $transport->transport->model ?? 'N/A' }}</td>
                        <td>{{ $transport->price_type === 'per_day' ? 'Per Day' : 'Per Pickup/Dropoff' }}</td>
                        <td>${{ number_format($transportPrice, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No transport assigned</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h4>Hotel Details</h4>
        <p><strong>Hotel:</strong> {{ $day->hotel?->name ?? 'Not Assigned' }}</p>
        <table>
            <thead>
                <tr>
                    <th>Room Type</th>
                    <th>Cost Per Night</th>
                    <th>Total Rooms</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($day->hotel?->rooms as $room)
                    @php
                        $dayCost += $room->cost_per_night; // Add room cost to the daily cost
                    @endphp
                    <tr>
                        <td>{{ $room->name }}</td>
                        <td>${{ number_format($room->cost_per_night, 2) }}</td>
                        <td>{{ $room->quantity ?? 1 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No rooms assigned</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h4>Monuments</h4>
        <ul>
            @forelse ($day->monuments as $monument)
                @php
                    $dayCost += $monument->ticket_price;
                @endphp
                <li>{{ $monument->name }} (Ticket Price: ${{ number_format($monument->ticket_price, 2) }})</li>
            @empty
                <li>No monuments assigned</li>
            @endforelse
        </ul>

        <h4>Meals</h4>
        <ul>
            @forelse ($day->mealTypeRestaurantTourDays as $meal)
                @php
                    $mealCost = $meal->mealType->price ?? 0;
                    $dayCost += $mealCost;
                @endphp
                <li>{{ $meal->mealType->name ?? 'N/A' }} at {{ $meal->restaurant?->name ?? 'N/A' }} (Price: ${{ number_format($mealCost, 2) }})</li>
            @empty
                <li>No meals assigned</li>
            @endforelse
        </ul>

        <p><strong>Day {{ $loop->iteration }} Cost:</strong> ${{ number_format($dayCost, 2) }}</p>
        @php
            $totalCost += $dayCost;
        @endphp
        <hr>
    @endforeach

    <h2>Total Cost of the Tour: ${{ number_format($totalCost, 2) }}</h2>
</body>
</html>
