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
 * Represents dangerous goods (hazmat) shipment information.
 *
 * Contains all required ADR/UN classification and safety information
 * for transporting hazardous materials in compliance with international
 * dangerous goods regulations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DangerousGoodsData extends Data
{
    /**
     * Create a new dangerous goods data instance.
     *
     * @param string        $adrClass          ADR classification class (e.g., "3" for flammable liquids, "8" for corrosive substances)
     * @param string        $description       Proper shipping name and general description of the dangerous goods
     * @param string        $hazardCode        Kemler hazard identification code indicating specific danger properties
     * @param float         $netWeight         Net weight of dangerous goods in kilograms, excluding packaging
     * @param string        $packageCode       UN packaging code indicating authorized package type for the substance
     * @param string        $packageType       Description of package type used (e.g., "drum", "jerrycan", "box")
     * @param string        $technicalDescr    Technical name or chemical composition for proper substance identification
     * @param string        $unCode            UN number (four-digit identification code) for the dangerous substance
     * @param bool|Optional $limitedQuantities Indicates if shipment qualifies for limited quantity exemptions under ADR regulations
     */
    public function __construct(
        public readonly string $adrClass,
        public readonly string $description,
        public readonly string $hazardCode,
        public readonly float $netWeight,
        public readonly string $packageCode,
        public readonly string $packageType,
        public readonly string $technicalDescr,
        public readonly string $unCode,
        public readonly bool|Optional $limitedQuantities,
    ) {}
}
