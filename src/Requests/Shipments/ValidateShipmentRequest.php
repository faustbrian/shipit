<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Shipments;

use Cline\Shipit\Data\Responses\ValidateShipmentResponseData;
use Cline\Shipit\Data\ShipmentRequestData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Validates shipment data without creating labels or booking.
 *
 * This request performs comprehensive validation of shipment information including
 * address verification, package specifications, service availability, and pricing
 * estimates without committing to label creation. Useful for pre-submission validation,
 * catching errors early, and providing accurate shipping quotes to customers before
 * finalizing the shipment. Uses PUT method for consistency with shipment operations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ValidateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses PUT for consistency with shipment operation endpoints, though
     * validation is non-mutating and could use POST or GET semantics.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new shipment validation request.
     *
     * @param ShipmentRequestData $data Shipment information to validate including sender address,
     *                                  recipient address, package dimensions, weight, and shipping
     *                                  service selection. The API validates all fields without
     *                                  generating labels or charging the merchant account.
     */
    public function __construct(
        private readonly ShipmentRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for shipment validation.
     *
     * @return string The endpoint path for validating shipment data
     */
    public function resolveEndpoint(): string
    {
        return '/v1/validate-shipment';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                     $response The HTTP response from the Shipit API
     * @return ValidateShipmentResponseData Structured validation results with errors or confirmation
     */
    public function createDtoFromResponse(Response $response): ValidateShipmentResponseData
    {
        return ValidateShipmentResponseData::from($response->json());
    }

    /**
     * Provide the request body for shipment validation.
     *
     * @return array<string, mixed> Shipment data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
