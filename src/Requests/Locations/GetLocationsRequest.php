<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Locations;

use Cline\Shipit\Data\Responses\LocationResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves a collection of all locations for the authenticated account.
 *
 * Locations represent physical addresses used for shipping operations such as
 * warehouses, retail stores, or fulfillment centers. This request fetches all
 * available locations with their complete details including addresses, contact
 * information, and operational settings.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetLocationsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for listing locations.
     */
    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for retrieving all locations.
     *
     * @return string The endpoint path for the collection GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/locations';
    }

    /**
     * Transform the API response into a structured LocationResponseData object.
     *
     * @param  Response             $response The HTTP response containing the collection of locations in JSON format
     * @return LocationResponseData Typed data object containing the array of locations
     */
    public function createDtoFromResponse(Response $response): LocationResponseData
    {
        return LocationResponseData::from($response->json());
    }
}
