{{-- resources/views/pdf/booking-request.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Request — {{ $tour->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1, h2 { margin-bottom: .25em; }
        table { width: 100%; border-collapse: collapse; margin: .75em 0; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background: #eee; }
        .no-data { font-style: italic; color: #666; margin-bottom: 1em; }
         /* ── HEADER STYLES ───────────────────────────────────────── */
    .company-header { text-align: center; margin-bottom: 1em; }
    .company-title {
        font-family: 'Times New Roman', serif;
        font-size: 32px;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin: 0;
    }
    .company-subtitles {
        display: grid;
        grid-template-columns: 1fr 1fr;
        font-size: 12px;
        text-transform: uppercase;
        margin: .25em 0;
        font-weight: bold;
    }
    .company-subtitles span {
        padding: 0 .5em;
    }
    .thin-line {
        border: none;
        border-top: 1px solid #000;
        margin: .25em 0;
    }
    .heavy-line {
        border: none;
        border-top: 2px solid #000;
        margin: .25em 0;
    }
    .company-contact {
        font-size: 10px;
        margin: .25em 0;
    }
    </style>
</head>
<body>
    {{-- right after <body> --}}
<div class="company-header">
    {{-- 1) Main title with quotes --}}
    <h1 class="company-title">"{{ $company->name }}"</h1>

    {{-- 2) Two‐column subtitles (Uzbek | English) --}}
    <div class="company-subtitles">
        <span>{{ strtoupper($company->address_city) }} shahr mas'uliyati cheklangan jamiyat</span>
        <span>{{ strtoupper($company->address_city) }} city limited liability company</span>
    </div>

    {{-- 3) Thin separator --}}
    <hr class="thin-line">

    {{-- 4) Contact line --}}
    <p class="company-contact">
        {{ $company->address_city }} sh., {{ $company->address_street }} &nbsp;
        Tel.: {{ $company->phone }}@unless(empty($company->email)) | {{ $company->email }}@endunless
    </p>

    {{-- 5) Heavy separator --}}
    <hr class="heavy-line">
</div>

    <h1>Booking Request</h1>

    @foreach($tour->tourDays as $day)
        @php
            $hotelName = $day->tourDayHotels->first()?->hotel?->name;
            $counts = collect(['twin' => 0, 'single' => 0, 'double' => 0]);

            foreach ($day->tourDayHotels as $hotel) {
                foreach ($hotel->hotelRooms as $hotelRoom) {
                    $rawType = strtolower(optional($hotelRoom->room->roomType)->type);
                    $qty = $hotelRoom->quantity ?? 0;

                    $mappedType = match (true) {
                        str_contains($rawType, 'twin')   => 'twin',
                        str_contains($rawType, 'single') => 'single',
                        str_contains($rawType, 'double') => 'double',
                        default => null,
                    };

                    if ($mappedType && $counts->has($mappedType)) {
                        $counts[$mappedType] += $qty;
                    }
                }
            }
        @endphp

        <h2>
            Day {{ $day->day_number }}: {{ $day->name }}
            @if($hotelName) — {{ $hotelName }} @endif
        </h2>

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
                        <td>{{ $day->check_in->format('d-m-Y') }}</td>
                        <td>{{ $day->check_out->format('d-m-Y') }}</td>
                        <td>{{ $counts['twin'] }}</td>
                        <td>{{ $counts['single'] }}</td>
                        <td>{{ $counts['double'] }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="no-data">No hotel scheduled for this day.</p>
        @endif
    @endforeach

    <p style="font-size:10px; text-align:center;">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </p>
</body>
</html>
