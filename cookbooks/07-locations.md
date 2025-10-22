# Managing Locations

Manage sender and receiver address locations for reuse.

## List All Locations

```php
$locations = $shipit->locations()->index();

// Returns LocationResponseData with collection
foreach ($locations->locations as $location) {
    echo $location->id;
    echo $location->name;
    echo $location->address;
    echo $location->city;
    echo $location->postcode;
    echo $location->country;
}
```

## Get Specific Location

```php
$location = $shipit->locations()->show('location-id');

// Returns LocationResponseData
echo $location->name;
echo $location->email;
echo $location->phone;
echo $location->address;
echo $location->city;
echo $location->postcode;
echo $location->country;
```

## Create Location

```php
$location = $shipit->locations()->store([
    'name' => 'Main Warehouse',
    'email' => 'warehouse@company.com',
    'phone' => '+358401234567',
    'address' => 'Industrial Road 100',
    'city' => 'Helsinki',
    'postcode' => '00100',
    'country' => 'FI',
]);

// Returns LocationResponseData
echo $location->id;  // Save this ID for future use
```

## Update Location

```php
$location = $shipit->locations()->update('location-id', [
    'name' => 'Updated Warehouse Name',
    'phone' => '+358409876543',
]);

// Returns updated LocationResponseData
```

## Delete Location

```php
$result = $shipit->locations()->destroy('location-id');

// Returns LocationResponseData with deletion confirmation
```

## Use Location in Shipment

Once created, use a location as sender or receiver:

```php
use Cline\Shipit\Data\ShipmentRequestData;

// Get your saved location
$warehouse = $shipit->locations()->show('warehouse-location-id');

$shipment = $shipit->shipments()->create(
    ShipmentRequestData::from([
        'sender' => [
            'name' => $warehouse->name,
            'email' => $warehouse->email,
            'phone' => $warehouse->phone,
            'address' => $warehouse->address,
            'city' => $warehouse->city,
            'postcode' => $warehouse->postcode,
            'country' => $warehouse->country,
        ],
        'receiver' => [
            'name' => 'Customer Name',
            // ... customer details
        ],
        'parcels' => [...],
        'serviceId' => 'posti.2103',
    ])
);
```

## Location Templates

Create commonly used locations for quick access:

```php
// Create warehouse location
$warehouse = $shipit->locations()->store([
    'name' => 'Helsinki Warehouse',
    'email' => 'warehouse.hki@company.com',
    'phone' => '+358401111111',
    'address' => 'Warehouse Street 1',
    'city' => 'Helsinki',
    'postcode' => '00100',
    'country' => 'FI',
]);

// Create retail store location
$store = $shipit->locations()->store([
    'name' => 'Tampere Store',
    'email' => 'store.tre@company.com',
    'phone' => '+358402222222',
    'address' => 'Shopping Street 10',
    'city' => 'Tampere',
    'postcode' => '33100',
    'country' => 'FI',
]);

// Create return address location
$returns = $shipit->locations()->store([
    'name' => 'Returns Department',
    'email' => 'returns@company.com',
    'phone' => '+358403333333',
    'address' => 'Returns Center 5',
    'city' => 'Espoo',
    'postcode' => '02100',
    'country' => 'FI',
]);
```

## Location Management in Application

Implement location management in your application:

```php
class LocationManager
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function getDefaultSender(): LocationResponseData
    {
        // Get stored default location ID from config
        $locationId = config('shipping.default_sender_location_id');

        return $this->shipit->locations()->show($locationId);
    }

    public function createLocationFromAddress(array $address): LocationResponseData
    {
        return $this->shipit->locations()->store($address);
    }

    public function updateLocation(string $id, array $updates): LocationResponseData
    {
        return $this->shipit->locations()->update($id, $updates);
    }

    public function getAllLocations(): array
    {
        $response = $this->shipit->locations()->index();
        return $response->locations->toArray();
    }
}
```

## Validation

Validate location data before creating:

```php
// Use postal code validation
$postalMatch = $shipit->postalCodes()->match(
    PostalCodeRequestData::from([
        'country' => 'FI',
        'postalCode' => '00100',
    ])
);

if ($postalMatch->isValid) {
    $location = $shipit->locations()->store([
        'name' => 'New Location',
        'address' => 'Street 123',
        'city' => $postalMatch->city,  // Use validated city
        'postcode' => $postalMatch->postalCode,
        'country' => 'FI',
        // ... other fields
    ]);
}
```

## Next Steps

- [Organizations](./08-organizations.md)
- [User Management](./09-user-management.md)
