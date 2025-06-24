<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Entrance Ticket Vouchers</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    /* ------- PAGE ------- */
    @page { size: A4 portrait; margin: 0; }
    body   { margin: 5mm; font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }

    /* ------- TABLE GRID (robust for dompdf) ------- */
    table.sheet { width: 100%; border-collapse: collapse; }
    table.sheet td { width: 50%; vertical-align: top; padding: 0; }
    table.sheet td.right { border-left: 1px dashed #000; }

    /* ------- VOUCHER BOX ------- */
    .voucher {
      margin: 0 4mm 1mm 0;   /* right & bottom gap reduced */
      border: 1px solid #000;
      padding: 2mm;
      box-sizing: border-box;
      page-break-inside: avoid;
      height: 82mm;  /* fits 3 rows incl. padding + borders */          /* fit 4 rows on A4 */
    }

    /* Header boxes */
    .top { margin-bottom: 6px; }
    .box-left, .box-right {
      border: 1px solid #000;
      padding: 4px;
      display: inline-block;
      vertical-align: top;
    }
    .box-left  { width: 60%; }
    .box-right { width: 37%; margin-left: 2%; text-align: center; }
    .box-right .company-name { font-weight: bold; margin-bottom: 4px; }

    .sep { border-top: 1px solid #000; margin: 6px 0; }

    /* Body lines */
    .body p { margin: 2px 0; line-height: 1.25; }
    .body p label { display:inline-block; width:105px; }
    .body p span  { display:inline-block; width:55mm; border-bottom:1px solid #000; vertical-align:bottom; }}
  </style>
</head>
<body>
  <table class="sheet">
    <tbody>
    @for ($i = 0; $i < $count; $i += 2)
        <tr>
            <!-- Left voucher -->
            <td>
              <div class="voucher">
                <div class="top">
              <table class="hdr" width="100%" style="table-layout:fixed; border-collapse:collapse;">
                <tr>
                  <td class="cell-left" style="width:65%; border:1px solid #000; padding:4px; vertical-align:top;">
                    {{ $company->address_street }},<br>{{ $company->address_city }}<br>
                    Tel.: {{ $company->phone }}<br>
                    Email: {{ $company->email }}<br>
                    License №{{ $company->inn }}{{ isset($company->license_date) ? ' from '.$company->license_date->format('d.m.Y') : '' }}
                  </td>
                  <td class="cell-right" style="width:35%; border:1px solid #000; padding:4px; text-align:center; vertical-align:top;">
                    <div style="font-weight:bold; margin-bottom:4px;">"{{ $company->name }}" LLC</div>
                    <div>Travel Company</div>
                  </td>
                </tr>
              </table>
            </div>
                <div class="sep"></div>
                <div class="body">
                  <p><label>VOUCHER №</label><span></span></p>
                  <p><label>Предъявить в:</label><span></span></p>
                  <p><label>Страна:</label><span></span></p>
                  <p><label>Количество туристов:</label><span></span></p>
                  <p><label>№ группы:</label><span></span></p>
                  <p><label>Дата:</label><span></span></p>
                  <p><label>Ф.И.О. гида:</label><span></span></p>
                  <p><label>Город:</label><span></span></p>
                </div>
              </div>
            </td>

            <!-- Right voucher (if exists) -->
            <td class="right">
              @if($i + 1 < $count)
              <div class="voucher">
                <div class="top">
              <table class="hdr" width="100%" style="table-layout:fixed; border-collapse:collapse;">
                <tr>
                  <td class="cell-left" style="width:65%; border:1px solid #000; padding:4px; vertical-align:top;">
                    {{ $company->address_street }},<br>{{ $company->address_city }}<br>
                    Tel.: {{ $company->phone }}<br>
                    Email: {{ $company->email }}<br>
                    License №{{ $company->inn }}{{ isset($company->license_date) ? ' from '.$company->license_date->format('d.m.Y') : '' }}
                  </td>
                  <td class="cell-right" style="width:35%; border:1px solid #000; padding:4px; text-align:center; vertical-align:top;">
                    <div style="font-weight:bold; margin-bottom:4px;">"{{ $company->name }}" LLC</div>
                    <div>Travel Company</div>
                  </td>
                </tr>
              </table>
            </div>
                <div class="sep"></div>
                <div class="body">
                  <p><label>VOUCHER №</label><span></span></p>
                  <p><label>Предъявить в:</label><span></span></p>
                  <p><label>Страна:</label><span></span></p>
                  <p><label>Количество туристов:</label><span></span></p>
                  <p><label>№ группы:</label><span></span></p>
                  <p><label>Дата:</label><span></span></p>
                  <p><label>Ф.И.О. гида:</label><span></span></p>
                  <p><label>Город:</label><span></span></p>
                </div>
              </div>
              @endif
            </td>
        </tr>
    @endfor
    </tbody>
  </table>
</body>
</html>
