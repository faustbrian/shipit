<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Shipments;

use Cline\Shipit\Data\ConsolidateShipmentRequestData;
use Cline\Shipit\Data\Responses\ConsolidateShipmentResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Consolidates multiple shipments into a single master shipment.
 *
 * This request combines multiple individual shipments into one consolidated
 * shipment, often used for batch shipping scenarios or when multiple packages
 * are being sent to the same destination. The API generates a master label
 * and tracking number for the consolidated shipment while maintaining references
 * to the individual shipments within the consolidation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ConsolidateShipmentRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses POST as each consolidation creates a new master shipment entity
     * combining multiple existing shipments into a single consolidated unit.
     */
    protected Method $method = Method::POST;

    /**
     * Create a new shipment consolidation request.
     *
     * @param ConsolidateShipmentRequestData $data Consolidation information including the list
     *                                             of shipment IDs to consolidate, master shipment
     *                                             details, and any special handling instructions.
     *                                             All shipments must share compatible destinations
     *                                             and carrier services for successful consolidation.
     */
    public function __construct(
        private readonly ConsolidateShipmentRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for shipment consolidation.
     *
     * @return string The endpoint path for consolidating shipments
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consolidate-shipment';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                        $response The HTTP response from the Shipit API
     * @return ConsolidateShipmentResponseData Structured consolidation data with master tracking
     */
    public function createDtoFromResponse(Response $response): ConsolidateShipmentResponseData
    {
        return ConsolidateShipmentResponseData::from($response->json());
    }

    /**
     * Provide the request body for shipment consolidation.
     *
     * @return array<string, mixed> Consolidation data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
