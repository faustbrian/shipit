<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\OrganizationMemberResponseData;
use Cline\Shipit\Requests\OrganizationMembers\CreateOrganizationMemberRequest;
use Cline\Shipit\Requests\OrganizationMembers\DeleteOrganizationMemberRequest;
use Cline\Shipit\Requests\OrganizationMembers\GetOrganizationMemberRequest;
use Cline\Shipit\Requests\OrganizationMembers\GetOrganizationMembersRequest;
use Cline\Shipit\Requests\OrganizationMembers\UpdateOrganizationMemberRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Organization members resource for managing organization membership.
 *
 * Provides CRUD operations for managing members within an organization,
 * including adding users to organizations, updating member roles and
 * permissions, and removing members from the organization.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class OrganizationMembersResource extends BaseResource
{
    /**
     * Retrieve all members for a specific organization.
     *
     * @param string $organizationId The unique identifier of the organization
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationMemberResponseData The collection of organization members
     */
    public function index(string $organizationId): OrganizationMemberResponseData
    {
        /** @var OrganizationMemberResponseData */
        return $this->connector
            ->send(
                new GetOrganizationMembersRequest($organizationId),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific organization member by ID.
     *
     * @param string $organizationId The unique identifier of the organization
     * @param string $memberId       The unique identifier of the member
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationMemberResponseData The requested organization member
     */
    public function show(string $organizationId, string $memberId): OrganizationMemberResponseData
    {
        /** @var OrganizationMemberResponseData */
        return $this->connector
            ->send(
                new GetOrganizationMemberRequest($organizationId, $memberId),
            )
            ->dtoOrFail();
    }

    /**
     * Add a new member to an organization.
     *
     * @param string               $organizationId The unique identifier of the organization
     * @param array<string, mixed> $data           Member data including user ID, role, and permissions
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationMemberResponseData The newly created organization member
     */
    public function store(string $organizationId, array $data): OrganizationMemberResponseData
    {
        /** @var OrganizationMemberResponseData */
        return $this->connector
            ->send(
                new CreateOrganizationMemberRequest($organizationId, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Update an existing organization member's information.
     *
     * @param string               $organizationId The unique identifier of the organization
     * @param string               $memberId       The unique identifier of the member to update
     * @param array<string, mixed> $data           Updated member data such as role or permissions
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationMemberResponseData The updated organization member
     */
    public function update(string $organizationId, string $memberId, array $data): OrganizationMemberResponseData
    {
        /** @var OrganizationMemberResponseData */
        return $this->connector
            ->send(
                new UpdateOrganizationMemberRequest($organizationId, $memberId, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Remove a member from an organization.
     *
     * @param string $organizationId The unique identifier of the organization
     * @param string $memberId       The unique identifier of the member to remove
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationMemberResponseData Confirmation of the deletion
     */
    public function destroy(string $organizationId, string $memberId): OrganizationMemberResponseData
    {
        /** @var OrganizationMemberResponseData */
        return $this->connector
            ->send(
                new DeleteOrganizationMemberRequest($organizationId, $memberId),
            )
            ->dtoOrFail();
    }
}
