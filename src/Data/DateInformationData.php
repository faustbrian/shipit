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
 * Represents shipment collection and delivery scheduling information.
 *
 * Defines the date and time windows for pickup and delivery operations,
 * allowing precise scheduling of logistics operations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DateInformationData extends Data
{
    /**
     * Create a new date information data instance.
     *
     * @param Optional|string $collectionDate         Scheduled collection date in YYYY-MM-DD format
     * @param Optional|string $collectionTimeEarliest Earliest collection time in HH:MM format, defines start of pickup window
     * @param Optional|string $collectionTimeLatest   Latest collection time in HH:MM format, defines end of pickup window
     * @param Optional|string $deliveryDate           Scheduled delivery date in YYYY-MM-DD format
     * @param Optional|string $deliveryTimeEarliest   Earliest delivery time in HH:MM format, defines start of delivery window
     * @param Optional|string $deliveryTimeLatest     Latest delivery time in HH:MM format, defines end of delivery window
     */
    public function __construct(
        public readonly string|Optional $collectionDate,
        public readonly string|Optional $collectionTimeEarliest,
        public readonly string|Optional $collectionTimeLatest,
        public readonly string|Optional $deliveryDate,
        public readonly string|Optional $deliveryTimeEarliest,
        public readonly string|Optional $deliveryTimeLatest,
    ) {}
}
