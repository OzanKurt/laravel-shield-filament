<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\AuditLog;
use OzanKurt\Shield\Models\Lookups\AuditLogKind;
use OzanKurt\Shield\Models\Lookups\LogLevel;
use OzanKurt\Shield\Services\Lookups\LookupResolver;

class AuditLogPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Audit Log';
    protected static ?string $navigationLabel = 'Audit Log';
    protected static ?int $navigationSort = 20;
    protected static string $view = 'shield-filament::pages.audit-log';

    public function getViewData(): array
    {
        $resolver = app(LookupResolver::class);

        return [
            'entries' => AuditLog::query()
                ->latest('id')
                ->limit(100)
                ->get()
                ->map(fn ($e) => [
                    'id' => $e->id,
                    'kind' => $resolver->name(AuditLogKind::class, $e->kind_id),
                    'severity' => $resolver->name(LogLevel::class, $e->severity_id),
                    'description' => $e->description,
                    'ip' => $e->ip,
                    'created_at' => (string) $e->created_at,
                ]),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-clipboard-document-list';
    }
}
