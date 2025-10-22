<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Shipments;

use Cline\Shipit\Data\Responses\ShipmentResponseData;
use Cline\Shipit\Data\ShipmentRequestData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates and books a shipment with immediate label generation.
 *
 * This is the primary shipment creation request that generates shipping labels
 * and books the shipment with the carrier in a single operation. The API validates
 * the shipment data, generates tracking numbers, creates printable labels, and
 * charges the merchant account for shipping costs. Uses PUT method to ensure
 * idempotent label creation and prevent duplicate shipments.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses PUT to ensure idempotent shipment creation and label generation,
     * preventing duplicate labels and charges on retry attempts.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new shipment booking request.
     *
     * @param ShipmentRequestData $data Complete shipment information including sender address,
     *                                  recipient address, package dimensions, weight, declared value,
     *                                  shipping service selection, and any special handling requirements.
     *                                  This data is validated and used to generate the shipping label.
     */
    public function __construct(
        private readonly ShipmentRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for shipment creation.
     *
     * @return string The endpoint path for creating and booking shipments
     */
    public function resolveEndpoint(): string
    {
        return '/v1/shipment';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response             $response The HTTP response from the Shipit API
     * @return ShipmentResponseData Structured shipment data including label URL and tracking number
     */
    public function createDtoFromResponse(Response $response): ShipmentResponseData
    {
        return ShipmentResponseData::from($response->json());
    }

    /**
     * Provide the request body for shipment creation.
     *
     * @return array<string, mixed> Shipment data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
