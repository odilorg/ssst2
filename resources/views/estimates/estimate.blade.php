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
        <img src="{{ public_path('foot-logo.svg') }}" alt="Company Logo">
    </div>

    <h1>Estimate for {{ $tour->name }}</h1>
    <p><strong>Description:</strong> {{ $tour->description }}</p>
    <p><strong>Duration:</strong> {{ $tour->tour_duration }} days</p>
    <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($tour->start_date)->format('d-m-Y') }}</p>
    <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($tour->end_date)->format('d-m-Y') }}</p>
    <p><strong>Number of People:</strong> {{ $tour->number_people }}</p>

    <h2>Tour Days</h2>
    @php
        $totalCost = 0;
        $hotelCategoryLabels = [
            'bed_breakfast' => 'B&B',
            '3_star' => '3 Star',
            '4_star' => '4 Star',
            '5_star' => '5 Star',
        ];
        $transportTypeLabels = [
            'bus' => 'Bus',
            'car' => 'Car',
            'mikro_bus' => 'Mikro Bus',
            'mini_van' => 'Mini Van',
            'air' => 'Air',
            'rail' => 'Rail',
        ];
        $mealTypeLabels = [
            'breakfast' => 'Breakfast',
            'lunch' => 'Lunch',
            'dinner' => 'Dinner',
            'coffee_break' => 'Coffee Break',
        ];
    @endphp

    @foreach ($tour->tourDays as $day)
        <h3>Day {{ $loop->iteration }}: {{ $day->name }}</h3>
        <p><strong>Description:</strong> {{ $day->description }}</p>
        <p><strong>Cities:</strong> {{ $day->cities->pluck('name')->join(', ') }}</p>

        @php
            $accommodations = $day->tourDayHotels->map(function ($hotel) use ($hotelCategoryLabels) {
                $hotelCategory = $hotelCategoryLabels[$hotel->type ?? ''] ?? 'N/A';
                $roomDetails = $hotel->hotelRooms->map(function ($room) {
                    return "{$room->quantity} x {$room->room->roomType->type}";
                })->join(', ');

                return "{$hotel->hotel->name} ({$hotelCategory}): {$roomDetails}";
            })->join('; ');

            $transportDetails = $day->tourDayTransports->map(fn($transport) => $transportTypeLabels[$transport->transportType->category ?? ''] ?? 'N/A')->join(', ');

            $mealDetails = $day->mealTypeRestaurantTourDays->map(
                fn($meal) => $mealTypeLabels[$meal->mealType->name ?? ''] ?? 'N/A'
            )->join(', ');

            $monumentNames = $day->monuments->pluck('name')->join(', ');

            $guideCost = $day->guide?->daily_rate ?? 0;

            $transportCost = $day->tourDayTransports->sum(fn($transport) => $transport->transportType->transportPrices->where('price_type', $transport->price_type)->first()?->cost ?? 0);

            $accommodationCost = $day->tourDayHotels->sum(fn($hotel) => $hotel->hotelRooms->sum(fn($room) => ($room->room?->cost_per_night ?? 0) * ($room->quantity ?? 0)));

            $mealCost = $day->mealTypeRestaurantTourDays->sum(fn($meal) => ($meal->mealType->price ?? 0) * $tour->number_people);

            $monumentCost = $day->monuments->sum('ticket_price') * $tour->number_people;

            $dayCost = $guideCost + $transportCost + $accommodationCost + $mealCost + $monumentCost;
            $totalCost += $dayCost;
        @endphp

        <p><strong>Accommodation:</strong> {{ $accommodations }}</p>
        <p><strong>Guide:</strong> {{ $day->guide?->languages->pluck('name')->join(', ') ?? 'N/A' }}</p>
        <p><strong>Transport:</strong> {{ $transportDetails }}</p>
        <p><strong>Meals:</strong> {{ $mealDetails }}</p>
        <p><strong>Monuments:</strong> {{ $monumentNames }}</p>
        <p><strong>Day Cost Breakdown:</strong></p>
        <ul>
            <li>Guide Cost: ${{ number_format($guideCost, 2) }}</li>
            <li>Transport Cost: ${{ number_format($transportCost, 2) }}</li>
            <li>Accommodation Cost: ${{ number_format($accommodationCost, 2) }}</li>
            <li>Meal Cost: ${{ number_format($mealCost, 2) }}</li>
            <li>Monument Cost: ${{ number_format($monumentCost, 2) }}</li>
        </ul>
        <p><strong>Total Day Cost:</strong> ${{ number_format($dayCost, 2) }}</p>
        <hr>
    @endforeach

    <h2>Total Cost of the Tour: ${{ number_format($totalCost, 2) }}</h2>
</body>

</html>

