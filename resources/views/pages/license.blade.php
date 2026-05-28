<x-filament-panels::page>
    @php
        $stateKey = $state['state'] ?? 'no_key';
        $badge = [
            'valid'   => ['Active',         'success'],
            'grace'   => ['Grace period',   'warning'],
            'invalid' => ['Invalid',        'danger'],
            'no_key'  => ['Not configured', 'gray'],
        ][$stateKey] ?? ['Unknown', 'gray'];
    @endphp

    <x-filament::section>
        <x-slot name="heading">Premium license</x-slot>
        <x-slot name="description">
            Runtime license check against <code class="text-xs">{{ $checkUrl }}</code>
        </x-slot>
        <x-slot name="headerEnd">
            <div class="flex items-center gap-2">
                <x-filament::badge :color="$badge[1]">{{ $badge[0] }}</x-filament::badge>
                <x-filament::button wire:click="refresh" size="sm" outlined :disabled="! $hasKey">Refresh now</x-filament::button>
                <x-filament::button wire:click="clear" size="sm" outlined color="gray">Clear cache</x-filament::button>
                <x-filament::button wire:click="test" size="sm" outlined color="success" :disabled="! $hasKey">Test connectivity</x-filament::button>
            </div>
        </x-slot>

        @if(! $hasKey)
            <div class="text-center py-8">
                <h4 class="text-lg font-medium mb-2">No premium license configured</h4>
                <p class="text-gray-500 mb-4">
                    Add <code>LS_PREMIUM_LICENSE_KEY=…</code> to your <code>.env</code> to unlock premium features.
                    Core Shield (WAF, ACL, scanner, audit log, threat feeds) keeps working without a license.
                </p>
                <x-filament::link href="https://laravel-shield.ozankurt.com/pricing" target="_blank" rel="noopener">
                    See plans →
                </x-filament::link>
            </div>
        @else
            @if($stateKey === 'grace')
                <div class="rounded-md bg-yellow-50 dark:bg-yellow-900/20 p-3 mb-4">
                    <strong>Central license API is unreachable.</strong>
                    Premium features stay active until <strong>{{ $state['grace_until'] ?? '—' }}</strong>.
                </div>
            @elseif($stateKey === 'invalid')
                <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-3 mb-4">
                    <strong>License invalid:</strong> {{ $state['reason'] ?? 'unknown reason' }}.
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h5 class="font-medium text-sm text-gray-500 uppercase mb-2">License</h5>
                    <dl class="space-y-1 text-sm">
                        <div class="flex"><dt class="w-32 text-gray-500">Key</dt><dd class="font-mono">{{ $maskedKey }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Plan</dt><dd>{{ $state['plan'] ?? '—' }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Expires</dt><dd>{{ $state['expires_at'] ?? '—' }}</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Last checked</dt><dd>{{ $state['last_checked_at'] ?? '—' }}</dd></div>
                        @if(! empty($state['grace_until']))
                            <div class="flex"><dt class="w-32 text-gray-500">Grace until</dt><dd>{{ $state['grace_until'] }}</dd></div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h5 class="font-medium text-sm text-gray-500 uppercase mb-2">Usage + settings</h5>
                    <dl class="space-y-1 text-sm">
                        <div class="flex"><dt class="w-32 text-gray-500">Domains</dt><dd>
                            @if(isset($state['domain_limit']))
                                {{ $state['domains_used'] ?? '?' }} / {{ $state['domain_limit'] }}
                            @else
                                —
                            @endif
                        </dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Cache TTL</dt><dd>{{ $cacheTtl }}s</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Grace period</dt><dd>{{ $graceDays }}d</dd></div>
                        <div class="flex"><dt class="w-32 text-gray-500">Heartbeat</dt><dd>
                            @if($heartbeatEnabled)
                                Enabled — every {{ $heartbeatInterval }} min
                            @else
                                Disabled
                            @endif
                        </dd></div>
                    </dl>
                </div>
            </div>

            @if(! empty($state['features']))
                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <h5 class="font-medium text-sm text-gray-500 uppercase mb-2">Features unlocked</h5>
                    <div class="flex flex-wrap gap-1">
                        @foreach($state['features'] as $feature)
                            <x-filament::badge color="primary">{{ $feature }}</x-filament::badge>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif
    </x-filament::section>
</x-filament-panels::page>
