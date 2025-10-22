<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\ShippingMethods;

use Cline\Shipit\Data\Responses\ShippingMethodDetailsResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves detailed information about a specific shipping method.
 *
 * This request fetches comprehensive details for a particular shipping service
 * including carrier information, service features, delivery timeframes, size
 * and weight restrictions, special handling capabilities, and pricing structure.
 * Used when displaying detailed shipping service information to users or making
 * informed shipping decisions based on service capabilities.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetShippingMethodDetailsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     *
     * Uses GET to retrieve read-only shipping method details without
     * requiring request body parameters.
     */
    protected Method $method = Method::GET;

    /**
     * Create a new shipping method details request.
     *
     * @param string $serviceId Unique identifier for the shipping service or method.
     *                          This ID is typically obtained from shipping method list
     *                          endpoints or rate shopping responses and identifies a specific
     *                          carrier service combination for detailed information retrieval.
     */
    public function __construct(
        private readonly string $serviceId,
    ) {}

    /**
     * Resolve the API endpoint for shipping method details.
     *
     * @return string The endpoint path including the service ID parameter
     */
    public function resolveEndpoint(): string
    {
        return '/v1/shipping-method-details/'.$this->serviceId;
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                          $response The HTTP response from the Shipit API
     * @return ShippingMethodDetailsResponseData Structured shipping method details
     */
    public function createDtoFromResponse(Response $response): ShippingMethodDetailsResponseData
    {
        return ShippingMethodDetailsResponseData::from($response->json());
    }
}
