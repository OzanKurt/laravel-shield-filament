# Laravel Shield — Filament adapter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ozankurt/laravel-shield-filament.svg?style=flat-square)](https://packagist.org/packages/ozankurt/laravel-shield-filament)

Filament panel adapter for [Laravel Shield](https://github.com/OzanKurt/laravel-shield). Drops in to any existing Filament panel — replaces the bundled Bootstrap dashboard with Filament resources you already know.

| Adapter version | Filament versions supported |
|---|---|
| **`1.x`** *(this branch)* | Filament 3 + 4 |
| **`2.x`** *(on `2.x` branch)* | Filament 5+ |

Pin the major that matches your Filament install.

## Install

```bash
composer require ozankurt/laravel-shield-filament:^1.0
```

## Register the plugin

In your Filament `PanelProvider`:

```php
use OzanKurt\ShieldFilament\ShieldPlugin;

return $panel
    ->id('admin')
    ->plugin(ShieldPlugin::make());
```

That's it. The plugin adds nine pages to your panel under the **Shield** navigation group:

| Page | What it shows |
|---|---|
| Dashboard | Attack counts + active ACL entries + recent audit events |
| ACL | Recent ACL entries with kind/value/action/source/expiry |
| Audit Log | HMAC-chained audit log entries |
| Live Traffic | Sampled traffic feed |
| Scanner | Latest run stats + manual scan button |
| WAF Rules | Built-in + user-defined rules |
| Threat Feeds | Configured providers + availability |
| Cache | Shield cache key inspection + clear |
| Diagnostics | Sysinfo + OWASP env audit grade |

Each page is a thin wrapper around the `OzanKurt\Shield` models + services — no separate state.

## Authorization

The plugin inherits your panel's `->authGuard()` and `->authMiddleware()` config. There's no separate Shield authorization layer — if your user can access the Filament panel, they see Shield.

To restrict Shield pages further, override `canAccess()` on each Page:

```php
use OzanKurt\ShieldFilament\Filament\Pages\Dashboard;

Dashboard::canAccessUsing(fn () => auth()->user()?->is_admin);
```

## Customize navigation

Publish + edit the config:

```bash
php artisan vendor:publish --tag=shield-filament-config
```

Override the navigation group name, icons per page, or sort order.

## Publish + customize views

```bash
php artisan vendor:publish --tag=shield-filament-views
```

Then edit the per-page Blade files at `resources/views/vendor/shield-filament/pages/*.blade.php`.

## License

MIT — see [LICENSE.md](LICENSE.md).
