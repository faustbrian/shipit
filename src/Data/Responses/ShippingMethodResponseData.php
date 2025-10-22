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
 * Represents a single shipping method option from the Shipit API.
 *
 * This data object contains comprehensive information about a specific delivery
 * service, including pricing, carrier details, service capabilities, and
 * requirements for using this shipping method.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodResponseData extends Data
{
    /**
     * Create a new shipping method response instance.
     *
     * @param string                         $serviceId                 unique identifier for this shipping service, used when creating
     *                                                                  shipments to select this specific delivery method
     * @param string                         $carrier                   Name of the logistics carrier providing this service (e.g., DHL,
     *                                                                  PostNord, Bring). Used for carrier-specific logic and customer
     *                                                                  communication about delivery expectations.
     * @param string                         $serviceName               human-readable name of the shipping service, suitable for
     *                                                                  display to end users in shipping method selection interfaces
     * @param float                          $price                     Total price for this shipping method including VAT/taxes, expressed
     *                                                                  in the currency specified by the currency field. Used for customer
     *                                                                  display and checkout calculations.
     * @param float                          $priceVat0                 base price for this shipping method excluding all VAT/taxes,
     *                                                                  used for accounting, tax calculations, and displaying prices
     *                                                                  in B2B contexts where VAT is calculated separately
     * @param string                         $currency                  ISO 4217 currency code (e.g., EUR, USD, SEK) indicating the
     *                                                                  currency in which all prices are expressed. Essential for
     *                                                                  proper price display and multi-currency support.
     * @param bool                           $pickup                    indicates whether this service requires or supports pickup at a
     *                                                                  service point location rather than home/business delivery
     * @param Optional|string                $deliveryTime              Estimated delivery time description (e.g., "1-2 business days",
     *                                                                  "Next day delivery"). Helps customers make informed shipping
     *                                                                  choices based on urgency. May be absent if carrier doesn't
     *                                                                  provide time estimates.
     * @param bool                           $isPickupLocationMethod    Indicates whether this service requires selection of a specific
     *                                                                  pickup location (parcel locker, service point, store). When true,
     *                                                                  clients must present location selection UI to the customer.
     * @param bool                           $isReturnService           Indicates whether this is a return shipping service, used when
     *                                                                  customers need to send items back to the merchant. Return services
     *                                                                  may have different pricing and documentation requirements.
     * @param bool                           $requiresEmailForRecipient Indicates whether the recipient's email address is mandatory
     *                                                                  for this service. Some carriers require email for delivery
     *                                                                  notifications and tracking information.
     * @param bool                           $requiresHSTariffCode      Indicates whether HS (Harmonized System) tariff codes are required
     *                                                                  for shipments using this service. Typically true for international
     *                                                                  shipments requiring customs declarations.
     * @param bool                           $supportsReturnFreightDoc  Indicates whether this service supports generation of return
     *                                                                  freight documentation. Used when merchants need to provide
     *                                                                  pre-paid return labels to customers.
     * @param Optional|string                $logo                      URL or path to the carrier's logo image for display in shipping
     *                                                                  method selection interfaces. Helps customers visually identify
     *                                                                  their preferred carriers.
     * @param array<string, string>|Optional $descriptions              Localized service descriptions in multiple languages,
     *                                                                  keyed by language code. Provides detailed service
     *                                                                  information for customer display.
     */
    public function __construct(
        public readonly string $serviceId,
        public readonly string $carrier,
        public readonly string|Optional $serviceName,
        public readonly float|Optional $price,
        public readonly float|Optional $priceVat0,
        public readonly string|Optional $currency,
        public readonly bool|Optional $pickup,
        public readonly string|Optional $deliveryTime,
        public readonly bool|Optional $isPickupLocationMethod,
        public readonly bool|Optional $isReturnService,
        public readonly bool|Optional $requiresEmailForRecipient,
        public readonly bool|Optional $requiresHSTariffCode,
        public readonly bool|Optional $supportsReturnFreightDoc,
        public readonly string|Optional $logo,
        public readonly array|Optional $descriptions,
    ) {}
}
