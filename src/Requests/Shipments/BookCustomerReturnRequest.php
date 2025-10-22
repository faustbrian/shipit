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
 * Books a customer return shipment through the Shipit API.
 *
 * This request creates and books a return shipment label, allowing customers
 * to return items back to the merchant. The API generates a return label with
 * tracking information and necessary shipping documentation for the return process.
 * Uses PUT method to ensure idempotent label creation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BookCustomerReturnRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for this request */
    protected Method $method = Method::PUT;

    /**
     * Create a new customer return booking request.
     *
     * @param ShipmentRequestData $data Complete shipment information including sender address,
     *                                  recipient address, package dimensions, weight, and shipping
     *                                  service details. Used to generate the return shipping label
     *                                  and associated tracking information.
     */
    public function __construct(
        private readonly ShipmentRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for customer return booking.
     *
     * @return string The endpoint path for booking customer return shipments
     */
    public function resolveEndpoint(): string
    {
        return '/v1/customer-return';
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
     * Provide the request body for customer return booking.
     *
     * @return array<string, mixed> Shipment data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
