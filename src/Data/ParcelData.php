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
 * Represents a physical parcel or package in a shipment.
 *
 * Defines the physical characteristics and handling requirements
 * for individual packages, including dimensions, weight, and any
 * dangerous goods information.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ParcelData extends Data
{
    /**
     * Create a new parcel data instance.
     *
     * @param int|Optional                     $copies         Number of identical copies of this parcel type in the shipment
     * @param Optional|string                  $type           Package type identifier or code (e.g., "box", "pallet", "envelope")
     * @param float                            $length         Length of the parcel in centimeters
     * @param float                            $width          Width of the parcel in centimeters
     * @param float                            $height         Height of the parcel in centimeters
     * @param float                            $weight         Total weight of the parcel in kilograms including packaging
     * @param null|DangerousGoodsData|Optional $dangerousGoods Optional dangerous goods information if parcel contains hazardous materials
     */
    public function __construct(
        public readonly int|Optional $copies,
        public readonly string|Optional $type,
        public readonly float $length,
        public readonly float $width,
        public readonly float $height,
        public readonly float $weight,
        public readonly DangerousGoodsData|Optional|null $dangerousGoods,
    ) {}
}
