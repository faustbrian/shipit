# Error Handling

Comprehensive error handling strategies for the Shipit SDK.

## Basic Error Handling

All SDK methods throw exceptions on HTTP errors:

```php
use Saloon\Exceptions\Request\FatalRequestException;

try {
    $shipment = $shipit->shipments()->create($shipmentData);
} catch (FatalRequestException $e) {
    $response = $e->getResponse();
    $statusCode = $response->status();
    $errorData = $response->json();

    echo "Request failed with status {$statusCode}";
    echo "Error: " . ($errorData['error'] ?? 'Unknown error');
}
```

## HTTP Status Codes

Handle different HTTP status codes:

```php
try {
    $shipment = $shipit->shipments()->create($shipmentData);
} catch (FatalRequestException $e) {
    $response = $e->getResponse();

    match($response->status()) {
        400 => $this->handleBadRequest($response),
        401 => $this->handleUnauthorized($response),
        403 => $this->handleForbidden($response),
        404 => $this->handleNotFound($response),
        422 => $this->handleValidationError($response),
        429 => $this->handleRateLimitExceeded($response),
        500, 502, 503 => $this->handleServerError($response),
        default => $this->handleUnknownError($response),
    };
}

private function handleBadRequest($response): void
{
    $error = $response->json();
    throw new \InvalidArgumentException(
        "Bad request: " . ($error['message'] ?? 'Invalid data')
    );
}

private function handleUnauthorized($response): void
{
    throw new \RuntimeException("Invalid API token - please check your credentials");
}

private function handleValidationError($response): void
{
    $errors = $response->json('errors', []);

    $messages = [];
    foreach ($errors as $field => $fieldErrors) {
        $messages[] = "{$field}: " . implode(', ', $fieldErrors);
    }

    throw new \InvalidArgumentException(
        "Validation failed:\n" . implode("\n", $messages)
    );
}

private function handleRateLimitExceeded($response): void
{
    $retryAfter = $response->header('Retry-After');
    throw new \RuntimeException(
        "Rate limit exceeded. Retry after {$retryAfter} seconds"
    );
}

private function handleServerError($response): void
{
    throw new \RuntimeException(
        "Server error occurred. Please try again later."
    );
}
```

## Validation Errors

Handle validation errors specifically:

```php
use Cline\Shipit\Data\ShipmentRequestData;

try {
    $shipment = $shipit->shipments()->create($shipmentData);
} catch (FatalRequestException $e) {
    if ($e->getResponse()->status() === 422) {
        $errors = $e->getResponse()->json('errors', []);

        // Display field-specific errors
        foreach ($errors as $field => $messages) {
            echo "Error in {$field}:\n";
            foreach ($messages as $message) {
                echo "  - {$message}\n";
            }
        }

        // Example output:
        // Error in receiver.postcode:
        //   - The postal code field is required.
        //   - The postal code must be 5 digits.
    }
}
```

## Retry Logic

Implement automatic retry for transient errors:

```php
class ResilientShipitClient
{
    public function __construct(
        private ShipitConnector $shipit,
        private int $maxRetries = 3,
        private int $retryDelay = 1000
    ) {}

    public function createShipment(
        ShipmentRequestData $data
    ): ShipmentResponseData {
        $attempt = 0;
        $lastException = null;

        while ($attempt < $this->maxRetries) {
            try {
                return $this->shipit->shipments()->create($data);
            } catch (FatalRequestException $e) {
                $lastException = $e;
                $attempt++;

                // Don't retry client errors (4xx)
                if ($this->isClientError($e)) {
                    throw $e;
                }

                // Don't retry if max attempts reached
                if ($attempt >= $this->maxRetries) {
                    break;
                }

                // Exponential backoff
                $delay = $this->retryDelay * pow(2, $attempt - 1);
                usleep($delay * 1000); // Convert to microseconds

                logger()->warning("Retrying shipment creation", [
                    'attempt' => $attempt,
                    'delay_ms' => $delay,
                ]);
            }
        }

        throw $lastException;
    }

    private function isClientError(FatalRequestException $e): bool
    {
        $status = $e->getResponse()->status();
        return $status >= 400 && $status < 500;
    }
}

// Usage
$client = new ResilientShipitClient($shipit);
$shipment = $client->createShipment($shipmentData);
```

## Graceful Degradation

Handle failures gracefully in production:

```php
class ShipmentCreator
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function createOrQueue(
        ShipmentRequestData $data,
        string $orderId
    ): array {
        try {
            $shipment = $this->shipit->shipments()->create($data);

            return [
                'status' => 'success',
                'tracking_number' => $shipment->trackingNumber,
                'tracking_urls' => $shipment->trackingUrls,
            ];
        } catch (FatalRequestException $e) {
            // Log the error
            logger()->error('Shipment creation failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'status_code' => $e->getResponse()->status(),
            ]);

            // Queue for retry
            dispatch(new CreateShipmentJob($data, $orderId));

            return [
                'status' => 'queued',
                'message' => 'Shipment will be created shortly',
            ];
        }
    }
}
```

## Input Validation

Validate data before sending to API:

```php
class ShipmentValidator
{
    public function validate(array $data): void
    {
        // Required fields
        $required = ['sender', 'receiver', 'parcels', 'serviceId'];
        foreach ($required as $field) {
            if (!isset($data[$field])) {
                throw new \InvalidArgumentException("Missing required field: {$field}");
            }
        }

        // Validate party data
        $this->validateParty($data['sender'], 'sender');
        $this->validateParty($data['receiver'], 'receiver');

        // Validate parcels
        $this->validateParcels($data['parcels']);

        // Validate service ID format
        if (!preg_match('/^[a-z]+\.\d+$/', $data['serviceId'])) {
            throw new \InvalidArgumentException("Invalid service ID format");
        }
    }

    private function validateParty(array $party, string $type): void
    {
        $required = ['name', 'email', 'phone', 'address', 'city', 'postcode', 'country'];

        foreach ($required as $field) {
            if (empty($party[$field])) {
                throw new \InvalidArgumentException(
                    "Missing {$type}.{$field}"
                );
            }
        }

        // Validate email
        if (!filter_var($party['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid {$type} email format");
        }

        // Validate country code
        if (!preg_match('/^[A-Z]{2}$/', $party['country'])) {
            throw new \InvalidArgumentException(
                "Invalid {$type} country code (must be 2-letter ISO code)"
            );
        }
    }

    private function validateParcels(array $parcels): void
    {
        if (empty($parcels)) {
            throw new \InvalidArgumentException("At least one parcel is required");
        }

        foreach ($parcels as $index => $parcel) {
            $required = ['length', 'width', 'height', 'weight'];

            foreach ($required as $field) {
                if (!isset($parcel[$field]) || $parcel[$field] <= 0) {
                    throw new \InvalidArgumentException(
                        "Invalid parcel[{$index}].{$field}"
                    );
                }
            }
        }
    }
}

// Usage
$validator = new ShipmentValidator();

try {
    $validator->validate($shipmentData);
    $shipment = $shipit->shipments()->create(
        ShipmentRequestData::from($shipmentData)
    );
} catch (\InvalidArgumentException $e) {
    // Handle validation error
    echo "Validation error: " . $e->getMessage();
}
```

## Logging

Comprehensive logging for debugging:

```php
class LoggingShipitClient
{
    public function __construct(
        private ShipitConnector $shipit,
        private LoggerInterface $logger
    ) {}

    public function createShipment(ShipmentRequestData $data): ShipmentResponseData
    {
        $this->logger->info('Creating shipment', [
            'sender' => $data->sender->toArray(),
            'receiver' => $data->receiver->toArray(),
            'service_id' => $data->serviceId,
        ]);

        try {
            $shipment = $this->shipit->shipments()->create($data);

            $this->logger->info('Shipment created successfully', [
                'tracking_number' => $shipment->trackingNumber,
                'service_id' => $data->serviceId,
            ]);

            return $shipment;
        } catch (FatalRequestException $e) {
            $this->logger->error('Shipment creation failed', [
                'status_code' => $e->getResponse()->status(),
                'error' => $e->getResponse()->json(),
                'request_data' => $data->toArray(),
            ]);

            throw $e;
        }
    }
}
```

## Error Response Structure

Understanding API error responses:

```php
try {
    $shipment = $shipit->shipments()->create($shipmentData);
} catch (FatalRequestException $e) {
    $response = $e->getResponse();
    $error = $response->json();

    // Typical error structure:
    // {
    //   "status": 0,
    //   "error": "Validation failed",
    //   "errors": {
    //     "receiver.postcode": ["The postal code field is required."],
    //     "parcels.0.weight": ["The weight must be greater than 0."]
    //   }
    // }

    $status = $error['status'] ?? null;
    $message = $error['error'] ?? 'Unknown error';
    $validationErrors = $error['errors'] ?? [];

    // Handle accordingly
}
```

## Next Steps

- [Testing](./13-testing.md)
- [Getting Started](./01-getting-started.md)
