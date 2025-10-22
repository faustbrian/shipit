<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Optional;

/**
 * Request data for retrieving available shipping methods.
 *
 * Encapsulates sender/receiver information, parcel details, and service options
 * required to query the Shipit API for available shipping methods between two
 * locations. Supports various shipping characteristics like fragile items,
 * dangerous goods, cash on delivery, and time-specific delivery options.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodsRequestData extends Data
{
    /**
     * Create a new shipping methods request.
     *
     * @param PartyData                       $sender                 Sender party information including address and contact details
     *                                                                used to determine pickup location and available carriers
     * @param PartyData                       $receiver               Receiver party information including address and contact details
     *                                                                used to determine delivery location and service availability
     * @param DataCollection<int, ParcelData> $parcels                Collection of parcel objects defining dimensions,
     *                                                                weight, and quantity of items to be shipped.
     *                                                                Required to calculate accurate shipping rates
     *                                                                and determine carrier eligibility based on size
     *                                                                and weight constraints
     * @param bool|Optional                   $fragile                Indicates whether shipment contains fragile items requiring
     *                                                                special handling. Affects available carriers and pricing.
     *                                                                When true, enables fragile handling options
     * @param null|Optional|string            $customPickupPostalCode Override postal code for pickup location when
     *                                                                different from sender address. Used for scenarios
     *                                                                where items are collected from warehouse or
     *                                                                depot rather than sender's registered address
     * @param bool|Optional                   $companyIsSending       Indicates whether sender is a business entity rather than
     *                                                                individual. Affects available B2B shipping options and
     *                                                                pricing tiers for commercial senders
     * @param bool|Optional                   $companyIsReceiving     Indicates whether receiver is a business entity. Affects
     *                                                                delivery options such as business hours delivery and
     *                                                                commercial address validation
     * @param bool|Optional                   $pickup                 Enables pickup service where carrier collects shipment from sender
     *                                                                location. When true, filters methods to include only carriers
     *                                                                offering pickup services
     * @param bool|Optional                   $delivery               Enables delivery service where carrier delivers to receiver address.
     *                                                                When false, may indicate collection point or depot delivery
     * @param bool|Optional                   $dangerous              Indicates shipment contains dangerous goods requiring special
     *                                                                handling and licensing. Restricts available carriers to those
     *                                                                certified for hazardous materials transport
     * @param bool|Optional                   $limitedQtys            Indicates shipment contains limited quantities of dangerous
     *                                                                goods exempt from full hazmat regulations. Allows broader
     *                                                                carrier selection than full dangerous goods declaration
     * @param bool|Optional                   $delivery09             Enables delivery before 9 AM service option. Filters methods
     *                                                                to include only carriers offering early morning delivery with
     *                                                                time-definite guarantee
     * @param bool|Optional                   $cod                    Enables cash on delivery service where payment is collected upon
     *                                                                delivery. Restricts available methods to carriers supporting COD
     *                                                                and includes COD service fees in pricing
     * @param bool|Optional                   $includeDescriptions    Includes detailed service descriptions in response when
     *                                                                true. Provides additional context about each shipping
     *                                                                method including features, restrictions, and service levels
     * @param Optional|string                 $userSessionId          Session identifier for tracking user interactions and maintaining
     *                                                                stateful operations across multiple API calls. Used for analytics
     *                                                                and debugging user-specific shipping method queries
     */
    public function __construct(
        public readonly PartyData $sender,
        public readonly PartyData $receiver,
        #[DataCollectionOf(ParcelData::class)]
        public readonly DataCollection $parcels,
        public readonly bool|Optional $fragile,
        public readonly string|Optional|null $customPickupPostalCode,
        public readonly bool|Optional $companyIsSending,
        public readonly bool|Optional $companyIsReceiving,
        public readonly bool|Optional $pickup,
        public readonly bool|Optional $delivery,
        public readonly bool|Optional $dangerous,
        public readonly bool|Optional $limitedQtys,
        public readonly bool|Optional $delivery09,
        public readonly bool|Optional $cod,
        public readonly bool|Optional $includeDescriptions,
        public readonly string|Optional $userSessionId,
    ) {}
}
