<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data;

use Spatie\LaravelData\Data;

/**
 * Represents a request to consolidate multiple shipments.
 *
 * Allows combining multiple separate shipments into a single consolidated
 * shipment for more efficient and cost-effective transportation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ConsolidateShipmentRequestData extends Data
{
    /**
     * Create a new shipment consolidation request.
     *
     * @param array<int, string> $trackingNumbers Array of tracking numbers for shipments to consolidate into one
     * @param string             $serviceId       Shipping service ID to use for the consolidated shipment
     */
    public function __construct(
        public readonly array $trackingNumbers,
        public readonly string $serviceId,
    ) {}
}
