# Shipping Methods

Query available shipping methods, carriers, and rates for your shipments.

## Get Shipping Methods with Rates

Returns available shipping methods with pricing based on shipment details:

```php
use Cline\Shipit\Data\ShippingMethodsRequestData;

$methods = $shipit->shippingMethods()->get(
    ShippingMethodsRequestData::from([
        'sender' => [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+358401234567',
            'address' => 'Street 123',
            'city' => 'Helsinki',
            'postcode' => '00100',
            'country' => 'FI',
        ],
        'receiver' => [
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '+358401234568',
            'address' => 'Avenue 456',
            'city' => 'Espoo',
            'postcode' => '02100',
            'country' => 'FI',
        ],
        'parcels' => [
            [
                'length' => 30,
                'width' => 20,
                'height' => 10,
                'weight' => 2.5,
            ],
        ],
        'fragile' => false,
    ])
);

// Returns ShippingMethodsResponseData
foreach ($methods->methods as $method) {
    echo $method->serviceName;  // "Posti Home Delivery"
    echo $method->serviceId;    // "posti.2103"
    echo $method->carrier;      // "Posti"
    echo $method->price;        // 8.50
}
```

## List All Available Methods

Get a complete list of shipping methods without rate calculation:

```php
$allMethods = $shipit->shippingMethods()->list();

// Returns ShippingMethodListResponseData
foreach ($allMethods->methods as $method) {
    echo $method->serviceId;
    echo $method->serviceName;
    echo $method->carrier;
}
```

## Get Method Details

Retrieve detailed information about a specific shipping method:

```php
$details = $shipit->shippingMethods()->details('posti.2103');

// Returns ShippingMethodDetailsResponseData
echo $details->serviceName;
echo $details->description;
echo $details->carrier;
```

## Quick Shipping Methods

Get shipping methods optimized for quick selection:

```php
use Cline\Shipit\Data\ShippingMethodsRequestData;

$quickMethods = $shipit->shippingMethods()->quick(
    ShippingMethodsRequestData::from([
        'sender' => [...],
        'receiver' => [...],
        'parcels' => [...],
    ])
);

// Returns QuickShippingMethodsResponseData
```

## Working with Parcels

Multiple parcels can be included in a single request:

```php
ShippingMethodsRequestData::from([
    'sender' => [...],
    'receiver' => [...],
    'parcels' => [
        [
            'length' => 30,
            'width' => 20,
            'height' => 10,
            'weight' => 2.5,
        ],
        [
            'length' => 40,
            'width' => 30,
            'height' => 20,
            'weight' => 5.0,
        ],
    ],
])
```

## Optional Parameters

```php
ShippingMethodsRequestData::from([
    'sender' => [...],
    'receiver' => [...],
    'parcels' => [...],
    'fragile' => true,                    // Mark shipment as fragile
    'insurance' => 500.00,                // Insurance value
    'cod' => ['amount' => 100.00],        // Cash on delivery
    'deliveryDate' => '2025-01-25',       // Requested delivery date
])
```

## Next Steps

- [Creating Shipments](./03-creating-shipments.md)
- [Service Points](./04-service-points.md)
