<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * Represents tracking event data for a shipment from the Shipit API.
 *
 * This data object contains the tracking history and status information for a
 * specific shipment, including all transit events, current delivery status, and
 * estimated delivery timeframes.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class TrackingEventResponseData extends Data
{
    /**
     * Create a new tracking event response instance.
     *
     * @param string                           $trackingNumber    Unique tracking identifier for the shipment being tracked.
     *                                                            This is the carrier-assigned tracking number used across
     *                                                            all tracking systems and customer communications.
     * @param array<int, array<string, mixed>> $events            Chronological list of tracking events showing the shipment's
     *                                                            journey through the delivery network. Each event contains
     *                                                            timestamp, location, status description, and event type
     *                                                            information. Events are typically ordered from oldest to newest.
     * @param Optional|string                  $status            Current delivery status of the shipment (e.g., "in_transit",
     *                                                            "out_for_delivery", "delivered", "exception"). Provides
     *                                                            high-level status for UI display and business logic. May
     *                                                            be absent if carrier hasn't provided status information.
     * @param Optional|string                  $estimatedDelivery Estimated delivery date and time in ISO 8601 format or human-readable
     *                                                            format. Represents the carrier's current delivery estimate, which
     *                                                            may be updated as the shipment progresses. May be absent if carrier
     *                                                            doesn't provide delivery estimates or shipment is already delivered.
     */
    public function __construct(
        public readonly string $trackingNumber,
        public readonly array $events,
        public readonly string|Optional $status,
        public readonly string|Optional $estimatedDelivery,
    ) {}
}
