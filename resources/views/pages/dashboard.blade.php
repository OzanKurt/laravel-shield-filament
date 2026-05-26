<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-filament::section>
            <x-slot name="heading">Attacks blocked (all time)</x-slot>
            <div class="text-3xl">{{ $attacks_total }}</div>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">ACL entries active</x-slot>
            <div class="text-3xl">{{ $acl_active }}</div>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Recent audit events</x-slot>
            <div class="text-3xl">{{ $audit_recent->count() }}</div>
        </x-filament::section>
    </div>

    <x-filament::section class="mt-6">
        <x-slot name="heading">Latest audit entries</x-slot>
        <ul class="space-y-1 text-sm">
            @foreach($audit_recent as $entry)
                <li class="border-b border-gray-100 dark:border-gray-700 py-1">
                    <span class="text-gray-500">{{ $entry->created_at }}</span>
                    — {{ $entry->description }}
                </li>
            @endforeach
        </ul>
    </x-filament::section>
</x-filament-panels::page>
