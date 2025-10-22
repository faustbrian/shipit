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

    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve an organization member.
     *
     * @param string $organizationId Unique identifier of the organization containing the member
     * @param string $memberId       Unique identifier of the member to retrieve
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly string $memberId,
    ) {}

    /**
     * Resolve the API endpoint for retrieving a specific organization member.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members/'.$this->memberId;
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response                       $response The raw HTTP response from the API
     * @return OrganizationMemberResponseData The deserialized member data
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }
}
