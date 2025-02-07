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
        <strong>Driver Name:</strong> {{ $itinerary->transport->driver->name }}<br>
        <strong>Tour Group #:</strong> {{ $itinerary->tour_group_code }}<br>
        <strong>Number of People:</strong> {{ $itinerary->tour->number_people}}<br>
        <strong>Car Brand:</strong> {{ $itinerary->transport->transportType->type }}<br>
        <strong>Plate Number:</strong> {{ $itinerary->transport->plate_number }}<br>
        <strong>Start KM:</strong> {{ $itinerary->start_km }}<br>
        <strong>End KM:</strong> {{ $itinerary->end_km }}
    </div>

    <h1>Tour Itinerary</h1>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Sana</th>
                <th>Yo'nalish</th>
                <th>Vaqt</th>
                <th>Dastur</th>
                <th>Yoqilg'i sarfi</th>
                <th>Yoqilg'i sarfi fakt.</th>
                <th>Projivanie</th>
                <th>Pitanie</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itinerary->itinerary as $index => $itin)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $itin['date'] }}</td>
                <td>{{ $itin['destination'] }}</td>
                <td>{{ $itin['pickup_time'] }}</td>
                <td>{{ $itin['program'] }}</td>
                <td>15</td>
                <td>17</td>
                <td>{{ $itin['accommodation'] ? 'Yes' : 'No' }}</td>
                <td>{{ $itin['food'] ? 'Yes' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
