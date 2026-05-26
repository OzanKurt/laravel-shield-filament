<?php

namespace OzanKurt\ShieldFilament;

use Illuminate\Support\ServiceProvider;
use OzanKurt\ShieldFilament\Filament\Pages;

/**
 * Service provider for the Laravel Shield Filament adapter.
 *
 * Registers Shield resources/pages with any Filament panel that calls
 * `->plugin(new ShieldPlugin())`. See the README for the panel-builder
 * registration snippet.
 *
 * v1.x supports Filament 3 and Filament 4. v2.x covers Filament 5+.
 */
class ShieldFilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Plugin instances are constructed by the host app's PanelProvider.
        // Nothing to bind here other than singletons for any internal services.
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shield-filament');

        $this->publishes([
            __DIR__ . '/../config/shield-filament.php' => config_path('shield-filament.php'),
        ], 'shield-filament-config');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/shield-filament'),
        ], 'shield-filament-views');

        $this->mergeConfigFrom(__DIR__ . '/../config/shield-filament.php', 'shield-filament');
    }
}
