<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Itinerary Report</title>
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #ffffff;
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
            font-size: 14px;
            min-width: 600px;
            text-align: left;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table th {
            background-color: #f3f3f3;
            color: #000000;
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
            <img src="{{ storage_path($itinerary->transport->company->logo) }}" alt="Company Logo">
        </div>
        <div class="company-info">
            <strong>{{ $itinerary->transport->company->name }}</strong><br>
            Address: {{ $itinerary->transport->company->address_street }} , {{ $itinerary->transport->company->address_city }}<br>
            Phone: {{ $itinerary->transport->company->phone }}<br>
            Email: {{ $itinerary->transport->company->email }}
        </div>
    </div>

    <hr>

    <div class="tour-info">
        <strong>Shofer Ismi:</strong> {{ $itinerary->transport->driver->name ?? 'N/A' }}<br>
        <strong>Tour Group #:</strong> {{ $itinerary->tour_group_code }}<br>
        <strong>Odam Soni:</strong> {{ $itinerary->tour->number_people ?? 'N/A' }}<br>
        <strong>Transport:</strong> {{ $itinerary->transport->transportType->type ?? 'N/A' }}<br>
        <strong>Davlat raqami:</strong> {{ $itinerary->transport->plate_number }}<br>
        <strong>Boshlangich KM:</strong> {{ $itinerary->km_start }}<br>
        <strong>Tugash KM:</strong> {{ $itinerary->km_end }}
    </div>

    <h1>Marshrutniy List</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th style="width: 90px;">Sana</th>
                <th style="width: 180px;">Yo'nalish</th>
                <th>Vaqt</th>
                <th style="width: 120px;">Programma</th>
                <th>Proj.</th>
                <th>Pit.</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($itinerary->itineraryItems as $index => $itin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($itin->date)->format('d-m-Y') }}</td>
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
    <!-- Theoretical Fuel Usage -->
    <li>
        <strong>Yoqilg'i kerak marshrut uchun :</strong>
        {{ $itinerary->fuel_expenditure }} liters
    </li>

    @php
        // Convert null to 0 for an easy numeric check.
        $actualFuel = $itinerary->fuel_expenditure_factual ?? 0;
    @endphp

    <!-- Display Actual Fuel Expenditure & Remaining Fuel only if $actualFuel > 0 -->
    @if ($actualFuel > 0)
        <li>
            <strong>Fakticheski Rashod Topliva :</strong>
            {{ $itinerary->fuel_expenditure_factual }} liters
        </li>
        <li>
            <strong>Ostatok Topliva v etom marshrute :</strong>
            {{ $itinerary->fuel_remaining_liter ?? 0 }} liters
        </li>
        <li>
            <strong>Ostatok Topliva :</strong>
            {{ $itinerary->transport->fuel_remaining_liter ?? 0 }} liters
        </li>
    @endif

    <!-- Other calculations remain unchanged -->
    <li>
        <strong>Projivanie :</strong>
        {{ $accCost }} $
    </li>
    <li>
        <strong>Pitanie :</strong>
        {{ $foodCost }} $
    </li>
    <li>
        <strong>Jami :</strong>
        {{ $totalCost }} $
    </li>
</ul>





</body>
</html>
