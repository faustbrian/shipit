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
 * Represents a shipping agent or service point location.
 *
 * This data object encapsulates information about a physical location
 * where customers can drop off or pick up shipments. Agents include
 * retail locations, lockers, post offices, and partner service points
 * that facilitate package handling for various carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class AgentResponseData extends Data
{
    /**
     * Create a new agent response data instance.
     *
     * @param string                        $id                   Unique identifier for the agent location within the carrier's network.
     *                                                            Used for referencing the agent in booking and tracking operations.
     * @param string                        $name                 Display name of the agent location, typically the business or facility
     *                                                            name (e.g., "Main Street Post Office", "Downtown Locker Station").
     * @param string                        $address1             Street address of the agent location including building number and
     *                                                            street name. Used for customer navigation and shipment routing.
     * @param string                        $city                 City name where the agent location is situated. Used for location
     *                                                            filtering and geographic searches within the carrier network.
     * @param string                        $zipcode              Postal or ZIP code for the agent's location. Used for precise
     *                                                            geographic matching and distance calculations from customer addresses.
     * @param string                        $countryCode          ISO 3166-1 alpha-2 country code (e.g., "US", "GB", "DE") for the
     *                                                            agent's location. Determines regional availability and cross-border
     *                                                            service capabilities.
     * @param Optional|string               $serviceId            Identifier for the specific shipping service associated with
     *                                                            this agent. Links the agent to particular carrier services
     *                                                            or delivery methods available at this location.
     * @param Optional|string               $carrier              carrier name for this agent location
     * @param Optional|string               $carrierLogo          URL to the carrier's logo image
     * @param array<string, mixed>|Optional $openingHours         Structured schedule defining when the agent location is
     *                                                            open for customer access. Typically includes days of week
     *                                                            and time ranges. Critical for ensuring customers can access
     *                                                            locations during operational hours.
     * @param float|Optional                $latitude             Geographic coordinate (latitude) for the agent location. Used
     *                                                            for map display, distance calculations, and location-based
     *                                                            sorting. Enables mobile device navigation integration.
     * @param float|Optional                $longitude            Geographic coordinate (longitude) for the agent location. Works
     *                                                            with latitude to provide precise geographic positioning for
     *                                                            mapping and distance-based searches.
     * @param float|Optional                $distanceInKilometers distance from a reference point in kilometers
     * @param float|Optional                $distanceInMeters     distance from a reference point in meters
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $address1,
        public readonly string $city,
        public readonly string $zipcode,
        public readonly string $countryCode,
        public readonly string|Optional $serviceId,
        public readonly string|Optional $carrier,
        public readonly string|Optional $carrierLogo,
        public readonly array|Optional|null $openingHours,
        public readonly float|Optional $latitude,
        public readonly float|Optional $longitude,
        public readonly float|Optional $distanceInKilometers,
        public readonly float|Optional $distanceInMeters,
    ) {}
}
