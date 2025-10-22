<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\ShippingMethods;

use Cline\Shipit\Data\Responses\ShippingMethodsResponseData;
use Cline\Shipit\Data\ShippingMethodsRequestData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves available shipping methods based on shipment criteria.
 *
 * Queries the API to retrieve all available shipping methods that match the provided
 * shipment parameters such as origin, destination, weight, and dimensions. Returns
 * a collection of shipping options with pricing and estimated delivery times.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetShippingMethodsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses POST to allow shipment criteria and filtering parameters in the
     * request body while retrieving applicable shipping methods and rates.
     */
    protected Method $method = Method::POST;

    /**
     * Create a new shipping methods request instance.
     *
     * @param ShippingMethodsRequestData $data Shipment criteria including origin address,
     *                                         destination address, package dimensions, weight,
     *                                         and any additional filters for carrier or service
     *                                         level preferences. Used to determine applicable
     *                                         shipping options and calculate accurate pricing.
     */
    public function __construct(
        private readonly ShippingMethodsRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for retrieving shipping methods.
     *
     * @return string The shipping methods endpoint path
     */
    public function resolveEndpoint(): string
    {
        return '/v1/shipping-methods';
    }

    /**
     * Transform the API response into a typed data object.
     *
     * @param  Response                    $response The HTTP response from the shipping methods endpoint
     * @return ShippingMethodsResponseData Collection of available shipping methods with pricing
     */
    public function createDtoFromResponse(Response $response): ShippingMethodsResponseData
    {
        return ShippingMethodsResponseData::from($response->json());
    }

    /**
     * Build the request body containing shipment criteria.
     *
     * @return array<string, mixed> Shipment parameters for shipping method calculation
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
