# Testing

Testing strategies for applications using the Shipit SDK.

## Mock Connector for Tests

Create a mock connector for testing without real API calls:

```php
use PHPUnit\Framework\TestCase;

class ShipmentTest extends TestCase
{
    private ShipitConnector $mockShipit;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test API endpoint
        $this->mockShipit = ShipitConnector::test('test-api-token');
    }

    public function test_creates_shipment(): void
    {
        $shipmentData = ShipmentRequestData::from([
            'sender' => $this->getSenderData(),
            'receiver' => $this->getReceiverData(),
            'parcels' => $this->getParcelData(),
            'serviceId' => 'posti.2103',
        ]);

        $shipment = $this->mockShipit->shipments()->create($shipmentData);

        $this->assertInstanceOf(ShipmentResponseData::class, $shipment);
        $this->assertNotEmpty($shipment->trackingNumber);
        $this->assertEquals(1, $shipment->status);
    }
}
```

## Mocking API Responses

Use Saloon's MockClient for unit tests:

```php
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

class ShipmentServiceTest extends TestCase
{
    public function test_handles_successful_shipment_creation(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'status' => 1,
                'trackingNumber' => 'JJFI12345678901234567890',
                'trackingUrls' => ['https://tracking.example.com/JJFI12345678901234567890'],
                'labels' => ['https://labels.example.com/label.pdf'],
            ], 200),
        ]);

        $shipit = ShipitConnector::test('test-token');
        $shipit->withMockClient($mockClient);

        $shipment = $shipit->shipments()->create($this->getTestShipmentData());

        $this->assertEquals('JJFI12345678901234567890', $shipment->trackingNumber);
        $this->assertEquals(1, $shipment->status);
    }

    public function test_handles_validation_error(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'status' => 0,
                'error' => 'Validation failed',
                'errors' => [
                    'receiver.postcode' => ['The postal code field is required.'],
                ],
            ], 422),
        ]);

        $shipit = ShipitConnector::test('test-token');
        $shipit->withMockClient($mockClient);

        $this->expectException(FatalRequestException::class);

        $shipit->shipments()->create($this->getInvalidShipmentData());
    }
}
```

## Integration Tests

Test real API integration in a controlled environment:

```php
class ShipitIntegrationTest extends TestCase
{
    private ShipitConnector $shipit;

    protected function setUp(): void
    {
        parent::setUp();

        // Use test environment with real API
        $this->shipit = ShipitConnector::test(
            env('SHIPIT_TEST_API_TOKEN')
        );
    }

    public function test_complete_shipment_workflow(): void
    {
        // 1. Get shipping methods
        $methods = $this->shipit->shippingMethods()->get(
            ShippingMethodsRequestData::from([
                'sender' => $this->getTestSender(),
                'receiver' => $this->getTestReceiver(),
                'parcels' => $this->getTestParcels(),
            ])
        );

        $this->assertNotEmpty($methods->methods);
        $serviceId = $methods->methods->first()->serviceId;

        // 2. Create shipment
        $shipment = $this->shipit->shipments()->create(
            ShipmentRequestData::from([
                'sender' => $this->getTestSender(),
                'receiver' => $this->getTestReceiver(),
                'parcels' => $this->getTestParcels(),
                'serviceId' => $serviceId,
                'reference' => 'TEST-' . time(),
            ])
        );

        $this->assertNotEmpty($shipment->trackingNumber);

        // 3. Track shipment
        $tracking = $this->shipit->tracking()->events($shipment->trackingNumber);

        $this->assertEquals($shipment->trackingNumber, $tracking->trackingNumber);
    }

    private function getTestSender(): array
    {
        return [
            'name' => 'Test Sender',
            'email' => 'sender@test.com',
            'phone' => '+358401234567',
            'address' => 'Test Street 1',
            'city' => 'Helsinki',
            'postcode' => '00100',
            'country' => 'FI',
        ];
    }

    private function getTestReceiver(): array
    {
        return [
            'name' => 'Test Receiver',
            'email' => 'receiver@test.com',
            'phone' => '+358409876543',
            'address' => 'Test Avenue 2',
            'city' => 'Espoo',
            'postcode' => '02100',
            'country' => 'FI',
        ];
    }

    private function getTestParcels(): array
    {
        return [
            [
                'length' => 30,
                'width' => 20,
                'height' => 10,
                'weight' => 2.0,
            ],
        ];
    }
}
```

## Test Helpers

Create test helpers for common scenarios:

```php
trait ShipitTestHelpers
{
    protected function createTestShipmentData(array $overrides = []): ShipmentRequestData
    {
        return ShipmentRequestData::from(array_merge([
            'sender' => [
                'name' => 'Test Company',
                'email' => 'test@company.com',
                'phone' => '+358401234567',
                'address' => 'Business St 1',
                'city' => 'Helsinki',
                'postcode' => '00100',
                'country' => 'FI',
            ],
            'receiver' => [
                'name' => 'Test Customer',
                'email' => 'customer@test.com',
                'phone' => '+358409876543',
                'address' => 'Home St 2',
                'city' => 'Tampere',
                'postcode' => '33100',
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
            'serviceId' => 'posti.2103',
            'reference' => 'TEST-' . time(),
        ], $overrides));
    }

    protected function mockSuccessfulShipmentResponse(): array
    {
        return [
            'status' => 1,
            'trackingNumber' => 'JJFI' . str_pad((string) rand(1, 999999), 20, '0'),
            'trackingUrls' => ['https://tracking.example.com/track'],
            'labels' => ['https://labels.example.com/label.pdf'],
        ];
    }

    protected function mockValidationErrorResponse(): array
    {
        return [
            'status' => 0,
            'error' => 'Validation failed',
            'errors' => [
                'receiver.postcode' => ['The postal code field is required.'],
            ],
        ];
    }
}

// Usage in tests
class MyShipmentTest extends TestCase
{
    use ShipitTestHelpers;

    public function test_creates_shipment_with_custom_reference(): void
    {
        $shipmentData = $this->createTestShipmentData([
            'reference' => 'CUSTOM-REF-123',
        ]);

        // ... test implementation
    }
}
```

## Feature Tests (Laravel)

Test SDK integration in Laravel applications:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderShipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_order_creates_shipment(): void
    {
        // Mock Shipit API
        $mockClient = new MockClient([
            MockResponse::make([
                'status' => 1,
                'trackingNumber' => 'JJFI12345',
                'trackingUrls' => ['https://tracking.example.com'],
                'labels' => ['https://labels.example.com/label.pdf'],
            ], 200),
        ]);

        $shipit = ShipitConnector::test('test-token');
        $shipit->withMockClient($mockClient);

        $this->app->instance(ShipitConnector::class, $shipit);

        // Create order
        $order = Order::factory()->create([
            'customer_name' => 'John Doe',
            'shipping_address' => 'Test St 1',
            'shipping_city' => 'Helsinki',
            'shipping_postcode' => '00100',
            'shipping_country' => 'FI',
        ]);

        // Process shipment
        dispatch(new CreateShipmentJob($order));

        // Assert shipment was created
        $this->assertDatabaseHas('shipments', [
            'order_id' => $order->id,
            'tracking_number' => 'JJFI12345',
        ]);
    }
}
```

## Testing Error Scenarios

Test error handling:

```php
class ErrorHandlingTest extends TestCase
{
    public function test_handles_network_timeout(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([], 504), // Gateway timeout
        ]);

        $shipit = ShipitConnector::test('test-token');
        $shipit->withMockClient($mockClient);

        $this->expectException(FatalRequestException::class);

        $shipit->shipments()->create($this->createTestShipmentData());
    }

    public function test_handles_unauthorized_access(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'error' => 'Unauthorized',
            ], 401),
        ]);

        $shipit = ShipitConnector::test('invalid-token');
        $shipit->withMockClient($mockClient);

        $this->expectException(FatalRequestException::class);

        $shipit->shipments()->create($this->createTestShipmentData());
    }

    public function test_handles_rate_limit(): void
    {
        $mockClient = new MockClient([
            MockResponse::make([
                'error' => 'Rate limit exceeded',
            ], 429, ['Retry-After' => '60']),
        ]);

        $shipit = ShipitConnector::test('test-token');
        $shipit->withMockClient($mockClient);

        try {
            $shipit->shipments()->create($this->createTestShipmentData());
            $this->fail('Expected exception was not thrown');
        } catch (FatalRequestException $e) {
            $this->assertEquals(429, $e->getResponse()->status());
            $this->assertEquals('60', $e->getResponse()->header('Retry-After'));
        }
    }
}
```

## Performance Testing

Test API performance:

```php
class PerformanceTest extends TestCase
{
    public function test_batch_shipment_creation_performance(): void
    {
        $shipit = ShipitConnector::test(env('SHIPIT_TEST_API_TOKEN'));

        $startTime = microtime(true);
        $shipmentCount = 10;

        for ($i = 0; $i < $shipmentCount; $i++) {
            $shipit->shipments()->create($this->createTestShipmentData([
                'reference' => "PERF-TEST-{$i}",
            ]));
        }

        $duration = microtime(true) - $startTime;
        $avgTime = $duration / $shipmentCount;

        // Assert average time per shipment is acceptable
        $this->assertLessThan(2.0, $avgTime,
            "Average shipment creation time exceeded 2 seconds"
        );
    }
}
```

## Next Steps

- [Getting Started](./01-getting-started.md)
- [Error Handling](./12-error-handling.md)
