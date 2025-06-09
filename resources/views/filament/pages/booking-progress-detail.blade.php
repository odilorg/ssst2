@php
  use App\Filament\Pages\BookingProgressReport;
@endphp
<x-filament::page>
  <x-filament::card class="space-y-4">
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold">
        Details for Tour #{{ $tourId }}
      </h2>
     <a
  href="{{ BookingProgressReport::getUrl() }}"
  class="underline text-sm"
>
  ← Back
</a>
    </div>

    {{ $this->table }}
  </x-filament::card>
</x-filament::page>
