<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\BookPickUpRequestData;
use Cline\Shipit\Data\ConsolidateShipmentRequestData;
use Cline\Shipit\Data\Responses\BookPickUpResponseData;
use Cline\Shipit\Data\Responses\ConsolidateShipmentResponseData;
use Cline\Shipit\Data\Responses\ShipmentResponseData;
use Cline\Shipit\Data\Responses\ValidateShipmentResponseData;
use Cline\Shipit\Data\ShipmentRequestData;
use Cline\Shipit\Requests\Shipments\BookCustomerReturnRequest;
use Cline\Shipit\Requests\Shipments\BookPickUpRequest;
use Cline\Shipit\Requests\Shipments\ConsolidateShipmentRequest;
use Cline\Shipit\Requests\Shipments\CreatePendingShipmentRequest;
use Cline\Shipit\Requests\Shipments\CreateShipmentRequest;
use Cline\Shipit\Requests\Shipments\ValidateShipmentRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Shipments resource for managing shipping operations.
 *
 * Provides comprehensive shipment management including creating immediate
 * or pending shipments, validating shipment data, consolidating multiple
 * shipments, booking customer returns, and scheduling carrier pickups.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShipmentsResource extends BaseResource
{
    /**
     * Create and immediately process a shipment with label generation.
     *
     * Processes the shipment, generates shipping labels, and returns tracking
     * information for immediate fulfillment.
     *
     * @param ShipmentRequestData $data Complete shipment details including sender, recipient, and package information
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShipmentResponseData The created shipment with tracking number and label URLs
     */
    public function create(ShipmentRequestData $data): ShipmentResponseData
    {
        /** @var ShipmentResponseData */
        return $this->connector
            ->send(
                new CreateShipmentRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Create a pending shipment without immediate label generation.
     *
     * Stores shipment information for later processing, useful for batch
     * operations or when labels will be generated at a future time.
     *
     * @param ShipmentRequestData $data Complete shipment details to be stored as pending
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShipmentResponseData The pending shipment record without labels
     */
    public function createPending(ShipmentRequestData $data): ShipmentResponseData
    {
        /** @var ShipmentResponseData */
        return $this->connector
            ->send(
                new CreatePendingShipmentRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Book a customer return shipment with return label generation.
     *
     * Creates a return shipment allowing customers to return items using
     * a prepaid shipping label provided by the merchant.
     *
     * @param ShipmentRequestData $data Return shipment details with reversed sender/recipient roles
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShipmentResponseData The return shipment with return label and tracking
     */
    public function bookReturn(ShipmentRequestData $data): ShipmentResponseData
    {
        /** @var ShipmentResponseData */
        return $this->connector
            ->send(
                new BookCustomerReturnRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Validate shipment data without creating a shipment.
     *
     * Checks shipment details for completeness and correctness, validates
     * addresses, and confirms service availability without processing charges.
     *
     * @param ShipmentRequestData $data Shipment data to validate
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ValidateShipmentResponseData Validation results with any errors or warnings
     */
    public function validate(ShipmentRequestData $data): ValidateShipmentResponseData
    {
        /** @var ValidateShipmentResponseData */
        return $this->connector
            ->send(
                new ValidateShipmentRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Consolidate multiple shipments into a single manifest.
     *
     * Combines multiple shipments for batch processing and carrier pickup,
     * generating a consolidated manifest for efficient logistics management.
     *
     * @param ConsolidateShipmentRequestData $data List of shipment IDs to consolidate
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ConsolidateShipmentResponseData Consolidated manifest details and documentation
     */
    public function consolidate(ConsolidateShipmentRequestData $data): ConsolidateShipmentResponseData
    {
        /** @var ConsolidateShipmentResponseData */
        return $this->connector
            ->send(
                new ConsolidateShipmentRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Schedule a carrier pickup for shipment collection.
     *
     * Books a pickup appointment with the carrier to collect packages from
     * the specified location, avoiding the need for drop-off.
     *
     * @param BookPickUpRequestData $data Pickup details including location, time window, and package count
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return BookPickUpResponseData Pickup confirmation with reference number and scheduled time
     */
    public function bookPickup(BookPickUpRequestData $data): BookPickUpResponseData
    {
        /** @var BookPickUpResponseData */
        return $this->connector
            ->send(
                new BookPickUpRequest($data),
            )
            ->dtoOrFail();
    }
}
