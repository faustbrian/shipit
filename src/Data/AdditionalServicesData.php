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
 * Represents additional shipping services and handling options.
 *
 * Defines optional value-added services that can be requested for a shipment,
 * such as specialized handling, delivery preferences, temperature control,
 * and dangerous goods transportation.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class AdditionalServicesData extends Data
{
    /**
     * Create a new additional services data instance.
     *
     * @param bool|Optional $dangerousGoods      Enable dangerous goods handling with ADR compliance and special documentation
     * @param bool|Optional $callAdvising        Request phone call notification to recipient before delivery
     * @param bool|Optional $emailAdvising       Enable email notifications to recipient about shipment status
     * @param bool|Optional $receiptInTerminal   Require shipment to be received at carrier terminal instead of delivery
     * @param bool|Optional $receptionInTerminal Allow recipient to collect shipment from carrier terminal location
     * @param bool|Optional $hiabPickUp          Request HIAB crane truck for pickup of heavy or oversized items
     * @param bool|Optional $hiabDelivery        Request HIAB crane truck for delivery of heavy or oversized items
     * @param bool|Optional $tailLiftLoading     Provide hydraulic tail lift equipment for loading at pickup location
     * @param bool|Optional $tailLiftUnloading   Provide hydraulic tail lift equipment for unloading at delivery location
     * @param bool|Optional $scheduledPickups    Request specific time slot for pickup appointment
     * @param bool|Optional $scheduledDeliveries Request specific time slot for delivery appointment
     * @param bool|Optional $carryingGoods       Enable special handling for goods requiring manual carrying (e.g., stairs)
     * @param bool|Optional $edibleTransport     Ensure food-safe transport conditions for edible products
     * @param bool|Optional $frozenTransport     Maintain frozen temperature conditions (-18°C or below) during transport
     * @param bool|Optional $coldTransport       Maintain refrigerated temperature conditions (2°C to 8°C) during transport
     * @param bool|Optional $warmTransport       Maintain warm temperature conditions for temperature-sensitive goods
     * @param bool|Optional $saturdayDelivery    Enable delivery on Saturday outside normal business days
     * @param bool|Optional $pharmaceuticals     Comply with pharmaceutical transport regulations and temperature monitoring
     * @param bool|Optional $expressDelivery     Request expedited delivery with priority handling and faster transit
     * @param bool|Optional $insurance           Add shipment insurance coverage for declared value protection
     * @param bool|Optional $additionalDriver    Provide second driver for deliveries requiring extra assistance
     * @param bool|Optional $indoorDelivery      Deliver goods inside building to specified room or location
     */
    public function __construct(
        public readonly bool|Optional $dangerousGoods,
        public readonly bool|Optional $callAdvising,
        public readonly bool|Optional $emailAdvising,
        public readonly bool|Optional $receiptInTerminal,
        public readonly bool|Optional $receptionInTerminal,
        public readonly bool|Optional $hiabPickUp,
        public readonly bool|Optional $hiabDelivery,
        public readonly bool|Optional $tailLiftLoading,
        public readonly bool|Optional $tailLiftUnloading,
        public readonly bool|Optional $scheduledPickups,
        public readonly bool|Optional $scheduledDeliveries,
        public readonly bool|Optional $carryingGoods,
        public readonly bool|Optional $edibleTransport,
        public readonly bool|Optional $frozenTransport,
        public readonly bool|Optional $coldTransport,
        public readonly bool|Optional $warmTransport,
        public readonly bool|Optional $saturdayDelivery,
        public readonly bool|Optional $pharmaceuticals,
        public readonly bool|Optional $expressDelivery,
        public readonly bool|Optional $insurance,
        public readonly bool|Optional $additionalDriver,
        public readonly bool|Optional $indoorDelivery,
    ) {}
}
