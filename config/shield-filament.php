<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Navigation
    |--------------------------------------------------------------------------
    | Override Filament navigation group + sort weight from this file if you
    | don't want to subclass each page.
    */
    'navigation' => [
        'group' => 'Shield',
        'icons' => [
            'dashboard' => 'heroicon-o-shield-check',
            'acl' => 'heroicon-o-no-symbol',
            'audit_log' => 'heroicon-o-clipboard-document-list',
            'live_traffic' => 'heroicon-o-bolt',
            'scanner' => 'heroicon-o-magnifying-glass',
            'waf_rules' => 'heroicon-o-funnel',
            'threat_feed' => 'heroicon-o-globe-alt',
            'cache' => 'heroicon-o-archive-box-x-mark',
            'diagnostics' => 'heroicon-o-cog-6-tooth',
        ],
    ],
];
