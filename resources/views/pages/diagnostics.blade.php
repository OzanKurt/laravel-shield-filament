<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-filament::section>
            <x-slot name="heading">System</x-slot>
            <dl class="text-sm">
                <dt class="text-gray-500">PHP</dt><dd>{{ $php }}</dd>
                <dt class="text-gray-500 mt-2">Laravel</dt><dd>{{ $laravel }}</dd>
                <dt class="text-gray-500 mt-2">Memory limit</dt><dd>{{ $memory }}</dd>
            </dl>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Environment audit — Grade {{ $env_grade }}</x-slot>
            @if(empty($env_findings))
                <p class="text-sm text-success-500">All checks passed.</p>
            @else
                <ul class="text-sm space-y-1">
                    @foreach($env_findings as $f)
                        <li>
                            <span class="font-mono">{{ $f['key'] }}</span>
                            <span class="text-gray-500">[{{ $f['severity'] }}]</span>
                            — {{ $f['message'] }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
