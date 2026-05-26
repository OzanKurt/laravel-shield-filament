<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Recent traffic (sampled)</x-slot>
        <p class="text-sm text-gray-500 mb-2">
            Sampling rate from <code>shield.live_traffic.sample_rate</code>. Attacks always captured 100%.
        </p>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">Time</th>
                    <th class="pb-2 pr-3">IP</th>
                    <th class="pb-2 pr-3">Method</th>
                    <th class="pb-2 pr-3">URL</th>
                    <th class="pb-2 pr-3">Status</th>
                    <th class="pb-2">ms</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $r)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3">{{ $r->created_at }}</td>
                        <td class="py-1 pr-3 font-mono">{{ $r->ip }}</td>
                        <td class="py-1 pr-3">{{ $r->method }}</td>
                        <td class="py-1 pr-3 truncate max-w-xs">{{ $r->url }}</td>
                        <td class="py-1 pr-3">{{ $r->status_code }}</td>
                        <td class="py-1">{{ $r->response_time_ms }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
