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
 * Deletes an existing location from the authenticated account.
 *
 * Permanently removes a location and its associated data. This operation cannot
 * be undone. Note that locations referenced by existing shipments or consignments
 * may not be deletable until those references are removed or archived, depending
 * on the API's deletion policy.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteLocationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for deleting a location */
    protected Method $method = Method::DELETE;

    /**
     * Create a new request to delete a location.
     *
     * @param string $id Unique identifier of the location to delete. This is the
     *                   location's UUID or ID as returned when the location was
     *                   created or retrieved.
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for deleting the specific location.
     *
     * @return string The fully constructed endpoint path for the DELETE request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/locations/'.$this->id;
    }

    /**
     * Transform the API response into a structured LocationResponseData object.
     *
     * @param  Response             $response The HTTP response confirming the deletion operation in JSON format
     * @return LocationResponseData Typed data object containing the deleted location details or deletion confirmation
     */
    public function createDtoFromResponse(Response $response): LocationResponseData
    {
        return LocationResponseData::from($response->json());
    }
}
