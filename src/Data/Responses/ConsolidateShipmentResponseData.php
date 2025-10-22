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
 * Represents a shipment consolidation API response.
 *
 * This data object encapsulates the result of consolidating multiple
 * shipments into a single master shipment. Consolidation is used to
 * combine multiple packages going to the same destination or region
 * to optimize costs and simplify tracking for bulk shipping operations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ConsolidateShipmentResponseData extends Data
{
    /**
     * Create a new consolidate shipment response data instance.
     *
     * @param int                                       $status                     HTTP status code indicating the consolidation result. Success returns
     *                                                                              200 or 201, while failures return error codes such as 400 for invalid
     *                                                                              requests, 409 for conflicting shipments that cannot be consolidated,
     *                                                                              or 500 for processing errors.
     * @param Optional|string                           $consolidatedTrackingNumber Master tracking number assigned to the
     *                                                                              consolidated shipment. Used to track the
     *                                                                              entire group of packages as a single unit.
     *                                                                              Present only when consolidation succeeds.
     * @param array<int, array<string, mixed>>|Optional $shipments                  Collection of individual shipment identifiers or details that
     *                                                                              were successfully consolidated. Each entry typically includes
     *                                                                              the original tracking number and relationship to the master
     *                                                                              shipment. Structure varies by carrier and consolidation type.
     */
    public function __construct(
        public readonly int $status,
        public readonly string|Optional $consolidatedTrackingNumber,
        public readonly array|Optional $shipments,
    ) {}
}
