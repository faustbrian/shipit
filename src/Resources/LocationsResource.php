<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\LocationResponseData;
use Cline\Shipit\Requests\Locations\CreateLocationRequest;
use Cline\Shipit\Requests\Locations\DeleteLocationRequest;
use Cline\Shipit\Requests\Locations\GetLocationRequest;
use Cline\Shipit\Requests\Locations\GetLocationsRequest;
use Cline\Shipit\Requests\Locations\UpdateLocationRequest;
use Saloon\Http\BaseResource;

/**
 * Resource for managing shipping locations and warehouses.
 *
 * Provides CRUD operations for physical locations including warehouses, distribution
 * centers, retail stores, and fulfillment facilities. Locations define origin points
 * for shipments and inventory storage facilities.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class LocationsResource extends BaseResource
{
    /**
     * Retrieve all configured locations.
     *
     * @return LocationResponseData Collection of all shipping locations and facilities
     */
    public function index(): LocationResponseData
    {
        /** @var LocationResponseData */
        return $this->connector
            ->send(
                new GetLocationsRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific location by identifier.
     *
     * @param  string               $id The location identifier
     * @return LocationResponseData Complete location details including address and settings
     */
    public function show(string $id): LocationResponseData
    {
        /** @var LocationResponseData */
        return $this->connector
            ->send(
                new GetLocationRequest($id),
            )
            ->dtoOrFail();
    }

    /**
     * Create a new shipping location.
     *
     * @param  array<string, mixed> $data location configuration including name, complete address,
     *                                    contact information, operating hours, facility type,
     *                                    and any location-specific shipping preferences or
     *                                    restrictions for the new location
     * @return LocationResponseData The newly created location
     */
    public function store(array $data): LocationResponseData
    {
        /** @var LocationResponseData */
        return $this->connector
            ->send(
                new CreateLocationRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Update an existing shipping location.
     *
     * @param  string               $id   The location identifier
     * @param  array<string, mixed> $data updated location fields including address, contact
     *                                    information, operating hours, or facility settings to
     *                                    modify in the existing location configuration
     * @return LocationResponseData The updated location
     */
    public function update(string $id, array $data): LocationResponseData
    {
        /** @var LocationResponseData */
        return $this->connector
            ->send(
                new UpdateLocationRequest($id, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Delete a shipping location.
     *
     * @param  string               $id The location identifier
     * @return LocationResponseData Confirmation of deleted location
     */
    public function destroy(string $id): LocationResponseData
    {
        /** @var LocationResponseData */
        return $this->connector
            ->send(
                new DeleteLocationRequest($id),
            )
            ->dtoOrFail();
    }
}
