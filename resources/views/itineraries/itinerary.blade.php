<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Itinerary Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            height: 60px;
        }
        .company-info {
            text-align: right;
            font-size: 14px;
        }
        hr {
            border: 1px solid #009879;
            margin: 10px 0;
        }
        .tour-info {
            font-size: 16px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            min-width: 600px;
            text-align: left;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #009879;
            color: #ffffff;
            font-weight: bold;
        }
        table tr:nth-child(even) {
            background-color: #f3f3f3;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <img src="logo.png" alt="Company Logo">
        </div>
        <div class="company-info">
            <strong>Company Name</strong><br>
            Address: 1234 Street, City, Country<br>
            Phone: +123 456 7890<br>
            Email: contact@company.com
        </div>
    </div>

    <hr>

    <div class="tour-info">
        <strong>Driver Name:</strong> {{ $itinerary->transport->driver->name ?? 'N/A' }}<br>
        <strong>Tour Group #:</strong> {{ $itinerary->tour_group_code }}<br>
        <strong>Number of People:</strong> {{ $itinerary->tour->number_people ?? 'N/A' }}<br>
        <strong>Car Brand:</strong> {{ $itinerary->transport->transportType->type ?? 'N/A' }}<br>
        <strong>Plate Number:</strong> {{ $itinerary->transport->plate_number }}<br>
        <strong>Start KM:</strong> {{ $itinerary->km_start }}<br>
        <strong>End KM:</strong> {{ $itinerary->km_end }}
    </div>

    <h1>Tour Itinerary</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Destination</th>
                <th>Pickup Time</th>
                <th>Program</th>
                <th>Accommodation</th>
                <th>Food</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itinerary->itineraryItems as $index => $itin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $itin->date }}</td>
                <td>{{ optional($itin->cityDistance)->city_from_to ?? 'N/A' }}</td>
                <td>{{ $itin->time ?? 'N/A' }}</td>
                <td>{{ $itin->program ?? 'N/A' }}</td>
                <td>{{ $itin->accommodation ? 'Yes' : 'No' }}</td>
                <td>{{ $itin->food ? 'Yes' : 'No' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7">No itinerary items found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @php
        // Count how many itinerary items have accommodation or food
        $accommodationCount = $itinerary->itineraryItems->where('accommodation', true)->count();
        $foodCount = $itinerary->itineraryItems->where('food', true)->count();

        // Some example cost calculations
        $accCost = $accommodationCount * 10;
        $foodCost = $foodCount * 5;
        $totalCost = $accCost + $foodCost;

        // If you prefer, you can store actualDistance in a variable
        $actualDistance = ($itinerary->km_end ?? 0) - ($itinerary->km_start ?? 0);
    @endphp

<ul>
    <li>
        <strong>Theoretical Fuel Expenditure:</strong>
        {{ $itinerary->fuel_expenditure }} liters
    </li>
    <li>
        <strong>Actual Fuel Expenditure:</strong>
        {{ $itinerary->fuel_expenditure_factual  }} liters
    </li>

    @php
        $actualDistance = ($itinerary->km_end ?? 0) - ($itinerary->km_start ?? 0);
    @endphp
    <li>
        <strong>Fakticheski Proexali KM (Real Distance):</strong>
        {{ $actualDistance }} km
    </li>

    {{-- 
         Instead of $itinerary->fuel_remaining_liter
         we use $itinerary->transport->fuel_remaining_liter 
    --}}
    @if ($itinerary->transport->fuel_remaining_liter < 0)
        <li>
            <strong>Actual usage exceeded theoretical by:</strong>
            {{ abs($itinerary->transport->fuel_remaining_liter) }} liters
        </li>
    @else
        <li>
            <strong>Ostatok Topliva (Remaining Fuel):</strong>
            {{ $itinerary->transport->fuel_remaining_liter }} liters
        </li>
    @endif

    <!-- The rest of your calculations remain the same -->
    <li><strong>Projivanie (Accommodation):</strong> {{ $accCost }} $</li>
    <li><strong>Pitanie (Food):</strong> {{ $foodCost }} $</li>
    <li><strong>Jami (Total):</strong> {{ $totalCost }} $</li>
</ul>



</body>
</html>
