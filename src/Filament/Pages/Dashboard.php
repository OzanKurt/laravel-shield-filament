<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\Acl;
use OzanKurt\Shield\Models\AuditLog;
use OzanKurt\Shield\Models\Log;

class Dashboard extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Shield Dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = 1;
    protected static string $view = 'shield-filament::pages.dashboard';

    public function getViewData(): array
    {
        return [
            'attacks_total' => Log::count(),
            'acl_active' => Acl::query()->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })->count(),
            'audit_recent' => AuditLog::query()->latest('id')->limit(10)->get(),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-shield-check';
    }
}
