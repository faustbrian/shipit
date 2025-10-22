<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\OrganizationMembers;

use Cline\Shipit\Data\Responses\OrganizationMemberResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Removes a member from a specific organization.
 *
 * Permanently deletes a member's association with the organization, revoking
 * their access and permissions. This operation cannot be undone. The member's
 * user account remains intact, but they will no longer have access to this
 * organization's resources.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteOrganizationMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for removing an organization member */
    protected Method $method = Method::DELETE;

    /**
     * Create a new request to remove an organization member.
     *
     * @param string $organizationId Unique identifier of the organization containing the member.
     *                               This is the organization's UUID or ID as returned when the
     *                               organization was created or retrieved.
     * @param string $memberId       Unique identifier of the member to remove from the organization.
     *                               This is the member's UUID or ID as returned when the member
     *                               was created or listed within the organization.
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly string $memberId,
    ) {}

    /**
     * Resolve the API endpoint for removing the specific organization member.
     *
     * @return string The fully constructed endpoint path for the DELETE request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members/'.$this->memberId;
    }

    /**
     * Transform the API response into a structured OrganizationMemberResponseData object.
     *
     * @param  Response                       $response The HTTP response confirming the member deletion in JSON format
     * @return OrganizationMemberResponseData Typed data object containing the deleted member details or deletion confirmation
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }
}
