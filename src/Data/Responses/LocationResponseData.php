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
 * Represents a physical location or address in the shipping system.
 *
 * This data object encapsulates complete address information for shipping
 * locations such as warehouses, retail stores, or pickup points. Used throughout
 * the Shipit SDK for managing origin and destination addresses in shipment operations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class LocationResponseData extends Data
{
    /**
     * Create a new location response data instance.
     *
     * @param int|string      $id         Unique identifier for this location within the system.
     *                                    Can be numeric database ID or string UUID depending on
     *                                    the backend implementation and storage strategy.
     * @param string          $name       descriptive name or label for this location used for
     *                                    identification purposes in the user interface, such as
     *                                    "Main Warehouse" or "Downtown Store #5"
     * @param string          $address    Primary street address line containing street number,
     *                                    street name, and building identifiers. This is the main
     *                                    address component used for shipment routing and delivery.
     * @param string          $city       city or municipality name where this location resides,
     *                                    used for address validation and carrier routing decisions
     * @param string          $postcode   postal code or ZIP code for this location, required for
     *                                    accurate shipping calculations and carrier service availability
     * @param string          $country    country code or name identifying the country where this
     *                                    location is situated, typically in ISO 3166-1 alpha-2 format
     * @param Optional|string $address2   optional secondary address line for apartment numbers,
     *                                    suite numbers, floor details, or building names that provide
     *                                    additional delivery location context
     * @param Optional|string $state      State, province, or administrative region within the country.
     *                                    May be required for certain countries like US, Canada, or
     *                                    Australia for proper address validation.
     * @param bool|Optional   $is_default indicates whether this location is set as the default
     *                                    shipping origin or destination for the user's account,
     *                                    used to pre-populate forms and streamline workflows
     * @param Optional|string $created_at timestamp when this location record was first created
     *                                    in the system, typically in ISO 8601 format for tracking
     *                                    and auditing purposes
     * @param Optional|string $updated_at timestamp of the most recent update to this location record,
     *                                    used for change tracking and synchronization between systems
     */
    public function __construct(
        public readonly string|int $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string $city,
        public readonly string $postcode,
        public readonly string $country,
        public readonly string|Optional $address2,
        public readonly string|Optional $state,
        public readonly bool|Optional $is_default,
        public readonly string|Optional $created_at,
        public readonly string|Optional $updated_at,
    ) {}
}
