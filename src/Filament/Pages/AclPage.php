<?php

namespace OzanKurt\ShieldFilament\Filament\Pages;

use Filament\Pages\Page;
use OzanKurt\Shield\Models\Acl;
use OzanKurt\Shield\Models\Lookups\AclAction;
use OzanKurt\Shield\Models\Lookups\AclKind;
use OzanKurt\Shield\Services\Lookups\LookupResolver;

class AclPage extends Page
{
    protected static ?string $navigationGroup = 'Shield';
    protected static ?string $title = 'Access Control List';
    protected static ?string $navigationLabel = 'ACL';
    protected static ?int $navigationSort = 10;
    protected static string $view = 'shield-filament::pages.acl';

    public function getViewData(): array
    {
        $resolver = app(LookupResolver::class);

        return [
            'entries' => Acl::query()
                ->latest('id')
                ->limit(50)
                ->get()
                ->map(fn ($a) => [
                    'id' => $a->id,
                    'kind' => $resolver->name(AclKind::class, $a->kind_id),
                    'value' => $a->value,
                    'action' => $resolver->name(AclAction::class, $a->action_id),
                    'source' => $a->source,
                    'expires_at' => (string) $a->expires_at,
                ]),
        ];
    }

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-no-symbol';
    }
}
