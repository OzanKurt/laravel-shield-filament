<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\Lookups\LogLevel;
use OzanKurt\Shield\Models\Lookups\WafRuleAction;
use OzanKurt\Shield\Models\Lookups\WafRuleCategory;
use OzanKurt\Shield\Models\WafRule;
use OzanKurt\Shield\Services\Lookups\LookupResolver;

class WafRulesPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'WAF Rules';
    protected static ?string $navigationLabel = 'WAF Rules';
    protected static ?int $navigationSort = 50;
    protected static string $view = 'shield-filament::pages.waf-rules';

    public function getViewData(): array
    {
        $resolver = app(LookupResolver::class);

        return [
            'rules' => WafRule::query()
                ->orderBy('id')
                ->limit(200)
                ->get()
                ->map(fn ($r) => [
                    'id' => $r->id,
                    'name' => $r->name,
                    'source' => $r->source,
                    'category' => $resolver->name(WafRuleCategory::class, $r->category_id),
                    'action' => $resolver->name(WafRuleAction::class, $r->action_id),
                    'severity' => $resolver->name(LogLevel::class, $r->severity_id),
                    'enabled' => $r->is_enabled,
                ]),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-funnel';
    }
}
