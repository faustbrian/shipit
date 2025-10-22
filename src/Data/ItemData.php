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
 * Represents a line item in a shipment for customs declaration.
 *
 * Contains detailed information about individual goods including quantities,
 * values, and customs classification codes required for international shipping
 * and customs clearance processing.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ItemData extends Data
{
    /**
     * Create a new shipment item data instance.
     *
     * @param int    $quantity        Number of units being shipped for this line item
     * @param string $quantityUnit    Unit of measurement for quantity (e.g., "pcs", "kg", "boxes")
     * @param string $description     Detailed description of the goods for customs declaration purposes
     * @param float  $unitWeight      Weight per individual unit in kilograms
     * @param float  $unitValue       Declared value per individual unit in shipment currency
     * @param string $hsTariffCode    Harmonized System (HS) tariff code for customs classification and duty calculation
     * @param string $countryOfOrigin ISO 3166-1 alpha-2 country code where goods were manufactured or produced
     */
    public function __construct(
        public readonly int $quantity,
        public readonly string $quantityUnit,
        public readonly string $description,
        public readonly float $unitWeight,
        public readonly float $unitValue,
        public readonly string $hsTariffCode,
        public readonly string $countryOfOrigin,
    ) {}
}
