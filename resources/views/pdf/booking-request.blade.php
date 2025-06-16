{{-- resources/views/pdf/booking-request.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Request — {{ $tour->name }}</title>
    <style>
        @font-face {
    font-family: 'DejaVu Sans';
    /* DomPDF already knows where its own "dejavusans.ttf" lives */
    /* but if you want to bundle your own: */
    /* src: url('{{ storage_path("fonts/DejaVuSans.ttf") }}') format('truetype'); */
}
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; margin: 0 1em; }
        /* ── COMPANY HEADER ──────────────────────────────────────── */
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
        .company-subtitles span { padding: 0 .5em; }
        .thin-line { border: none; border-top: 1px solid #000; margin: .25em 0; }
        .heavy-line { border: none; border-top: 2px solid #000; margin: .25em 0; }
        .company-contact { font-size: 10px; margin: .25em 0; }
        /* ── REQUEST META (screen 2) ───────────────────────────── */
        .request-meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin: 1em 0 .5em;
        }
        .request-number {
            text-align: center;
            font-size: 16px;
            text-transform: uppercase;
            margin: 0.25em 0;
        }
        .request-intro {
            margin: 0.5em 0 1em;
            font-style: italic;
        }
        /* ── DAY TABLES ─────────────────────────────────────────── */
        h1, h2, h3 { margin-bottom: .25em; }
        table { width: 100%; border-collapse: collapse; margin: .75em 0; }
        th, td { border: 1px solid #444; padding: 6px; text-align: center; }
        th { background: #eee; }
        .no-data { font-style: italic; color: #666; margin-bottom: 1em; }
    </style>
</head>
<body>

    {{-- COMPANY HEADER --}}
    <div class="company-header">
        @if($company->logo)
            <img src="{{ storage_path('app/public/'.$company->logo) }}" alt="{{ $company->name }}" style="max-height:80px; margin-bottom:.5em;">
        @endif
        <h1 class="company-title">"{{ $company->name }}"</h1>
        <div class="company-subtitles">
            <span>{{ strtoupper($company->address_city) }} shahr mas'uliyati cheklangan jamiyat</span>
            <span>{{ strtoupper($company->address_city) }} city limited liability company</span>
        </div>
        <hr class="thin-line">
        <p class="company-contact">
            {{ $company->address_city }} sh., {{ $company->address_street }} &nbsp;
            Tel.: {{ $company->phone }}@unless(empty($company->email)) | {{ $company->email }}@endunless
        </p>
        <hr class="heavy-line">
    </div>

    {{-- SCREEN 2: REQUEST META --}}
    @php
        // pick the first hotel's name as the recipient
        $firstHotel = $tour->tourDays
            ->pluck('tourDayHotels')
            ->flatten()
            ->pluck('hotel')
            ->first();
    @endphp
    <div class="request-meta">
        <div>Дата: {{ $request->created_at->format('d.m.Y') }}</div>
        <div>Кому: {{ $firstHotel ? 'Hotel "'.$firstHotel->name.'"' : '' }}</div>
    </div>
    <h2 class="request-number">ЗАЯВКА № {{ $request->request_number }}</h2>
    <p class="request-intro">
        СП "{{ $company->name }}" приветствует Вас, и просит забронировать места по нижеследующему графику:
    </p>

    {{-- DAY BREAKDOWNS --}}
    @foreach($tour->tourDays as $day)
        @php
            $hotelName = $day->tourDayHotels->first()?->hotel?->name;
            $counts = collect(['twin' => 0, 'single' => 0, 'double' => 0]);
            foreach ($day->tourDayHotels as $hotel) {
                foreach ($hotel->hotelRooms as $hr) {
                    $rawType = strtolower(optional($hr->room->roomType)->type);
                    $qty     = $hr->quantity ?? 0;
                    $mapped  = match (true) {
                        str_contains($rawType, 'twin')   => 'twin',
                        str_contains($rawType, 'single') => 'single',
                        str_contains($rawType, 'double') => 'double',
                        default => null,
                    };
                    if ($mapped) {
                        $counts[$mapped] += $qty;
                    }
                }
            }
        @endphp

        <h3>
            Day {{ $day->day_number }}: {{ $day->name }}
            @if($hotelName) — {{ $hotelName }} @endif
        </h3>

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

    <p style="font-size:10px; text-align:center; margin-top:2em;">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </p>
</body>
</html>
