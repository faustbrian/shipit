<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data\Responses;

use Spatie\LaravelData\Data;

/**
 * Represents tracking link information for a shipment from the Shipit API.
 *
 * This data object provides the essential information needed to track a shipment,
 * including both the tracking URL for customer access and the tracking number for
 * reference and alternative tracking methods.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class TrackingLinkResponseData extends Data
{
    /**
     * Create a new tracking link response instance.
     *
     * @param string $trackingUrl    Complete URL to the carrier's tracking page for this shipment.
     *                               This URL can be shared with customers to allow them to track
     *                               their package status online. The URL is carrier-specific and
     *                               may include the tracking number as a URL parameter.
     * @param string $trackingNumber Unique tracking identifier assigned by the carrier. This number
     *                               can be used to track the shipment on carrier websites, mobile
     *                               apps, or through customer service channels. Essential for
     *                               customer communications and support queries.
     */
    public function __construct(
        public readonly string $trackingUrl,
        public readonly string $trackingNumber,
    ) {}
}
