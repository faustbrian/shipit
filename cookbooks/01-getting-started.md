# Getting Started

## Installation

```bash
composer require cline/shipit
```

## Requirements

- PHP 8.4+
- Saloon v3
- Spatie Laravel Data v4

## Basic Setup

The SDK provides three factory methods for creating a connector:

```php
use Cline\Shipit\Connector\ShipitConnector;

// Auto-detects environment: production uses live API, non-production uses test API
$shipit = ShipitConnector::new('your-api-token');

// Explicitly use live API (https://api.shipit.ax)
$shipit = ShipitConnector::live('your-api-token');

// Explicitly use test API (https://apitest.shipit.ax)
$shipit = ShipitConnector::test('your-api-token');
```

## Available Resources

Once you have a connector instance, you can access all resources:

```php
$shipit->shippingMethods()      // Query shipping methods and rates
$shipit->shipments()            // Create and manage shipments
$shipit->agents()               // Find pickup/delivery locations
$shipit->postalCodes()          // Validate postal codes
$shipit->locations()            // Manage sender/receiver addresses
$shipit->organizations()        // Manage organizations
$shipit->tracking()             // Track shipments
$shipit->user()                 // Manage user account
$shipit->balance()              // Check balance and transactions
$shipit->carrierContracts()     // Manage carrier contracts
$shipit->consignmentTemplates() // Manage shipment templates
$shipit->organizationMembers()  // Manage team members
```

## Response Handling

All methods return typed DTOs that throw exceptions on HTTP errors:

```php
try {
    $methods = $shipit->shippingMethods()->get($requestData);

    // Access typed properties
    foreach ($methods->methods as $method) {
        echo $method->serviceName;
        echo $method->price;
    }
} catch (\Saloon\Exceptions\Request\FatalRequestException $e) {
    $response = $e->getResponse();
    $statusCode = $response->status();
    $errorData = $response->json();
}
```

## Next Steps

- [Shipping Methods](./02-shipping-methods.md) - Query available carriers and rates
- [Creating Shipments](./03-creating-shipments.md) - Create shipments and labels
- [Service Points](./04-service-points.md) - Find pickup and delivery locations
- [Postal Codes](./05-postal-codes.md) - Validate addresses
