<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * Represents a pickup booking request for a shipment.
 *
 * Contains the necessary information to schedule a carrier pickup
 * at a specific location and time window.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BookPickUpRequestData extends Data
{
    /**
     * Create a new pickup booking request.
     *
     * @param string               $trackingNumber Shipment tracking number to schedule pickup for
     * @param string               $date           Pickup date in YYYY-MM-DD format
     * @param string               $readyTime      Earliest time goods will be ready for pickup in HH:MM format
     * @param string               $closeTime      Latest time pickup must be completed by in HH:MM format
     * @param null|Optional|string $instructions   Optional special instructions or notes for the pickup driver
     */
    public function __construct(
        public readonly string $trackingNumber,
        public readonly string $date,
        public readonly string $readyTime,
        public readonly string $closeTime,
        public readonly string|Optional|null $instructions,
    ) {}
}
