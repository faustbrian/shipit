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
 * Represents a carrier service point or pickup location.
 *
 * This data object encapsulates detailed information about carrier-operated
 * service points such as package pickup locations, parcel lockers, or drop-off
 * centers. Used in the Shipit SDK to help customers select convenient pickup
 * locations for their shipments with carriers like UPS, FedEx, or local carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ServicePointLocationData extends Data
{
    /**
     * Create a new service point location data instance.
     *
     * @param string                        $id           Unique identifier for this service point location provided
     *                                                    by the carrier. Used to reference this specific location
     *                                                    when creating shipments or booking pickup services.
     * @param string                        $name         service point name or location identifier, typically including
     *                                                    the business name or location type such as "FedEx Office" or
     *                                                    "UPS Access Point - Main Street Pharmacy"
     * @param string                        $address      street address of the service point including street number,
     *                                                    street name, and building identifiers for navigation and
     *                                                    customer directions
     * @param Optional|string               $city         city or municipality where the service point is located,
     *                                                    used for filtering nearby locations and display purposes
     * @param Optional|string               $postcode     postal code or ZIP code of the service point location,
     *                                                    used for distance calculations and location searches
     * @param Optional|string               $country      country where the service point operates, typically in
     *                                                    ISO 3166-1 alpha-2 format for international consistency
     * @param float|Optional                $latitude     Geographic latitude coordinate of the service point in
     *                                                    decimal degrees format. Used for map display, distance
     *                                                    calculations, and proximity-based sorting.
     * @param float|Optional                $longitude    Geographic longitude coordinate of the service point in
     *                                                    decimal degrees format. Used with latitude for accurate
     *                                                    location mapping and routing.
     * @param Optional|string               $serviceId    Carrier-specific service identifier or code indicating the
     *                                                    type of service point or pickup service available at this
     *                                                    location (e.g., locker, counter, store).
     * @param float|Optional                $price        Additional cost or fee for using this service point location,
     *                                                    if applicable. Some carriers charge extra for certain pickup
     *                                                    locations or convenience services.
     * @param array<string, mixed>|Optional $openingHours Operating hours schedule for this service point
     *                                                    containing day-of-week mappings to open and close
     *                                                    times. Used to inform customers when they can
     *                                                    access the location for package pickup.
     * @param Optional|string               $distance     Calculated distance from the user's reference location to
     *                                                    this service point, typically formatted as "2.3 km" or
     *                                                    "1.5 miles" for user-friendly display.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $address,
        public readonly string|Optional $city,
        public readonly string|Optional $postcode,
        public readonly string|Optional $country,
        public readonly float|Optional $latitude,
        public readonly float|Optional $longitude,
        public readonly string|Optional $serviceId,
        public readonly float|Optional $price,
        public readonly array|Optional $openingHours,
        public readonly string|Optional $distance,
    ) {}
}
