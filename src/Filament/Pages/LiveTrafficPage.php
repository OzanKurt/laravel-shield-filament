<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\LiveTrafficRecord;

class LiveTrafficPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Live Traffic';
    protected static ?string $navigationLabel = 'Live Traffic';
    protected static ?int $navigationSort = 30;
    protected static string $view = 'shield-filament::pages.live-traffic';

    public function getViewData(): array
    {
        return [
            'records' => LiveTrafficRecord::query()->latest('id')->limit(100)->get(),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-bolt';
    }
}
