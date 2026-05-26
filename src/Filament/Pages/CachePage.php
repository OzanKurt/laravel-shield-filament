<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;

class CachePage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Cache';
    protected static ?string $navigationLabel = 'Cache';
    protected static ?int $navigationSort = 70;
    protected static string $view = 'shield-filament::pages.cache';

    public function getViewData(): array
    {
        $keys = [
            'shield.acl.live',
            'shield.lookups.AclKind', 'shield.lookups.AclAction',
            'shield.lookups.LogLevel', 'shield.lookups.LogKind',
            'shield.lookups.AuditLogKind',
            'shield.lookups.WafRuleCategory', 'shield.lookups.WafRuleKind',
            'shield.lookups.WafRuleTarget', 'shield.lookups.WafRuleAction',
            'shield.waf.rules.xss', 'shield.waf.rules.sqli',
            'shield.waf.rules.lfi', 'shield.waf.rules.rfi',
            'shield.waf.rules.php_protocols', 'shield.waf.rules.session',
            'shield.waf.rules.keyword', 'shield.waf.rules.custom',
            'shield.trusted_proxies',
        ];

        return [
            'rows' => array_map(fn ($k) => ['key' => $k, 'present' => Cache::has($k)], $keys),
        ];
    }

    public function clearAll(): void
    {
        foreach ((new self())->getViewData()['rows'] as $row) {
            Cache::forget($row['key']);
        }
        $this->dispatch('notify', ['type' => 'success', 'message' => 'Shield cache cleared.']);
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-archive-box-x-mark';
    }
}
