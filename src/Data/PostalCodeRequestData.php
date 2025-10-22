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
 * Represents a postal code validation or lookup request.
 *
 * This data object encapsulates the necessary information for validating
 * postal codes or performing postal code-based lookups within a specific
 * country. Either postal code or city may be provided depending on the
 * lookup direction (e.g., postal code to city or city to postal code).
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PostalCodeRequestData extends Data
{
    /**
     * Create a new postal code request data instance.
     *
     * @param string          $country    ISO 3166-1 alpha-2 country code (e.g., "US", "GB", "DE")
     *                                    identifying the country for postal code validation context.
     * @param Optional|string $postalCode Postal or ZIP code to validate or lookup. Format varies
     *                                    by country (e.g., "12345" for US, "SW1A 1AA" for UK).
     *                                    Optional when performing city-to-postal-code lookups.
     * @param Optional|string $city       City name for postal code lookup or validation. Optional when
     *                                    performing postal-code-to-city lookups or when city validation
     *                                    is not required for the specific use case.
     */
    public function __construct(
        public readonly string $country,
        public readonly string|Optional $postalCode,
        public readonly string|Optional $city,
    ) {}
}
