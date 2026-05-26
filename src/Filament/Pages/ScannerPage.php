<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\Lookups\ScannerFindingStatus;
use OzanKurt\Shield\Models\Lookups\ScannerStatus;
use OzanKurt\Shield\Models\ScannerFinding;
use OzanKurt\Shield\Models\ScannerRun;
use OzanKurt\Shield\Models\Signature;
use OzanKurt\Shield\Services\Lookups\LookupResolver;
use OzanKurt\Shield\Services\Scanner\Scanner;

class ScannerPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Scanner';
    protected static ?string $navigationLabel = 'Scanner';
    protected static ?int $navigationSort = 40;
    protected static string $view = 'shield-filament::pages.scanner';

    public function getViewData(): array
    {
        $resolver = app(LookupResolver::class);
        $latest = ScannerRun::query()->latest('id')->first();

        $openId = $resolver->id(ScannerFindingStatus::class, 'open');
        $quarantinedId = $resolver->id(ScannerFindingStatus::class, 'quarantined');

        return [
            'latest_run' => $latest,
            'latest_status' => $latest ? $resolver->name(ScannerStatus::class, $latest->status_id) : null,
            'open_count' => ScannerFinding::query()->where('status_id', $openId)->count(),
            'quarantined_count' => ScannerFinding::query()->where('status_id', $quarantinedId)->count(),
            'signature_count' => Signature::count(),
        ];
    }

    public function startScan(): void
    {
        $run = app(Scanner::class)->run(['app_files', 'public_uploads'], [], 'manual');

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Scan #{$run->id} completed: {$run->findings_count} findings",
        ]);
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-magnifying-glass';
    }
}
