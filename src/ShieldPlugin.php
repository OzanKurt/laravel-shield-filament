<?php

namespace OzanKurt\ShieldFilament;

use Filament\Contracts\Plugin;
use Filament\Panel;
use OzanKurt\ShieldFilament\Filament\Pages\AclPage;
use OzanKurt\ShieldFilament\Filament\Pages\AuditLogPage;
use OzanKurt\ShieldFilament\Filament\Pages\CachePage;
use OzanKurt\ShieldFilament\Filament\Pages\Dashboard as ShieldDashboardPage;
use OzanKurt\ShieldFilament\Filament\Pages\DiagnosticsPage;
use OzanKurt\ShieldFilament\Filament\Pages\LiveTrafficPage;
use OzanKurt\ShieldFilament\Filament\Pages\ScannerPage;
use OzanKurt\ShieldFilament\Filament\Pages\ThreatFeedPage;
use OzanKurt\ShieldFilament\Filament\Pages\WafRulesPage;

/**
 * Filament plugin entry point — register inside a PanelProvider:
 *
 *     return $panel
 *         ->id('admin')
 *         ->plugin(new ShieldPlugin());
 */
class ShieldPlugin implements Plugin
{
    public function getId(): string
    {
        return 'shield';
    }

    public function register(Panel $panel): void
    {
        $panel->pages([
            ShieldDashboardPage::class,
            AclPage::class,
            AuditLogPage::class,
            LiveTrafficPage::class,
            ScannerPage::class,
            WafRulesPage::class,
            ThreatFeedPage::class,
            CachePage::class,
            DiagnosticsPage::class,
        ]);
    }

    public function boot(Panel $panel): void
    {
        // No boot-time wiring needed for v1.0
    }

    public static function make(): static
    {
        return app(static::class);
    }
}
