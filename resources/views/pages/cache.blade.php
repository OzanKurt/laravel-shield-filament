<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">Shield cache keys</x-slot>
        <x-slot name="headerEnd">
            <x-filament::button wire:click="clearAll" color="warning" size="sm">Clear all</x-filament::button>
        </x-slot>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr><th class="pb-2 pr-3">Key</th><th class="pb-2">Present</th></tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3 font-mono">{{ $row['key'] }}</td>
                        <td class="py-1">{{ $row['present'] ? 'Yes' : 'Empty' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
