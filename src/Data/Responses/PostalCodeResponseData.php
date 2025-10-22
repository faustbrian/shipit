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
 * Represents postal code lookup results.
 *
 * This data object encapsulates geographic information associated with a postal
 * code or ZIP code. Used for address validation, autocomplete features, and
 * location-based service availability checks in the Shipit SDK.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PostalCodeResponseData extends Data
{
    /**
     * Create a new postal code response data instance.
     *
     * @param string          $postalCode Postal code or ZIP code that was queried, returned in
     *                                    standardized format for the country. Used as the primary
     *                                    identifier for this geographic location.
     * @param string          $city       City or municipality name associated with this postal code.
     *                                    Used to populate address forms and validate shipping destinations
     *                                    when users enter postal codes.
     * @param string          $country    country code or name where this postal code is located,
     *                                    typically in ISO 3166-1 alpha-2 format for international
     *                                    address standardization
     * @param Optional|string $state      State, province, or administrative region within the country.
     *                                    Important for countries with state-based addressing systems
     *                                    like US, Canada, Australia, and Brazil.
     * @param Optional|string $region     geographic region or district within the state or country,
     *                                    providing additional location context for areas with complex
     *                                    administrative divisions or regional shipping variations
     */
    public function __construct(
        public readonly string $postalCode,
        public readonly string $city,
        public readonly string $country,
        public readonly string|Optional $state,
        public readonly string|Optional $region,
    ) {}
}
