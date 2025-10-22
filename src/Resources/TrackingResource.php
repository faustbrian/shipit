<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\TrackingEventResponseData;
use Cline\Shipit\Data\Responses\TrackingLinkResponseData;
use Cline\Shipit\Requests\Tracking\GetTrackingLinkRequest;
use Cline\Shipit\Requests\Tracking\QueryTrackingEventsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Tracking resource for shipment tracking and monitoring.
 *
 * Provides shipment tracking functionality including querying tracking
 * events for shipment status updates and generating customer-facing
 * tracking page links.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class TrackingResource extends BaseResource
{
    /**
     * Query tracking events for one or more shipments.
     *
     * Retrieves detailed tracking information including status updates,
     * location scans, and delivery confirmation for specified shipments.
     *
     * @param array<string, mixed> $data Query parameters including tracking numbers or shipment IDs
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return TrackingEventResponseData Collection of tracking events with timestamps and locations
     */
    public function query(array $data): TrackingEventResponseData
    {
        /** @var TrackingEventResponseData */
        return $this->connector
            ->send(
                new QueryTrackingEventsRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Generate a customer-facing tracking page link.
     *
     * Creates a shareable URL to a branded tracking page where customers
     * can view shipment progress and delivery status.
     *
     * @param string $trackingNumber The tracking number for the shipment
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return TrackingLinkResponseData Tracking page URL and related metadata
     */
    public function link(string $trackingNumber): TrackingLinkResponseData
    {
        /** @var TrackingLinkResponseData */
        return $this->connector
            ->send(
                new GetTrackingLinkRequest($trackingNumber),
            )
            ->dtoOrFail();
    }
}
