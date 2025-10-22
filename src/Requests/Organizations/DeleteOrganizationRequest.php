<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Organizations;

use Cline\Shipit\Data\Responses\OrganizationResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Deletes an organization from the system.
 *
 * Permanently removes an organization and its associated data. This operation
 * is typically irreversible and should be used with caution.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteOrganizationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for deleting an organization.
     */
    protected Method $method = Method::DELETE;

    /**
     * Create a new request to delete an organization.
     *
     * @param string $id Unique identifier of the organization to delete. This is the
     *                   organization's UUID or ID as returned when the organization was
     *                   created or retrieved. Deletion is permanent and irreversible.
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for deleting a specific organization.
     *
     * @return string The fully constructed endpoint path for the DELETE request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->id;
    }

    /**
     * Transform the API response into a structured OrganizationResponseData object.
     *
     * @param  Response                 $response The HTTP response confirming the organization deletion in JSON format
     * @return OrganizationResponseData Typed data object containing the deleted organization details or deletion confirmation
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }
}
