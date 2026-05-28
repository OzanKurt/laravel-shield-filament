<x-filament-panels::page>
    <div class="grid grid-cols-4 gap-3 mb-4">
        <x-filament::section><x-slot name="heading">Total (24h)</x-slot><div class="text-2xl font-mono">{{ number_format($stats['total_24h']) }}</div></x-filament::section>
        <x-filament::section><x-slot name="heading">Success (24h)</x-slot><div class="text-2xl font-mono text-success-600">{{ number_format($stats['success_24h']) }}</div></x-filament::section>
        <x-filament::section><x-slot name="heading">Failure (24h)</x-slot><div class="text-2xl font-mono text-warning-600">{{ number_format($stats['failure_24h']) }}</div></x-filament::section>
        <x-filament::section><x-slot name="heading">Exhausted (24h)</x-slot><div class="text-2xl font-mono text-danger-600">{{ number_format($stats['exhausted_24h']) }}</div></x-filament::section>
    </div>

    <x-filament::section>
        <x-slot name="heading">Outbound deliveries</x-slot>
        <x-slot name="description">Calls to Central — webhook ingest, heartbeat, test pings.</x-slot>
        <x-slot name="headerEnd">
            <div class="flex gap-2">
                <select wire:model.live="filterStatus" class="text-sm rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                    <option value="">All statuses</option>
                    @foreach(['pending','success','failure','skipped','exhausted'] as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterOperation" class="text-sm rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                    <option value="">All operations</option>
                    @foreach(['webhook_ingest','webhook_ingest_batch','heartbeat','test_ping'] as $o)
                        <option value="{{ $o }}">{{ $o }}</option>
                    @endforeach
                </select>
            </div>
        </x-slot>

        <table class="min-w-full text-xs">
            <thead class="text-left text-gray-500">
                <tr>
                    <th class="pb-2 pr-3">Dispatched</th>
                    <th class="pb-2 pr-3">Operation</th>
                    <th class="pb-2 pr-3">Status</th>
                    <th class="pb-2 pr-3">HTTP</th>
                    <th class="pb-2 pr-3">Attempt</th>
                    <th class="pb-2 pr-3">Bytes</th>
                    <th class="pb-2 pr-3">Duration</th>
                    <th class="pb-2 pr-3">Reason</th>
                    <th class="pb-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $d)
                    @php
                        $color = match($d->status) {
                            'success'   => 'success',
                            'pending'   => 'info',
                            'failure'   => 'warning',
                            'exhausted' => 'danger',
                            'skipped'   => 'gray',
                            default     => 'gray',
                        };
                    @endphp
                    <tr class="border-t border-gray-100 dark:border-gray-700 font-mono">
                        <td class="py-1 pr-3 text-gray-500">{{ $d->dispatched_at?->format('Y-m-d H:i:s') }}</td>
                        <td class="py-1 pr-3">{{ $d->operation }}</td>
                        <td class="py-1 pr-3"><x-filament::badge :color="$color">{{ $d->status }}</x-filament::badge></td>
                        <td class="py-1 pr-3">{{ $d->http_status ?: '—' }}</td>
                        <td class="py-1 pr-3">{{ $d->attempt_number }}/{{ $d->max_attempts }}</td>
                        <td class="py-1 pr-3">{{ $d->payload_bytes }}</td>
                        <td class="py-1 pr-3">{{ $d->duration_ms !== null ? $d->duration_ms . 'ms' : '—' }}</td>
                        <td class="py-1 pr-3 text-gray-500 truncate max-w-xs" title="{{ $d->reason }}">{{ $d->reason ?? '—' }}</td>
                        <td class="py-1">
                            @if(in_array($d->status, ['failure','exhausted']) && $d->operation === 'webhook_ingest')
                                <x-filament::button wire:click="retry({{ $d->id }})" size="xs" outlined>Retry</x-filament::button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="py-6 text-center text-gray-500">No deliveries yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $deliveries->links() }}</div>
    </x-filament::section>
</x-filament-panels::page>
