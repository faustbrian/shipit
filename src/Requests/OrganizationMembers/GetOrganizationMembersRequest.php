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
 * Retrieves all members belonging to a specific organization.
 *
 * Fetches a complete list of members within an organization, including
 * their roles, permissions, and membership status information.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetOrganizationMembersRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for listing organization members.
     */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve all organization members.
     *
     * @param string $organizationId Unique identifier of the organization whose members to retrieve.
     *                               This is the organization's UUID or ID as returned when the
     *                               organization was created or retrieved.
     */
    public function __construct(
        private readonly string $organizationId,
    ) {}

    /**
     * Resolve the API endpoint for retrieving organization members.
     *
     * @return string The fully constructed endpoint path for the collection GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members';
    }

    /**
     * Transform the API response into a structured OrganizationMemberResponseData object.
     *
     * @param  Response                       $response The HTTP response containing the collection of members in JSON format
     * @return OrganizationMemberResponseData Typed data object containing the array of organization members
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }
}
