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
 * Represents print template data in API responses.
 *
 * This data object encapsulates print template information including
 * carrier, service, layout preferences, and metadata. Used throughout
 * the Shipit SDK for managing user-specific print configurations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PrintTemplateResponseData extends Data
{
    /**
     * Create a new print template response data instance.
     *
     * @param int|string                    $id         Unique identifier for this print template within the system.
     *                                                  Can be numeric database ID or string UUID depending on
     *                                                  the backend implementation and data model design.
     * @param string                        $carrier    Carrier identifier that this template applies to
     * @param string                        $service    Service identifier within the carrier
     * @param string                        $layout     Print layout type (e.g., 'din_a4', 'thermal_165', 'zpl')
     * @param array<string, mixed>|Optional $metadata   Optional metadata for print template settings such as
     *                                                  enforce_to_size and remove_fedex_awb flags
     * @param Optional|string               $created_at Timestamp when this print template was created in the system,
     *                                                  typically in ISO 8601 format
     * @param Optional|string               $updated_at Timestamp of the most recent update to this print template,
     *                                                  used for change tracking and cache invalidation
     */
    public function __construct(
        public readonly string|int $id,
        public readonly string $carrier,
        public readonly string $service,
        public readonly string $layout,
        public readonly array|Optional $metadata,
        public readonly string|Optional $created_at,
        public readonly string|Optional $updated_at,
    ) {}
}
