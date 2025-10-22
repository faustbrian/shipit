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
 * Updates an existing organization member's information.
 *
 * Modifies member details such as role, permissions, or other attributes
 * for a specific member within an organization.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateOrganizationMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for updating organization member data.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new request to update an organization member.
     *
     * @param string               $organizationId Unique identifier of the organization containing the member.
     *                                             This is the organization's UUID or ID as returned when the
     *                                             organization was created or retrieved.
     * @param string               $memberId       Unique identifier of the member to update. This is the
     *                                             member's UUID or ID as returned when the member was created
     *                                             or listed within the organization.
     * @param array<string, mixed> $data           Member data to update. Should include fields that need to be
     *                                             modified such as role, permissions, status, or other member
     *                                             attributes. This is a full replacement operation (PUT semantics).
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly string $memberId,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating a specific organization member.
     *
     * @return string The fully constructed endpoint path for the PUT request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members/'.$this->memberId;
    }

    /**
     * Transform the API response into a structured OrganizationMemberResponseData object.
     *
     * @param  Response                       $response The HTTP response containing the updated member data in JSON format
     * @return OrganizationMemberResponseData Typed data object containing the updated member details
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the updated member data.
     *
     * @return array<string, mixed> The member data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
