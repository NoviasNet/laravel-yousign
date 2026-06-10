# Changelog

All notable changes to `laravel-yousign` will be documented in this file.

## v3.1.0 - 2026-06-10

### Changed
- `updateSigner` now accepts an optional `array $data` parameter to pass update payload

### Removed
- Removed unused `YousignCommand` placeholder class and all related references from the service provider
- Removed unused `getBrandingId()` config accessor from `Config` and the `branding_id` config key
- Removed `psr/simple-cache` dependency (was never used in the package)

### Added
- Added full test suite: 32 tests covering `Config`, `Client`, webhook pipeline (`YousignSignatureValidator`, `YousignWebhookProfile`, `ProcessYousignWebhookJob`), exceptions, and architecture assertions

### Fixed
- Fixed `YousignWebhookProfile` deduplication bug where `shouldProcess()` queried a non-existent `event_name` column instead of `name`, causing duplicate webhooks to always be processed

## v3.0.0 - 2025-11-09

### Breaking
- Package namespace and vendor migrated from `Assiclick\Yousign` to `NoviasNet\Yousign`
- Composer package renamed from `assiclick/laravel-yousign` to `noviasnet/laravel-yousign`

### Changed
- Updated all class imports and namespace references throughout the codebase
- Consistently formatted concatenation and function calls
- Added TLint and PHP-CS-Fixer configuration for code style enforcement
- Added Rector configuration for automated code upgrades

## 2.0.0 - 2025-05-20

### Changed
- Dependency maintenance release

## v1.0.0 - 2023-04-19

### Added
- Initial release
- `SignatureRequest` resource with full CRUD, document management (add, replace, update, delete, download), signer management (create, get, update, delete), and audit trail download
- HTTP client with Bearer token authentication, support for `json`, `raw`, and `full` response modes, and multipart file uploads
- `SignerException` for human-readable Yousign signer validation errors
- Webhook support via `spatie/laravel-webhook-client`: HMAC-SHA256 signature validation, deduplication profile, event dispatch (`yousign-webhooks::{event_name}`), and job routing by event name
- `Route::yousignWebhooks($url)` macro for easy webhook route registration
- `InvalidConfig` exception for missing or invalid configuration values
