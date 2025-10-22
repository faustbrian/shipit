<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\ShippingMethods;

use Cline\Shipit\Data\Responses\QuickShippingMethodsResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves available shipping methods with quick filtering.
 *
 * This request queries available shipping methods based on shipment criteria
 * such as origin, destination, package dimensions, and weight. The "quick"
 * endpoint provides optimized performance for real-time rate shopping scenarios,
 * returning available carriers and services with pricing information to help
 * customers make shipping decisions during checkout workflows.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetQuickShippingMethodsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses POST to allow complex filtering criteria in the request body
     * while retrieving shipping method options and rate calculations.
     */
    protected Method $method = Method::POST;

    /**
     * Create a new quick shipping methods request.
     *
     * @param array<string, mixed> $data Shipment criteria for filtering shipping methods including
     *                                   origin address, destination address, package dimensions,
     *                                   weight, and optionally preferred carriers or service types.
     *                                   Used to determine available shipping options and calculate rates.
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for quick shipping methods.
     *
     * @return string The endpoint path for retrieving quick shipping method options
     */
    public function resolveEndpoint(): string
    {
        return '/v1/shipping-methods/quick';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                         $response The HTTP response from the Shipit API
     * @return QuickShippingMethodsResponseData Structured shipping methods with pricing
     */
    public function createDtoFromResponse(Response $response): QuickShippingMethodsResponseData
    {
        return QuickShippingMethodsResponseData::from($response->json());
    }

    /**
     * Provide the request body for shipping methods query.
     *
     * @return array<string, mixed> Shipment criteria for filtering available methods
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
