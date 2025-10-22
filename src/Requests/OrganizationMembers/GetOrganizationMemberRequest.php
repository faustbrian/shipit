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
 * Retrieves a specific organization member by their unique identifier.
 *
 * Fetches detailed information about an individual member within an organization,
 * including their role, permissions, and membership status.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetOrganizationMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for retrieving organization member data.
     */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve an organization member.
     *
     * @param string $organizationId Unique identifier of the organization containing the member.
     *                               This is the organization's UUID or ID as returned when the
     *                               organization was created or retrieved.
     * @param string $memberId       Unique identifier of the member to retrieve. This is the
     *                               member's UUID or ID as returned when the member was created
     *                               or listed within the organization.
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly string $memberId,
    ) {}

    /**
     * Resolve the API endpoint for retrieving a specific organization member.
     *
     * @return string The fully constructed endpoint path for the GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members/'.$this->memberId;
    }

    /**
     * Transform the API response into a structured OrganizationMemberResponseData object.
     *
     * @param  Response                       $response The HTTP response containing the member data in JSON format
     * @return OrganizationMemberResponseData Typed data object containing the member details
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }
}
