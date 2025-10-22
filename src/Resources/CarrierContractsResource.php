<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\CarrierContractResponseData;
use Cline\Shipit\Requests\CarrierContracts\CreateCarrierContractRequest;
use Cline\Shipit\Requests\CarrierContracts\DeleteCarrierContractRequest;
use Cline\Shipit\Requests\CarrierContracts\GetCarrierContractRequest;
use Cline\Shipit\Requests\CarrierContracts\GetCarrierContractsRequest;
use Cline\Shipit\Requests\CarrierContracts\UpdateCarrierContractRequest;
use Saloon\Http\BaseResource;

/**
 * Resource for managing carrier contract configurations.
 *
 * Provides CRUD operations for carrier contracts including negotiated rates, service
 * agreements, billing terms, and carrier-specific configurations. Carrier contracts
 * define the relationship and pricing arrangements with shipping carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CarrierContractsResource extends BaseResource
{
    /**
     * Retrieve all carrier contracts.
     *
     * @return CarrierContractResponseData Collection of all configured carrier contracts
     */
    public function index(): CarrierContractResponseData
    {
        /** @var CarrierContractResponseData */
        return $this->connector
            ->send(
                new GetCarrierContractsRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific carrier contract by identifier.
     *
     * @param  string                      $id The carrier contract identifier
     * @return CarrierContractResponseData Complete carrier contract details including rates
     */
    public function show(string $id): CarrierContractResponseData
    {
        /** @var CarrierContractResponseData */
        return $this->connector
            ->send(
                new GetCarrierContractRequest($id),
            )
            ->dtoOrFail();
    }

    /**
     * Create a new carrier contract.
     *
     * @param  array<string, mixed>        $data contract configuration including carrier details,
     *                                           negotiated rates, service agreements, billing terms,
     *                                           and operational parameters for the new carrier contract
     * @return CarrierContractResponseData The newly created carrier contract
     */
    public function store(array $data): CarrierContractResponseData
    {
        /** @var CarrierContractResponseData */
        return $this->connector
            ->send(
                new CreateCarrierContractRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Update an existing carrier contract.
     *
     * @param  string                      $id   The carrier contract identifier
     * @param  array<string, mixed>        $data updated contract fields including rates, terms,
     *                                           service levels, or operational parameters to modify
     *                                           in the existing carrier contract configuration
     * @return CarrierContractResponseData The updated carrier contract
     */
    public function update(string $id, array $data): CarrierContractResponseData
    {
        /** @var CarrierContractResponseData */
        return $this->connector
            ->send(
                new UpdateCarrierContractRequest($id, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Delete a carrier contract.
     *
     * @param  string                      $id The carrier contract identifier
     * @return CarrierContractResponseData Confirmation of deleted carrier contract
     */
    public function destroy(string $id): CarrierContractResponseData
    {
        /** @var CarrierContractResponseData */
        return $this->connector
            ->send(
                new DeleteCarrierContractRequest($id),
            )
            ->dtoOrFail();
    }
}
