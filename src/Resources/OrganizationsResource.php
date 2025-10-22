<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\OrganizationResponseData;
use Cline\Shipit\Requests\Organizations\CreateOrganizationRequest;
use Cline\Shipit\Requests\Organizations\DeleteOrganizationRequest;
use Cline\Shipit\Requests\Organizations\GetOrganizationRequest;
use Cline\Shipit\Requests\Organizations\GetOrganizationsRequest;
use Cline\Shipit\Requests\Organizations\UpdateOrganizationRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Organizations resource for managing organization entities.
 *
 * Provides comprehensive CRUD operations for organizations, including
 * creating new organizations, retrieving organization details, updating
 * organization information, and removing organizations from the system.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class OrganizationsResource extends BaseResource
{
    /**
     * Retrieve all organizations accessible to the authenticated user.
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationResponseData The collection of organizations
     */
    public function index(): OrganizationResponseData
    {
        /** @var OrganizationResponseData */
        return $this->connector
            ->send(
                new GetOrganizationsRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific organization by ID.
     *
     * @param string $id The unique identifier of the organization
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationResponseData The requested organization
     */
    public function show(string $id): OrganizationResponseData
    {
        /** @var OrganizationResponseData */
        return $this->connector
            ->send(
                new GetOrganizationRequest($id),
            )
            ->dtoOrFail();
    }

    /**
     * Create a new organization.
     *
     * @param array<string, mixed> $data Organization data including name, settings, and configuration
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationResponseData The newly created organization
     */
    public function store(array $data): OrganizationResponseData
    {
        /** @var OrganizationResponseData */
        return $this->connector
            ->send(
                new CreateOrganizationRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Update an existing organization's information.
     *
     * @param string               $id   The unique identifier of the organization to update
     * @param array<string, mixed> $data Updated organization data
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationResponseData The updated organization
     */
    public function update(string $id, array $data): OrganizationResponseData
    {
        /** @var OrganizationResponseData */
        return $this->connector
            ->send(
                new UpdateOrganizationRequest($id, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Delete an organization from the system.
     *
     * @param string $id The unique identifier of the organization to delete
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return OrganizationResponseData Confirmation of the deletion
     */
    public function destroy(string $id): OrganizationResponseData
    {
        /** @var OrganizationResponseData */
        return $this->connector
            ->send(
                new DeleteOrganizationRequest($id),
            )
            ->dtoOrFail();
    }
}
