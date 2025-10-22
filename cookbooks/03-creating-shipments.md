# Creating Shipments

Create shipments, generate labels, and manage the shipment lifecycle.

## Create a Shipment

```php
use Cline\Shipit\Data\ShipmentRequestData;

$shipment = $shipit->shipments()->create(
    ShipmentRequestData::from([
        'sender' => [
            'name' => 'Company Ltd',
            'email' => 'sender@company.com',
            'phone' => '+358401234567',
            'address' => 'Business Street 1',
            'city' => 'Helsinki',
            'postcode' => '00100',
            'country' => 'FI',
        ],
        'receiver' => [
            'name' => 'Customer Name',
            'email' => 'customer@example.com',
            'phone' => '+358407654321',
            'address' => 'Home Street 2',
            'city' => 'Tampere',
            'postcode' => '33100',
            'country' => 'FI',
        ],
        'parcels' => [
            [
                'length' => 40,
                'width' => 30,
                'height' => 20,
                'weight' => 5.0,
                'copies' => 1,
            ],
        ],
        'serviceId' => 'posti.2103',
        'reference' => 'ORDER-12345',
    ])
);

// Returns ShipmentResponseData
echo $shipment->trackingNumber;  // "JJFI12345678901234567890"
echo $shipment->status;          // 1
print_r($shipment->trackingUrls); // Array of tracking URLs
print_r($shipment->labels);       // Array of label URLs
```

## Multiple Parcels

Create a shipment with multiple parcels:

```php
ShipmentRequestData::from([
    'sender' => [...],
    'receiver' => [...],
    'parcels' => [
        [
            'length' => 30,
            'width' => 20,
            'height' => 10,
            'weight' => 2.5,
            'copies' => 2,  // Create 2 identical parcels
        ],
        [
            'length' => 40,
            'width' => 30,
            'height' => 20,
            'weight' => 5.0,
            'copies' => 1,
        ],
    ],
    'serviceId' => 'posti.2103',
])
```

## Create Pending Shipment

Create a shipment that won't be sent to the carrier immediately:

```php
$pending = $shipit->shipments()->createPending($shipmentData);

// Returns ShipmentResponseData
echo $pending->trackingNumber;
```

## Validate Shipment

Validate shipment data without creating it:

```php
$validation = $shipit->shipments()->validate($shipmentData);

// Returns ValidateShipmentResponseData
if ($validation->status === 1) {
    echo "Shipment is valid";
} else {
    print_r($validation->errors);
}
```

## Book Customer Return

Create a return shipment:

```php
$return = $shipit->shipments()->bookReturn(
    ShipmentRequestData::from([
        'sender' => [
            'name' => 'Customer Name',
            'email' => 'customer@example.com',
            // ... customer details
        ],
        'receiver' => [
            'name' => 'Company Ltd',
            'email' => 'returns@company.com',
            // ... company details
        ],
        'parcels' => [...],
        'serviceId' => 'posti.2103',
        'reference' => 'RETURN-12345',
    ])
);

// Returns ShipmentResponseData
```

## Consolidate Shipments

Combine multiple shipments into one:

```php
use Cline\Shipit\Data\ConsolidateShipmentRequestData;

$consolidation = $shipit->shipments()->consolidate(
    ConsolidateShipmentRequestData::from([
        'trackingNumbers' => ['JJFI001', 'JJFI002', 'JJFI003'],
        'serviceId' => 'posti.2103',
    ])
);

// Returns ConsolidateShipmentResponseData
echo $consolidation->trackingNumber;
```

## Book Pickup

Schedule a pickup for your shipment:

```php
use Cline\Shipit\Data\BookPickUpRequestData;

$pickup = $shipit->shipments()->bookPickup(
    BookPickUpRequestData::from([
        'trackingNumber' => 'JJFI12345678901234567890',
        'date' => '2025-01-20',
        'readyTime' => '09:00',
        'closeTime' => '16:00',
        'instructions' => 'Ring the doorbell, 2nd floor',
    ])
);

// Returns BookPickUpResponseData
echo $pickup->pickupId;
echo $pickup->status;
```

## Additional Services

Add optional services to your shipment:

```php
ShipmentRequestData::from([
    'sender' => [...],
    'receiver' => [...],
    'parcels' => [...],
    'serviceId' => 'posti.2103',
    'additionalServices' => [
        'sms' => true,              // SMS notification
        'email' => true,            // Email notification
        'fragile' => true,          // Fragile handling
        'saturdayDelivery' => true, // Saturday delivery
    ],
    'insurance' => 500.00,          // Insurance value
])
```

## Cash on Delivery

Create a shipment with cash on delivery:

```php
ShipmentRequestData::from([
    'sender' => [...],
    'receiver' => [...],
    'parcels' => [...],
    'serviceId' => 'posti.2103',
    'cod' => [
        'amount' => 99.99,
        'currency' => 'EUR',
        'account' => 'FI1234567890123456',
        'reference' => 'COD-12345',
    ],
])
```

## Customs Information

For international shipments:

```php
ShipmentRequestData::from([
    'sender' => [...],
    'receiver' => [
        'country' => 'SE',  // International destination
        // ... other receiver details
    ],
    'parcels' => [...],
    'serviceId' => 'posti.2461',
    'items' => [
        [
            'description' => 'Cotton T-Shirt',
            'quantity' => 2,
            'value' => 25.00,
            'weight' => 0.3,
            'hsCode' => '6109100010',
            'countryOfOrigin' => 'FI',
        ],
    ],
])
```

## Next Steps

- [Tracking Shipments](./06-tracking.md)
- [Managing Locations](./07-locations.md)
