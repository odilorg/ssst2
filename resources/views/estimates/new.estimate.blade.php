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
        <img src="{{ asset('storage/foot-logo.svg') }}" alt="Company Logo">
    </div>

    <h1>Estimate for {{ $tour->name }}</h1>
    <p><strong>Description:</strong> {{ $tour->description }}</p>
    <p><strong>Duration:</strong> {{ $tour->tour_duration }} days</p>
    <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($tour->start_date)->format('d-m-Y') }}</p>
    <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($tour->end_date)->format('d-m-Y') }}</p>
    <p><strong>Number of People:</strong> {{ $tour->number_people }}</p>
    <!--    <p><strong>Tour Number:</strong> {{ $tour->tour_number }}</p> -->

    <h2>Tour Days</h2>
    @php
        $totalCost = 0; // Initialize total cost
        $hotelCategoryCounts = [];
        $transportDescriptions = [];
        $mealTypes = [];

        // $acoomodationCategory = '';
        // $TransportationName = '';

    @endphp
    <!-- Main Tour details -->

    @foreach ($tour->tourDays as $day)
        <h3>Day {{ $loop->iteration }}: {{ $day->name }}</h3>
        <p><strong>Description:</strong> {{ $day->description }}</p>

        @php
            $dayCost = 0; // Initialize daily cost
        @endphp

        @php
            $dayCost += $day->guide->daily_rate;
        @endphp
        <!-- Transport details -->
            @foreach ($day->tourDayTransports as $transport)
                @php
                    // Get the transport description (e.g., type and features)
                    $description = $transport->transportType->category ?? 'Unknown transport';

                    // Avoid duplicates
                    if (!in_array($description, $transportDescriptions)) {
                        $transportDescriptions[] = $description;
                    }

                    // Calculate the transport price
                    $transportPrice =
                        $transport->transportType->transportPrices->where('price_type', $transport->price_type)->first()
                            ?->cost ?? 0;
                    $dayCost += $transportPrice;
                @endphp
            @endforeach
        <!-- Hotel details -->

        @foreach ($tour->tourDays as $day)
            @php
                $category = $day->hotel->category ?? 'Unknown';
                $hotelCategoryCounts[$category] = ($hotelCategoryCounts[$category] ?? 0) + 1;

            @endphp
        @endforeach


        <!-- Monument details -->

        <h4>Monuments</h4>
        <ul>
            @forelse ($day->monuments as $monument)
                @php
                    $dayCost += $monument->ticket_price;
                @endphp
                <li>{{ $monument->name }} (Description:{{ $monument->description }})</li>
            @empty
            @endforelse
        </ul>
        <!-- Meals details -->

        @forelse ($day->mealTypeRestaurantTourDays as $meal)
            @php
                // Define human-readable labels for meal types
                $mealTypeLabels = [
                    'breakfast' => 'Завтрак',
                    'lunch' => 'Обед',
                    'dinner' => 'Ужин',
                    'coffee_break' => 'Кофе брейк',
                ];

                // Get the meal type name in a human-readable format
                $mealTypeName = $mealTypeLabels[$meal->mealType->name ?? ''] ?? ($meal->mealType->name ?? 'N/A');

                // Avoid duplicates
                if (!in_array($mealTypeName, $mealTypes)) {
                    $mealTypes[] = $mealTypeName;
                }

                // Calculate costs
                $mealCostPerPerson = $meal->mealType->price ?? 0;
                $mealCost = $mealCostPerPerson * ($tour->number_people ?? 1); // Multiply by number of people
                $dayCost += $mealCost;
            @endphp
            <li>
                {{ $mealTypeName }} at {{ $meal->restaurant?->name ?? 'N/A' }}
            </li>
        @empty
        @endforelse



        @php
            $totalCost += $dayCost;
        @endphp
        <hr>
    @endforeach
    <!-- Included and Not included details -->

    <h2>Include</h2>
    <ul>
        <li><strong>Accommodation:</strong>
            @foreach ($hotelCategoryCounts as $category => $count)
                {{ $count }} nights in {{ $category }} hotel with breakfast<br>
            @endforeach
        </li>

        <li><strong>Transportation:</strong> Comfortable {{ implode(', ', $transportDescriptions) }} with Air
            Conditioner</li>
        <!--<li><strong>Flights:</strong> {{ $tour->flights ?? 'In Uzbekistan (Tashkent - Urgench)' }}</li>-->
        <li><strong>Visa Support:</strong> 'Provided for all participants' </li>
        <li><strong>Meals:</strong> {{ $tour->meals ?? 'Lunch, Dinner' }}</li>
    </ul>

    <h2>Not Include</h2>
    <ul>
        <li>International flights</li>
        <li>Entrance Fees to the monuments and places</li>
        <li>
            @if (!empty($mealTypes))
        <li><strong>Meals:</strong> ({{ implode(', ', $mealTypes) }})</li>
    @else
        <li><strong>Meals:</strong> None</li>
        @endif
        </li>
        <li>All things that are not entered in the "Include" section</li>
    </ul>
    <!-- Total Cost details -->

    <h2>Total Cost of the Tour: ${{ number_format($totalCost, 2) }}</h2>
</body>

</html>
