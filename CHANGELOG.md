# Changelog

## [1.0.0] - 2026-05-26

### Added
- Initial release of the Filament adapter for Laravel Shield
- Nine Pages under the **Shield** navigation group: Dashboard, ACL, Audit Log,
  Live Traffic, Scanner, WAF Rules, Threat Feeds, Cache, Diagnostics
- `ShieldPlugin` plugin entry point — register inside any Filament PanelProvider
- Compatible with Filament 3 and Filament 4 (`filament/filament: ^3.0|^4.0`)

### Notes
- For Filament 5+, install `ozankurt/laravel-shield-filament:^2.0` (separate branch).
- All Pages are thin wrappers around the underlying `OzanKurt\Shield` models +
  services. State is shared with the core package's database tables.
