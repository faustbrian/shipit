# Service Points (Agents)

Find pickup and delivery locations for your shipments.

## Search for Service Points

Find service points by postal code and carrier:

```php
$agents = $shipit->agents()->get([
    'serviceId' => 'posti.2103',
    'country' => 'FI',
    'postcode' => '00100',
]);

// Returns AgentsResponseData
foreach ($agents->agents as $agent) {
    echo $agent->name;          // "R-kioski Keskusta"
    echo $agent->address;       // "Mannerheimintie 10"
    echo $agent->city;          // "Helsinki"
    echo $agent->postcode;      // "00100"
    echo $agent->agentId;       // "12345"

    // Location coordinates
    echo $agent->location->lat;  // 60.1699
    echo $agent->location->lng;  // 24.9384

    // Opening hours
    print_r($agent->openingHours);
}
```

## Get Specific Service Point

Retrieve details for a specific service point:

```php
$agent = $shipit->agents()->getById('12345');

// Returns AgentResponseData
echo $agent->name;
echo $agent->address;
echo $agent->city;
echo $agent->postcode;
echo $agent->phone;
echo $agent->email;
```

## Search with Additional Filters

```php
$agents = $shipit->agents()->get([
    'serviceId' => 'posti.2103',
    'country' => 'FI',
    'postcode' => '00100',
    'limit' => 10,          // Limit number of results
    'city' => 'Helsinki',   // Filter by city
]);
```

## Working with Service Point Data

Access location details and opening hours:

```php
$agents = $shipit->agents()->get([...]);

foreach ($agents->agents as $agent) {
    // Basic information
    echo "Name: {$agent->name}\n";
    echo "Address: {$agent->address}, {$agent->city}\n";

    // Location coordinates for map display
    if ($agent->location) {
        echo "Lat: {$agent->location->lat}\n";
        echo "Lng: {$agent->location->lng}\n";
    }

    // Opening hours
    if ($agent->openingHours) {
        foreach ($agent->openingHours as $day => $hours) {
            echo "$day: {$hours->open} - {$hours->close}\n";
        }
    }

    // Services available
    if ($agent->services) {
        print_r($agent->services);
    }
}
```

## Display on Map

Use the location coordinates to display service points on a map:

```php
$agents = $shipit->agents()->get([...]);

$mapPoints = array_map(function($agent) {
    return [
        'id' => $agent->agentId,
        'name' => $agent->name,
        'address' => $agent->address,
        'lat' => $agent->location->lat,
        'lng' => $agent->location->lng,
    ];
}, $agents->agents->toArray());

// Pass $mapPoints to your frontend map component
```

## Select Service Point for Shipment

Once you've found a service point, use it in your shipment:

```php
use Cline\Shipit\Data\ShipmentRequestData;

$shipment = $shipit->shipments()->create(
    ShipmentRequestData::from([
        'sender' => [...],
        'receiver' => [
            'name' => 'Customer Name',
            'email' => 'customer@example.com',
            'phone' => '+358401234567',
            // Service point details
            'agentId' => '12345',
            'country' => 'FI',
        ],
        'parcels' => [...],
        'serviceId' => 'posti.2103',
    ])
);
```

## Next Steps

- [Postal Codes](./05-postal-codes.md)
- [Creating Shipments](./03-creating-shipments.md)
