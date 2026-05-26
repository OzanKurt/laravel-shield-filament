<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Contracts\ThreatFeedProvider;

class ThreatFeedPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Threat Feeds';
    protected static ?string $navigationLabel = 'Threat Feeds';
    protected static ?int $navigationSort = 60;
    protected static string $view = 'shield-filament::pages.threat-feed';

    public function getViewData(): array
    {
        $providers = [];
        foreach ((array) config('shield.threat_feed.providers', []) as $cls) {
            if (class_exists($cls)) {
                /** @var ThreatFeedProvider $p */
                $p = app($cls);
                $providers[] = [
                    'name' => $p->name(),
                    'label' => $p->label(),
                    'available' => $p->isAvailable(),
                ];
            }
        }
        return compact('providers');
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-globe-alt';
    }
}
