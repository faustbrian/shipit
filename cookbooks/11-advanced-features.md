# Advanced Features

Advanced SDK features including carrier contracts, consignment templates, and custom integrations.

## Carrier Contracts

Manage your carrier contract settings.

### List Carrier Contracts

```php
$contracts = $shipit->carrierContracts()->index();

foreach ($contracts->contracts as $contract) {
    echo $contract->id;
    echo $contract->carrier;
    echo $contract->contractNumber;
    echo $contract->isActive;
    echo $contract->startDate;
    echo $contract->endDate;
}
```

### Get Specific Contract

```php
$contract = $shipit->carrierContracts()->show('contract-id');

echo $contract->carrier;
echo $contract->contractNumber;
echo $contract->rates;  // Custom rate information
```

### Create Carrier Contract

```php
$contract = $shipit->carrierContracts()->store([
    'carrier' => 'posti',
    'contractNumber' => 'CONTRACT-12345',
    'startDate' => '2025-01-01',
    'endDate' => '2025-12-31',
    'rates' => [
        // Custom rate configurations
    ],
]);
```

### Update Contract

```php
$contract = $shipit->carrierContracts()->update('contract-id', [
    'endDate' => '2026-12-31',
    'isActive' => true,
]);
```

## Consignment Templates

Create and manage reusable shipment templates.

### List Templates

```php
$templates = $shipit->consignmentTemplates()->index();

foreach ($templates->templates as $template) {
    echo $template->id;
    echo $template->name;
    echo $template->serviceId;
    echo $template->description;
}
```

### Get Template

```php
$template = $shipit->consignmentTemplates()->show('template-id');

echo $template->name;
echo $template->serviceId;
echo $template->defaultSender;
echo $template->defaultParcels;
```

### Create Template

```php
$template = $shipit->consignmentTemplates()->store([
    'name' => 'Standard Package',
    'serviceId' => 'posti.2103',
    'sender' => [
        'name' => 'Default Warehouse',
        'email' => 'warehouse@company.com',
        'phone' => '+358401234567',
        'address' => 'Warehouse St 1',
        'city' => 'Helsinki',
        'postcode' => '00100',
        'country' => 'FI',
    ],
    'parcels' => [
        [
            'length' => 30,
            'width' => 20,
            'height' => 10,
            'weight' => 2.0,
        ],
    ],
]);
```

### Use Template for Shipment

```php
use Cline\Shipit\Data\ShipmentRequestData;

$template = $shipit->consignmentTemplates()->show('template-id');

$shipment = $shipit->shipments()->create(
    ShipmentRequestData::from([
        'sender' => $template->defaultSender,
        'receiver' => [
            'name' => 'Customer Name',
            // ... customer details
        ],
        'parcels' => $template->defaultParcels,
        'serviceId' => $template->serviceId,
        'reference' => 'ORDER-12345',
    ])
);
```

## Batch Shipment Creation

Create multiple shipments efficiently:

```php
class BatchShipmentProcessor
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function createBatch(array $orders): array
    {
        $results = [];

        foreach ($orders as $order) {
            try {
                $shipment = $this->shipit->shipments()->create(
                    ShipmentRequestData::from([
                        'sender' => $this->getDefaultSender(),
                        'receiver' => $this->buildReceiver($order),
                        'parcels' => $this->buildParcels($order),
                        'serviceId' => $this->selectService($order),
                        'reference' => $order['id'],
                    ])
                );

                $results[] = [
                    'order_id' => $order['id'],
                    'tracking_number' => $shipment->trackingNumber,
                    'status' => 'success',
                ];
            } catch (\Exception $e) {
                $results[] = [
                    'order_id' => $order['id'],
                    'status' => 'failed',
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }

    private function getDefaultSender(): array
    {
        $location = $this->shipit->locations()->show('default-warehouse');

        return [
            'name' => $location->name,
            'email' => $location->email,
            'phone' => $location->phone,
            'address' => $location->address,
            'city' => $location->city,
            'postcode' => $location->postcode,
            'country' => $location->country,
        ];
    }

    private function buildReceiver(array $order): array
    {
        return [
            'name' => $order['customer_name'],
            'email' => $order['customer_email'],
            'phone' => $order['customer_phone'],
            'address' => $order['shipping_address'],
            'city' => $order['shipping_city'],
            'postcode' => $order['shipping_postcode'],
            'country' => $order['shipping_country'],
        ];
    }

    private function buildParcels(array $order): array
    {
        // Calculate total weight and dimensions from order items
        return [
            [
                'length' => $order['parcel_length'] ?? 30,
                'width' => $order['parcel_width'] ?? 20,
                'height' => $order['parcel_height'] ?? 10,
                'weight' => $order['parcel_weight'] ?? 2.0,
            ],
        ];
    }

    private function selectService(array $order): string
    {
        // Select service based on order requirements
        if ($order['express'] ?? false) {
            return 'posti.express';
        }

        return 'posti.2103';
    }
}
```

## Dynamic Service Selection

Automatically select the best shipping method:

```php
use Cline\Shipit\Data\ShippingMethodsRequestData;

class ServiceSelector
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function selectBestService(
        array $sender,
        array $receiver,
        array $parcels,
        array $criteria = []
    ): string {
        $methods = $this->shipit->shippingMethods()->get(
            ShippingMethodsRequestData::from([
                'sender' => $sender,
                'receiver' => $receiver,
                'parcels' => $parcels,
            ])
        );

        // Filter by criteria
        $filtered = collect($methods->methods);

        if (isset($criteria['max_price'])) {
            $filtered = $filtered->where('price', '<=', $criteria['max_price']);
        }

        if (isset($criteria['max_delivery_days'])) {
            $filtered = $filtered->where('deliveryDays', '<=', $criteria['max_delivery_days']);
        }

        if (isset($criteria['preferred_carrier'])) {
            $filtered = $filtered->where('carrier', $criteria['preferred_carrier']);
        }

        // Sort by price (cheapest first)
        $sorted = $filtered->sortBy('price');

        return $sorted->first()?->serviceId ?? throw new \Exception('No suitable service found');
    }
}

// Usage
$selector = new ServiceSelector($shipit);

$serviceId = $selector->selectBestService(
    sender: [...],
    receiver: [...],
    parcels: [...],
    criteria: [
        'max_price' => 15.00,
        'max_delivery_days' => 3,
        'preferred_carrier' => 'posti',
    ]
);
```

## Webhook Integration

Handle Shipit webhooks in your application:

```php
class ShipitWebhookHandler
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function handle(array $webhookPayload): void
    {
        match($webhookPayload['event']) {
            'shipment.created' => $this->handleShipmentCreated($webhookPayload),
            'shipment.delivered' => $this->handleShipmentDelivered($webhookPayload),
            'shipment.failed' => $this->handleShipmentFailed($webhookPayload),
            'tracking.updated' => $this->handleTrackingUpdated($webhookPayload),
            default => logger()->warning('Unknown webhook event', $webhookPayload),
        };
    }

    private function handleShipmentCreated(array $payload): void
    {
        $trackingNumber = $payload['tracking_number'];

        // Update your database
        DB::table('shipments')
            ->where('tracking_number', $trackingNumber)
            ->update(['status' => 'created']);
    }

    private function handleShipmentDelivered(array $payload): void
    {
        $trackingNumber = $payload['tracking_number'];

        // Fetch full tracking details
        $tracking = $this->shipit->tracking()->events($trackingNumber);

        // Update order status
        DB::table('shipments')
            ->where('tracking_number', $trackingNumber)
            ->update([
                'status' => 'delivered',
                'delivered_at' => now(),
            ]);

        // Send delivery confirmation to customer
        $this->sendDeliveryNotification($trackingNumber);
    }

    private function handleShipmentFailed(array $payload): void
    {
        $trackingNumber = $payload['tracking_number'];

        // Alert customer service
        $this->alertCustomerService($trackingNumber, $payload['reason']);
    }

    private function handleTrackingUpdated(array $payload): void
    {
        $trackingNumber = $payload['tracking_number'];

        // Fetch latest tracking information
        $tracking = $this->shipit->tracking()->events($trackingNumber);

        // Store tracking events
        foreach ($tracking->events as $event) {
            DB::table('tracking_events')->updateOrInsert(
                ['tracking_number' => $trackingNumber, 'timestamp' => $event->timestamp],
                ['description' => $event->description, 'location' => $event->location]
            );
        }
    }
}
```

## Custom Error Handling

Implement robust error handling:

```php
use Saloon\Exceptions\Request\FatalRequestException;

class ShipmentService
{
    public function createWithRetry(
        ShipmentRequestData $data,
        int $maxRetries = 3
    ): ShipmentResponseData {
        $attempt = 0;

        while ($attempt < $maxRetries) {
            try {
                return $this->shipit->shipments()->create($data);
            } catch (FatalRequestException $e) {
                $attempt++;
                $response = $e->getResponse();

                // Don't retry client errors (4xx)
                if ($response->status() >= 400 && $response->status() < 500) {
                    throw $e;
                }

                // Retry server errors (5xx) with exponential backoff
                if ($attempt < $maxRetries) {
                    sleep(pow(2, $attempt)); // 2, 4, 8 seconds
                    continue;
                }

                throw $e;
            }
        }
    }
}
```

## Next Steps

- [Error Handling](./12-error-handling.md)
- [Testing](./13-testing.md)
