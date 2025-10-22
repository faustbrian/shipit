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
 * Creates a pending shipment without immediately generating labels.
 *
 * This request creates a shipment in pending state, allowing merchants to prepare
 * shipping information without committing to label generation. Useful for draft
 * shipments, quote comparisons, or when shipment details need review before
 * finalizing. The pending shipment can later be converted to a full shipment
 * or cancelled. Uses PUT method to ensure idempotent creation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreatePendingShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses PUT to ensure idempotent pending shipment creation, preventing
     * duplicate pending records from being created on retry attempts.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new pending shipment request.
     *
     * @param ShipmentRequestData $data Complete shipment information including sender address,
     *                                  recipient address, package dimensions, weight, and shipping
     *                                  service details. This data is stored in pending state without
     *                                  generating shipping labels or charging the merchant account.
     */
    public function __construct(
        private readonly ShipmentRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for pending shipment creation.
     *
     * @return string The endpoint path for creating pending shipments
     */
    public function resolveEndpoint(): string
    {
        return '/v1/pending-shipment';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response             $response The HTTP response from the Shipit API
     * @return ShipmentResponseData Structured shipment data with pending status
     */
    public function createDtoFromResponse(Response $response): ShipmentResponseData
    {
        return ShipmentResponseData::from($response->json());
    }

    /**
     * Provide the request body for pending shipment creation.
     *
     * @return array<string, mixed> Shipment data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
