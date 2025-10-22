<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\ConsignmentTemplateResponseData;
use Cline\Shipit\Requests\ConsignmentTemplates\CreateConsignmentTemplateRequest;
use Cline\Shipit\Requests\ConsignmentTemplates\DeleteConsignmentTemplateRequest;
use Cline\Shipit\Requests\ConsignmentTemplates\GetConsignmentTemplateRequest;
use Cline\Shipit\Requests\ConsignmentTemplates\GetConsignmentTemplatesRequest;
use Cline\Shipit\Requests\ConsignmentTemplates\UpdateConsignmentTemplateRequest;
use Saloon\Http\BaseResource;

/**
 * Resource for managing consignment templates.
 *
 * Provides CRUD operations for reusable shipment templates that store predefined
 * shipping configurations including addresses, package details, service preferences,
 * and customs information. Templates streamline repetitive shipment creation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ConsignmentTemplatesResource extends BaseResource
{
    /**
     * Retrieve all consignment templates.
     *
     * @return ConsignmentTemplateResponseData Collection of all saved consignment templates
     */
    public function index(): ConsignmentTemplateResponseData
    {
        /** @var ConsignmentTemplateResponseData */
        return $this->connector
            ->send(
                new GetConsignmentTemplatesRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific consignment template by identifier.
     *
     * @param  string                          $id The consignment template identifier
     * @return ConsignmentTemplateResponseData Complete template configuration details
     */
    public function show(string $id): ConsignmentTemplateResponseData
    {
        /** @var ConsignmentTemplateResponseData */
        return $this->connector
            ->send(
                new GetConsignmentTemplateRequest($id),
            )
            ->dtoOrFail();
    }

    /**
     * Create a new consignment template.
     *
     * @param  array<string, mixed>            $data template configuration including sender/recipient
     *                                               addresses, package specifications, service preferences,
     *                                               customs declarations, and any shipping options to save
     *                                               as a reusable template for future shipments
     * @return ConsignmentTemplateResponseData The newly created consignment template
     */
    public function store(array $data): ConsignmentTemplateResponseData
    {
        /** @var ConsignmentTemplateResponseData */
        return $this->connector
            ->send(
                new CreateConsignmentTemplateRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Update an existing consignment template.
     *
     * @param  string                          $id   The consignment template identifier
     * @param  array<string, mixed>            $data updated template fields including addresses, package
     *                                               details, service preferences, or shipping options to
     *                                               modify in the existing template configuration
     * @return ConsignmentTemplateResponseData The updated consignment template
     */
    public function update(string $id, array $data): ConsignmentTemplateResponseData
    {
        /** @var ConsignmentTemplateResponseData */
        return $this->connector
            ->send(
                new UpdateConsignmentTemplateRequest($id, $data),
            )
            ->dtoOrFail();
    }

    /**
     * Delete a consignment template.
     *
     * @param  string                          $id The consignment template identifier
     * @return ConsignmentTemplateResponseData Confirmation of deleted template
     */
    public function destroy(string $id): ConsignmentTemplateResponseData
    {
        /** @var ConsignmentTemplateResponseData */
        return $this->connector
            ->send(
                new DeleteConsignmentTemplateRequest($id),
            )
            ->dtoOrFail();
    }
}
