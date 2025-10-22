[![GitHub Workflow Status][ico-tests]][link-tests]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

------

# Shipit SDK

A Saloon v3-based PHP SDK for the Shipit API with Spatie Laravel Data v4 DTOs.

## Requirements

> **Requires [PHP 8.4+](https://php.net/releases/)**

## Installation

```bash
composer require cline/shipit
```

## Quick Start

```php
use Cline\Shipit\Connector\ShipitConnector;

// Auto-detect environment (production uses live, non-production uses test)
$shipit = ShipitConnector::new('your-api-token');

// Or explicitly choose environment
$shipit = ShipitConnector::live('your-api-token');  // Production
$shipit = ShipitConnector::test('your-api-token');  // Test environment
```

## Documentation

Comprehensive cookbooks covering all SDK features:

- [Getting Started](cookbooks/01-getting-started.md) - Installation and basic setup
- [Shipping Methods](cookbooks/02-shipping-methods.md) - Query carriers and rates
- [Creating Shipments](cookbooks/03-creating-shipments.md) - Create shipments and labels
- [Service Points](cookbooks/04-service-points.md) - Find pickup/delivery locations
- [Postal Codes](cookbooks/05-postal-codes.md) - Validate addresses
- [Tracking](cookbooks/06-tracking.md) - Track shipments
- [Locations](cookbooks/07-locations.md) - Manage addresses
- [Organizations](cookbooks/08-organizations.md) - Manage organizations
- [User Management](cookbooks/09-user-management.md) - User accounts
- [Balance & Accounting](cookbooks/10-balance-accounting.md) - Financial reporting
- [Advanced Features](cookbooks/11-advanced-features.md) - Carrier contracts, templates, batch processing
- [Error Handling](cookbooks/12-error-handling.md) - Robust error handling
- [Testing](cookbooks/13-testing.md) - Testing strategies

## Features

- **Saloon v3** - Modern HTTP client abstraction
- **Spatie Laravel Data v4** - Type-safe DTOs
- **Full API Coverage** - All Shipit API endpoints
- **Typed Responses** - Complete IDE autocomplete support
- **Error Handling** - Automatic exception throwing on errors
- **Multiple Environments** - Easy switching between test/live APIs

## Architecture

The SDK uses:
- Saloon v3 for HTTP client abstraction
- Spatie Laravel Data v4 for type-safe DTOs
- Strictly typed based on API form request validations

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please use the [GitHub security reporting form][link-security] rather than the issue queue.

## Credits

- [Brian Faust][link-maintainer]
- [All Contributors][link-contributors]

## License

The MIT License. Please see [License File](LICENSE.md) for more information.

[ico-tests]: https://github.com/faustbrian/shipit/actions/workflows/quality-assurance.yaml/badge.svg
[ico-version]: https://img.shields.io/packagist/v/cline/shipit.svg
[ico-license]: https://img.shields.io/badge/License-MIT-green.svg
[ico-downloads]: https://img.shields.io/packagist/dt/cline/shipit.svg

[link-tests]: https://github.com/faustbrian/shipit/actions
[link-packagist]: https://packagist.org/packages/cline/shipit
[link-downloads]: https://packagist.org/packages/cline/shipit
[link-security]: https://github.com/faustbrian/shipit/security
[link-maintainer]: https://github.com/faustbrian
[link-contributors]: ../../contributors
