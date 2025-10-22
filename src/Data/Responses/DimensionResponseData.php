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
 * Represents dimension data in API responses.
 *
 * This data object encapsulates dimension information including
 * type, measurements, service associations, and units of measurement.
 * Used throughout the Shipit SDK for managing predefined package dimensions.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DimensionResponseData extends Data
{
    /**
     * Create a new dimension response data instance.
     *
     * @param int|string      $id             Unique identifier for this dimension within the system.
     *                                        Can be numeric database ID or string UUID depending on
     *                                        the backend implementation and data model design.
     * @param string          $type           Dimension type (e.g., 'predefined', 'custom')
     * @param Optional|string $name           Optional name for this dimension preset
     * @param Optional|string $service        Optional service identifier this dimension applies to
     * @param Optional|string $parcel_type    Optional parcel type classification
     * @param float           $length         Length measurement value
     * @param float           $width          Width measurement value
     * @param float           $height         Height measurement value
     * @param float           $weight         Weight measurement value
     * @param Optional|string $unit_of_length Unit of measurement for length dimensions (e.g., 'cm', 'in')
     * @param Optional|string $unit_of_mass   Unit of measurement for weight (e.g., 'kg', 'lb')
     * @param Optional|string $created_at     Timestamp when this dimension was created in the system,
     *                                        typically in ISO 8601 format
     * @param Optional|string $updated_at     Timestamp of the most recent update to this dimension,
     *                                        used for change tracking and cache invalidation
     */
    public function __construct(
        public readonly string|int $id,
        public readonly string $type,
        public readonly string|Optional $name,
        public readonly string|Optional $service,
        public readonly string|Optional $parcel_type,
        public readonly float $length,
        public readonly float $width,
        public readonly float $height,
        public readonly float $weight,
        public readonly string|Optional $unit_of_length,
        public readonly string|Optional $unit_of_mass,
        public readonly string|Optional $created_at,
        public readonly string|Optional $updated_at,
    ) {}
}
