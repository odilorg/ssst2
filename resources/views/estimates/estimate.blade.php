<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Estimate for {{ $tour->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
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

    <div class="logo">
        <img src="{{ asset('storage/foot-logo.svg') }}" alt="Company Logo">
    </div>

    <h1>Estimate for {{ $tour->name }}</h1>
    <p><strong>Description:</strong> {{ $tour->description }}</p>
    <p><strong>Duration:</strong> {{ $tour->duration }} days</p>
    <p><strong>Start Date:</strong> {{ $tour->start_date }}</p>
    <p><strong>End Date:</strong> {{ $tour->end_date }}</p>
    <p><strong>Number of People:</strong> {{ $tour->number_people }}</p>
    <p><strong>Tour Number:</strong> {{ $tour->tour_number }}</p>

    <h2>Tour Days</h2>
    @php
        $totalCost = 0; // Initialize total cost
    @endphp
    <!--Main Tour Details-->
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
                    <th>Price Type</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($day->tourDayTransports as $tourDayTransport)
                    @php
                    $transportPaymentLabels = [
                                'per_day' => 'Per Day',
                                'per_pickup_dropoff' => 'Per Pickup Dropoff',
                                'po_gorodu' => 'Po Gorodu',
                                'vip' => 'VIP',
                                'economy' => 'Economy',
                                'business' => 'Business',
                    ];

                    // Get the meal type name in a human-readable format
                    $transportPaymentName = $transportPaymentLabels[$tourDayTransport->price_type ?? ''] ?? ($tourDayTransport->price_type ?? 'N/A');
                        // Access transport type and calculate transport price
                        $transportPrice = $tourDayTransport->transportType->transportPrices
                            ->where('price_type', $tourDayTransport->price_type)
                            ->first()?->cost ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $tourDayTransport->transportType->type ?? 'N/A' }}</td>
                        <td>{{ $transportPaymentName ?? 'N/A' }}</td>
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
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($day->hotelRooms as $hotelRoom)
                    @php
                        $roomCost = ($hotelRoom->hotelRoom?->cost_per_night ?? 0) * ($hotelRoom->quantity ?? 0);
                        $dayCost += $roomCost;
                    @endphp
                    <tr>
                        <td>{{ $hotelRoom->hotelRoom?->roomType?->type ?? 'N/A' }}</td>
                        <td>${{ number_format($hotelRoom->hotelRoom?->cost_per_night ?? 0, 2) }}</td>
                        <td>{{ $hotelRoom->quantity ?? 0 }}</td>
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
                    // Define human-readable labels for meal types
                    $mealTypeLabels = [
                        'breakfast' => 'Zavtrak',
                        'lunch' => 'Obed',
                        'dinner' => 'Ujin',
                        'coffee_break' => 'Cofee Break',
                    ];

                    // Get the meal type name in a human-readable format
                    $mealTypeName = $mealTypeLabels[$meal->mealType->name ?? ''] ?? ($meal->mealType->name ?? 'N/A');

                    // Calculate costs
                    $mealCostPerPerson = $meal->mealType->price ?? 0;
                    $mealCost = $mealCostPerPerson * ($tour->number_people ?? 1); // Multiply by number of people
                    $dayCost += $mealCost;
                @endphp
                <li>
                    {{ $mealTypeName }} at {{ $meal->restaurant?->name ?? 'N/A' }}
                    (Price Per Person: ${{ number_format($mealCostPerPerson, 2) }},
                    Total: ${{ number_format($mealCost, 2) }})
                </li>
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
