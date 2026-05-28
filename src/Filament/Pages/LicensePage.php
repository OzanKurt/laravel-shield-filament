<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Services\Premium\CentralClient;
use OzanKurt\Shield\Services\Premium\LicenseChecker;

class LicensePage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Premium License';
    protected static ?string $navigationLabel = 'License';
    protected static ?int $navigationSort = 80;
    protected static string $view = 'shield-filament::pages.license';

    public function getViewData(): array
    {
        $checker = app(LicenseChecker::class);

        return [
            'state' => $checker->state(),
            'hasKey' => $checker->hasKey(),
            'maskedKey' => $checker->maskedKey(),
            'checkUrl' => (string) config('shield.premium.check_url'),
            'cacheTtl' => (int) config('shield.premium.cache_ttl'),
            'graceDays' => (int) config('shield.premium.grace_period_days'),
            'heartbeatEnabled' => (bool) config('shield.premium.heartbeat.enabled'),
            'heartbeatInterval' => (int) config('shield.premium.heartbeat.interval_minutes'),
        ];
    }

    public function refresh(): void
    {
        app(LicenseChecker::class)->refresh();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'License refreshed.']);
    }

    public function clear(): void
    {
        app(LicenseChecker::class)->clearCache();
        $this->dispatch('notify', ['type' => 'success', 'message' => 'License cache cleared.']);
    }

    public function test(): void
    {
        $result = app(CentralClient::class)->heartbeat([
            'test' => true,
            'sent_by' => 'filament.dashboard.test',
        ]);

        $message = $result->ok()
            ? "Connectivity OK (HTTP {$result->httpStatus})"
            : "Failed: status={$result->httpStatus}, reason={$result->error}";

        $this->dispatch('notify', [
            'type' => $result->ok() ? 'success' : 'danger',
            'message' => $message,
        ]);
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-key';
    }

    public function getNavigationBadge(): ?string
    {
        $state = app(LicenseChecker::class)->cachedState();
        return match ($state['state'] ?? null) {
            'valid' => 'PRO',
            'grace' => '!',
            'invalid' => '!',
            default => null,
        };
    }

    public function getNavigationBadgeColor(): ?string
    {
        $state = app(LicenseChecker::class)->cachedState();
        return match ($state['state'] ?? null) {
            'valid' => 'success',
            'grace' => 'warning',
            'invalid' => 'danger',
            default => null,
        };
    }
}
