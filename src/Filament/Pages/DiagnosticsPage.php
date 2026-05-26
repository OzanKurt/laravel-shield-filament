<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Services\Audit\EnvAuditor;

class DiagnosticsPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Diagnostics';
    protected static ?string $navigationLabel = 'Diagnostics';
    protected static ?int $navigationSort = 90;
    protected static string $view = 'shield-filament::pages.diagnostics';

    public function getViewData(): array
    {
        $auditor = app(EnvAuditor::class);

        return [
            'php' => PHP_VERSION,
            'laravel' => app()->version(),
            'memory' => ini_get('memory_limit'),
            'env_findings' => $auditor->audit(),
            'env_grade' => $auditor->grade(),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-cog-6-tooth';
    }
}
