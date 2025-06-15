{{-- resources/views/pdf/booking-request.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Request — {{ $tour->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-top: 1em; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1em; }
        th, td { border: 1px solid #444; padding: 4px; }
        th { background: #eee; text-align: left; }
    </style>
</head>
<body>
    <h1>Booking Request</h1>
    <p>
        <strong>Tour:</strong> {{ $tour->name }}<br>
        <strong>Request Date:</strong> {{ \Carbon\Carbon::parse($request->date)->format('Y-m-d') }}
    </p>

    @foreach($tour->tourDays as $day)
        <h2>Day {{ $loop->iteration }}: {{ $day->name }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Booked?</th>
                </tr>
            </thead>
            <tbody>
            @foreach($day->tourDayHotels as $tdh)
                <tr>
                    <td>{{ $tdh->hotel->name }}</td>
                    <td>{{ optional($tdh->check_in)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td>{{ optional($tdh->check_out)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td>{!! $tdh->is_booked ? '&#10003;' : '&#10005;' !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach

    <p style="font-size:10px; text-align:center;">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </p>
</body>
</html>
