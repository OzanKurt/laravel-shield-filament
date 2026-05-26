<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">WAF rules</x-slot>
        <table class="min-w-full text-sm">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">ID</th>
                    <th class="pb-2 pr-3">Name</th>
                    <th class="pb-2 pr-3">Category</th>
                    <th class="pb-2 pr-3">Source</th>
                    <th class="pb-2 pr-3">Action</th>
                    <th class="pb-2 pr-3">Severity</th>
                    <th class="pb-2">Enabled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rules as $r)
                    <tr class="border-t border-gray-100 dark:border-gray-700">
                        <td class="py-1 pr-3">{{ $r['id'] }}</td>
                        <td class="py-1 pr-3">{{ $r['name'] }}</td>
                        <td class="py-1 pr-3">{{ $r['category'] }}</td>
                        <td class="py-1 pr-3">{{ $r['source'] }}</td>
                        <td class="py-1 pr-3">{{ $r['action'] }}</td>
                        <td class="py-1 pr-3">{{ $r['severity'] }}</td>
                        <td class="py-1">{{ $r['enabled'] ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-filament::section>
</x-filament-panels::page>
