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
 * Retrieves a single location by its unique identifier.
 *
 * Locations represent physical addresses used for shipping operations. This request
 * fetches complete location details including address components, contact information,
 * operational settings, and any associated metadata for use in shipment creation or
 * location management.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetLocationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for retrieving location data */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve a location.
     *
     * @param string $id Unique identifier of the location to retrieve. This is the
     *                   location's UUID or ID as returned when the location was
     *                   created or listed.
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for retrieving the specific location.
     *
     * @return string The fully constructed endpoint path for the GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/locations/'.$this->id;
    }

    /**
     * Transform the API response into a structured LocationResponseData object.
     *
     * @param  Response             $response The HTTP response containing the location data in JSON format
     * @return LocationResponseData Typed data object containing the location details
     */
    public function createDtoFromResponse(Response $response): LocationResponseData
    {
        return LocationResponseData::from($response->json());
    }
}
