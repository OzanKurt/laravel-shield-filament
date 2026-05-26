<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Configured threat feed providers</x-slot>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">Name</th>
                    <th class="pb-2 pr-3">Label</th>
                    <th class="pb-2">Available</th>
                </tr>
            </thead>
            <tbody>
                @foreach($providers as $p)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3 font-mono">{{ $p['name'] }}</td>
                        <td class="py-1 pr-3">{{ $p['label'] }}</td>
                        <td class="py-1">{{ $p['available'] ? 'Yes' : 'No (configure env vars)' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
