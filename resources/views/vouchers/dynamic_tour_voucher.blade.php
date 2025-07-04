<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>Tour Vouchers (Duplicated with Details)</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
    @page { size: A4 portrait; margin: 0; }
    body { margin: 5mm; font-family: 'DejaVu Sans', sans-serif; font-size: 11px; }
    table.sheet { width: 100%; border-collapse: collapse; }
    table.sheet td { width: 50%; vertical-align: top; padding: 0 2mm; }
    table.sheet td.right { border-left: 1px dashed #000; }

    .voucher { border: 1px solid #000; padding: 2mm; box-sizing: border-box; height: 82mm; page-break-inside: avoid; }
    .hdr-table { width: 100%; table-layout: fixed; border-collapse: collapse; margin-bottom: 4px; }
    .hdr-table td { border: 1px solid #000; padding: 4px; vertical-align: top; }
    .hdr-left { width: 65%; }
    .hdr-right { width: 35%; text-align: center; }
    .hdr-right .company-name { font-weight: bold; margin-bottom: 4px; }
    .sep { border-top: 1px solid #000; margin: 4px 0; }
    .body p { margin: 2px 0; line-height: 1.25; }
    .body p label { display: inline-block; width: 90px; }
    .body p span { display: inline-block; width: 50mm; border-bottom: 1px solid #000; vertical-align: bottom; }
  </style>
</head>
<body>
  <table class="sheet">
    <tbody>
      @foreach($vouchers as $v)
        <tr>
          <!-- Left copy -->
          <td>
            <div class="voucher">
              <table class="hdr-table">
                <tr>
                  <td class="hdr-left">
                    {{ $company->address_street }}, {{ $company->address_city }}<br>
                    Tel.: {{ $company->phone }}<br>
                    Email: {{ $company->email }}<br>
                    License №:{{ $company->license_number }}
                  </td>
                  <td class="hdr-right">
                    <div class="company-name">"{{ $company->name }}" LLC</div>
                     <div>INN {{ $company->inn }}</div>
                  </td>
                </tr>
              </table>
              <div class="sep"></div>
              <div class="body">
                <p><label>Предъявить в:</label> <span>{{ $v['monument'] }}</span></p>
                <p><label>Страна:</label>     <span>{{ $v['country'] }}</span></p>
                <p><label>Кол-во Тур.:</label>   <span>{{ $v['number_people'] }}</span></p>
                <p><label>№ Группы:</label>   <span>{{ $v['tour_number'] }}</span></p>
                <p><label>Дата:</label>       <span>{{ $v['date'] }}</span></p>
                <p><label>ФИО Гида:</label>       <span>{{ $v['guide'] }}</span></p>
                <p><label>Город:</label>     <span>{{ $v['city'] }}</span></p>
                
                
              </div>
            </div>
          </td>
          <!-- Right copy -->
          <td class="right">
            <div class="voucher">
              <table class="hdr-table">
                <tr>
                  <td class="hdr-left">
                    {{ $company->address_street }}, {{ $company->address_city }}<br>
                    Tel.: {{ $company->phone }}<br>
                    Email: {{ $company->email }}<br>
                    License №:{{ $company->license_number }}
                  </td>
                  <td class="hdr-right">
                    <div class="company-name">"{{ $company->name }}" LLC</div>
                    <div>INN {{ $company->inn }}</div>
                  </td>
                </tr>
              </table>
              <div class="sep"></div>
              <div class="body">
                  <p><label>Предъявить в:</label> <span>{{ $v['monument'] }}</span></p>
                <p><label>Страна:</label>     <span>{{ $v['country'] }}</span></p>
                <p><label>Кол-во Тур.:</label>   <span>{{ $v['number_people'] }}</span></p>
                <p><label>№ Группы:</label>   <span>{{ $v['tour_number'] }}</span></p>
                <p><label>Дата:</label>       <span>{{ $v['date'] }}</span></p>
                <p><label>ФИО Гида:</label>       <span>{{ $v['guide'] }}</span></p>
                <p><label>Город:</label>     <span>{{ $v['city'] }}</span></p>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
