<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Recent ACL entries</x-slot>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">ID</th>
                    <th class="pb-2 pr-3">Kind</th>
                    <th class="pb-2 pr-3">Value</th>
                    <th class="pb-2 pr-3">Action</th>
                    <th class="pb-2 pr-3">Source</th>
                    <th class="pb-2">Expires</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entries as $e)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3">{{ $e['id'] }}</td>
                        <td class="py-1 pr-3">{{ $e['kind'] }}</td>
                        <td class="py-1 pr-3 font-mono">{{ $e['value'] }}</td>
                        <td class="py-1 pr-3">{{ $e['action'] }}</td>
                        <td class="py-1 pr-3">{{ $e['source'] }}</td>
                        <td class="py-1">{{ $e['expires_at'] ?: '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
