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
 * Creates a new member within a specific organization.
 *
 * Organization members are users associated with an organization account, each
 * with specific roles and permissions. This request adds a new member to the
 * organization, typically by email invitation, and assigns their initial role
 * and access level.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateOrganizationMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for creating a new organization member */
    protected Method $method = Method::POST;

    /**
     * Create a new request to add an organization member.
     *
     * @param string               $organizationId Unique identifier of the organization to add the member to.
     *                                             This is the organization's UUID or ID as returned when the
     *                                             organization was created or retrieved.
     * @param array<string, mixed> $data           Member data including user identification (typically email),
     *                                             role assignment, and permission settings. Required fields
     *                                             usually include email address and role, and may include
     *                                             custom permissions or team assignments.
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating a new organization member.
     *
     * @return string The fully constructed endpoint path for the POST request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members';
    }

    /**
     * Transform the API response into a structured OrganizationMemberResponseData object.
     *
     * @param  Response                       $response The HTTP response containing the newly created member data in JSON format
     * @return OrganizationMemberResponseData Typed data object containing the created member details including assigned ID
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the new member data.
     *
     * @return array<string, mixed> The member data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
