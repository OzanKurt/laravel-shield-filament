<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Recent audit log entries</x-slot>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">When</th>
                    <th class="pb-2 pr-3">Kind</th>
                    <th class="pb-2 pr-3">Severity</th>
                    <th class="pb-2 pr-3">IP</th>
                    <th class="pb-2">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entries as $e)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3">{{ $e['created_at'] }}</td>
                        <td class="py-1 pr-3 font-mono">{{ $e['kind'] }}</td>
                        <td class="py-1 pr-3">{{ $e['severity'] }}</td>
                        <td class="py-1 pr-3 font-mono">{{ $e['ip'] }}</td>
                        <td class="py-1">{{ $e['description'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
