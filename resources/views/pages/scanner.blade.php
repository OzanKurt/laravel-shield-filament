<x-filament-panels::page>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <x-filament::section>
            <x-slot name="heading">Latest run</x-slot>
            <div class="text-2xl">{{ $latest_run ? '#'.$latest_run->id : '—' }}</div>
            <div class="text-sm text-gray-500">{{ $latest_status }}</div>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Open findings</x-slot>
            <div class="text-2xl">{{ $open_count }}</div>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Quarantined</x-slot>
            <div class="text-2xl">{{ $quarantined_count }}</div>
        </x-filament::section>
        <x-filament::section>
            <x-slot name="heading">Signatures</x-slot>
            <div class="text-2xl">{{ $signature_count }}</div>
        </x-filament::section>
    </div>

    <x-filament::section class="mt-6">
        <x-slot name="heading">Run a scan</x-slot>
        <x-filament::button wire:click="startScan">Run app_files + public_uploads scan</x-filament::button>
    </x-filament::section>
</x-filament-panels::page>
