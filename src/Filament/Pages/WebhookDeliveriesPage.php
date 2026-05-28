<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Jobs\ForwardAuditToCentralJob;
use OzanKurt\Shield\Models\AuditLog;
use OzanKurt\Shield\Models\WebhookDelivery;

class WebhookDeliveriesPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Webhook Deliveries';
    protected static ?string $navigationLabel = 'Webhooks';
    protected static ?int $navigationSort = 75;
    protected static string $view = 'shield-filament::pages.webhook-deliveries';

    public ?string $filterStatus = null;
    public ?string $filterOperation = null;

    public function getViewData(): array
    {
        $query = WebhookDelivery::query()->latest('id');

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterOperation) {
            $query->where('operation', $this->filterOperation);
        }

        return [
            'deliveries' => $query->paginate(50),
            'stats' => [
                'total_24h' => WebhookDelivery::query()->where('dispatched_at', '>=', now()->subDay())->count(),
                'success_24h' => WebhookDelivery::query()->where('dispatched_at', '>=', now()->subDay())->where('status', 'success')->count(),
                'failure_24h' => WebhookDelivery::query()->where('dispatched_at', '>=', now()->subDay())->where('status', 'failure')->count(),
                'exhausted_24h' => WebhookDelivery::query()->where('dispatched_at', '>=', now()->subDay())->where('status', 'exhausted')->count(),
            ],
        ];
    }

    public function retry(int $id): void
    {
        $delivery = WebhookDelivery::query()->find($id);
        if (! $delivery || ! $delivery->audit_log_id || $delivery->operation !== 'webhook_ingest') {
            $this->dispatch('notify', ['type' => 'danger', 'message' => 'This delivery cannot be retried.']);
            return;
        }

        $entry = AuditLog::query()->find($delivery->audit_log_id);
        if (! $entry) {
            $this->dispatch('notify', ['type' => 'danger', 'message' => 'Original audit log no longer exists.']);
            return;
        }

        ForwardAuditToCentralJob::dispatch([
            'kind' => optional($entry->kind)->name ?? 'unknown',
            'severity' => optional($entry->severity)->name ?? 'medium',
            'description' => $entry->description,
            'actor_type' => $entry->actor_type,
            'actor_id' => $entry->actor_id,
            'subject_type' => $entry->subject_type,
            'subject_id' => $entry->subject_id,
            'ip' => $entry->ip,
            'user_agent' => $entry->user_agent,
            'url' => $entry->url,
            'changes' => $entry->changes,
            'meta' => $entry->meta,
            'correlation_id' => $entry->correlation_id,
            'occurred_at' => $entry->created_at?->toIso8601String(),
            'audit_log_id' => $entry->id,
            'audit_log_uuid' => $entry->uuid ?? null,
        ])->onQueue((string) config('shield.premium.queue', 'default'));

        $this->dispatch('notify', ['type' => 'success', 'message' => "Delivery #{$id} re-queued."]);
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-arrow-up-on-square';
    }
}
