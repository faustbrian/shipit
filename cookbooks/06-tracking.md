# Tracking Shipments

Track shipments and retrieve tracking information.

## Query Tracking Events

Get detailed tracking events for a shipment:

```php
$tracking = $shipit->tracking()->events('JJFI12345678901234567890');

// Returns TrackingEventResponseData
echo $tracking->trackingNumber;
echo $tracking->status;  // "delivered", "in_transit", "pending", etc.

foreach ($tracking->events as $event) {
    echo $event->timestamp;    // "2025-01-20 14:30:00"
    echo $event->description;  // "Package delivered"
    echo $event->location;     // "Helsinki"
    echo $event->status;       // "delivered"
}
```

## Get Tracking Link

Generate a tracking URL for customers:

```php
$link = $shipit->tracking()->link('JJFI12345678901234567890');

// Returns TrackingLinkResponseData
echo $link->url;  // "https://www.posti.fi/track/JJFI12345678901234567890"
```

## Track Multiple Shipments

Query tracking for multiple shipments:

```php
$trackingNumbers = ['JJFI001', 'JJFI002', 'JJFI003'];

$trackingData = [];
foreach ($trackingNumbers as $trackingNumber) {
    $tracking = $shipit->tracking()->events($trackingNumber);
    $trackingData[$trackingNumber] = $tracking;
}
```

## Display Tracking Status

Show tracking information to customers:

```php
$tracking = $shipit->tracking()->events($trackingNumber);

echo "Status: {$tracking->status}\n";
echo "Current Location: {$tracking->currentLocation}\n";
echo "Estimated Delivery: {$tracking->estimatedDelivery}\n";

echo "\nTracking History:\n";
foreach ($tracking->events as $event) {
    echo "[{$event->timestamp}] {$event->description} - {$event->location}\n";
}
```

## Tracking Status Types

Common tracking statuses:

```php
$tracking = $shipit->tracking()->events($trackingNumber);

switch ($tracking->status) {
    case 'pending':
        echo "Shipment created, waiting for carrier pickup";
        break;
    case 'in_transit':
        echo "Package is on its way";
        break;
    case 'out_for_delivery':
        echo "Package is out for delivery today";
        break;
    case 'delivered':
        echo "Package has been delivered";
        break;
    case 'failed':
        echo "Delivery attempt failed";
        break;
    case 'returned':
        echo "Package is being returned to sender";
        break;
}
```

## Customer Notification

Send tracking information to customers:

```php
$tracking = $shipit->tracking()->events($trackingNumber);
$trackingLink = $shipit->tracking()->link($trackingNumber);

$emailData = [
    'trackingNumber' => $tracking->trackingNumber,
    'status' => $tracking->status,
    'trackingUrl' => $trackingLink->url,
    'estimatedDelivery' => $tracking->estimatedDelivery,
];

// Send email to customer
sendTrackingEmail($customer->email, $emailData);
```

## Webhook Integration

Process tracking updates via webhooks:

```php
// Webhook endpoint receives tracking update
$webhookData = json_decode(file_get_contents('php://input'), true);

$trackingNumber = $webhookData['trackingNumber'];
$status = $webhookData['status'];

// Fetch full tracking details
$tracking = $shipit->tracking()->events($trackingNumber);

// Update your database
updateOrderStatus($trackingNumber, $tracking->status, $tracking->events);

// Notify customer of status change
if ($status === 'delivered') {
    sendDeliveryConfirmation($trackingNumber);
}
```

## Tracking from Shipment Response

Get tracking information immediately after creating a shipment:

```php
use Cline\Shipit\Data\ShipmentRequestData;

$shipment = $shipit->shipments()->create($shipmentData);

// Tracking information is in the response
echo $shipment->trackingNumber;

// Tracking URLs for each carrier
foreach ($shipment->trackingUrls as $url) {
    echo $url;
}

// Or query detailed events
$tracking = $shipit->tracking()->events($shipment->trackingNumber);
```

## Next Steps

- [Managing Locations](./07-locations.md)
- [Organizations](./08-organizations.md)
