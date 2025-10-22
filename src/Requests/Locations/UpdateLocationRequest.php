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
 * Updates an existing location with new address and configuration data.
 *
 * Allows modification of location details including address components, contact
 * information, and operational settings. The entire location is replaced with
 * the provided data (PUT semantics), so include all fields that should be retained.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateLocationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for updating location data.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new request to update a location.
     *
     * @param string               $id   Unique identifier of the location to update. This is the
     *                                   location's UUID or ID as returned when the location was
     *                                   created or retrieved.
     * @param array<string, mixed> $data Location data to update. Should include all fields that need
     *                                   to be retained as this is a full replacement operation. Typical
     *                                   fields include name, address components (street, city, state,
     *                                   postal code, country), contact details, and operational settings.
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating the specific location.
     *
     * @return string The fully constructed endpoint path for the PUT request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/locations/'.$this->id;
    }

    /**
     * Transform the API response into a structured LocationResponseData object.
     *
     * @param  Response             $response The HTTP response containing the updated location data in JSON format
     * @return LocationResponseData Typed data object containing the updated location details
     */
    public function createDtoFromResponse(Response $response): LocationResponseData
    {
        return LocationResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the updated location data.
     *
     * @return array<string, mixed> The location data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
