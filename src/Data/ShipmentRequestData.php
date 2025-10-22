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
 * Represents a complete shipment creation request to the Shipit API.
 *
 * This comprehensive data object contains all information required to create a shipment,
 * including party details (sender, receiver, payer), package information, service selection,
 * delivery preferences, additional services, customs documentation, and integration metadata.
 * The request supports a wide range of shipping scenarios from simple domestic parcels to
 * complex international shipments with customs clearance and specialized handling requirements.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShipmentRequestData extends Data
{
    /**
     * Create a new shipment request data instance.
     *
     * @param PartyData                              $sender                     Sender party information including name, address, contact details,
     *                                                                           and company information. This party represents the shipment origin
     *                                                                           and appears on shipping labels and documentation.
     * @param PartyData                              $receiver                   Receiver party information including name, delivery address, contact
     *                                                                           details, and delivery preferences. This party represents the shipment
     *                                                                           destination and recipient of the goods.
     * @param DataCollection<int, ParcelData>        $parcels                    Collection of parcel data objects describing each package
     *                                                                           in the shipment. Includes dimensions, weight, and parcel-specific
     *                                                                           references. Most shipments contain a single parcel, but multi-parcel
     *                                                                           shipments are supported for large orders.
     * @param string                                 $serviceId                  Unique identifier for the shipping service to use (e.g., "postnord_home_small",
     *                                                                           "dhl_express"). This ID must match a service returned by the shipping methods
     *                                                                           endpoint and determines carrier, speed, and delivery method.
     * @param Optional|string                        $reference                  Customer reference number or order identifier for tracking and correlation
     *                                                                           with internal systems. Appears on labels and documentation for easy
     *                                                                           identification and order fulfillment workflows.
     * @param null|Optional|PartyData                $payer                      Third-party payer information when shipping costs are billed to someone
     *                                                                           other than sender or receiver. Used in B2B scenarios with centralized
     *                                                                           billing or third-party logistics arrangements.
     * @param null|Optional|PartyData                $pickupAddress              Pickup location details when the shipment should be collected
     *                                                                           from an address different from the sender's address. Common
     *                                                                           in warehouse fulfillment or multi-location business scenarios.
     * @param Optional|string                        $pickupId                   Identifier for a pre-selected pickup point or service point location.
     *                                                                           Required when using shipping methods that require pickup location
     *                                                                           selection (parcel lockers, service points).
     * @param bool|Optional                          $returnShipment             Indicates whether this is a return shipment where goods flow back
     *                                                                           to the original sender. Return shipments may have different pricing,
     *                                                                           documentation, and handling requirements.
     * @param bool|Optional                          $returnFreightDoc           Request generation of return freight documentation allowing the
     *                                                                           receiver to send items back using prepaid return labels. Common
     *                                                                           in e-commerce for customer returns.
     * @param float|Optional                         $valueAmount                Declared value of shipment contents for insurance purposes. Used to
     *                                                                           calculate insurance premiums and determine maximum compensation in
     *                                                                           case of loss or damage. Expressed in the currency specified.
     * @param Optional|string                        $freeText                   Free-form text field for delivery instructions, special handling notes,
     *                                                                           or messages to the carrier. This text may appear on labels or delivery
     *                                                                           documentation depending on carrier capabilities.
     * @param Optional|string                        $freeTextPickUp             Free-form text field specifically for pickup instructions when
     *                                                                           the carrier collects the shipment. Helps drivers locate pickup
     *                                                                           locations or understand special pickup requirements.
     * @param Optional|string                        $contents                   General description of shipment contents for customs, carrier handling,
     *                                                                           and delivery purposes. More detailed than individual item descriptions,
     *                                                                           provides context for the entire shipment.
     * @param null|Optional|ProformaData             $proforma                   Proforma invoice data for international shipments requiring customs
     *                                                                           clearance. Contains detailed item descriptions, values, quantities,
     *                                                                           HS codes, and country of origin for customs processing.
     * @param bool|Optional                          $dangerous                  Indicates whether the shipment contains dangerous goods (hazmat) requiring
     *                                                                           special handling, documentation, and compliance with IATA/ADR regulations.
     *                                                                           May restrict available carriers and increase costs.
     * @param bool|Optional                          $proofOfDelivery            Request proof of delivery documentation including recipient signature
     *                                                                           and delivery timestamp. Provides legal evidence of successful delivery
     *                                                                           for high-value or dispute-prone shipments.
     * @param bool|Optional                          $leaveAtDoor                Authorize carrier to leave package at door without signature if recipient
     *                                                                           is unavailable. Reduces failed delivery attempts but increases theft risk.
     *                                                                           Carrier availability and restrictions vary by service.
     * @param bool|Optional                          $preNoticeSMS               Request SMS notification to recipient with delivery updates and estimated
     *                                                                           arrival time. Improves delivery success rates by ensuring recipient
     *                                                                           availability. Requires valid recipient phone number.
     * @param bool|Optional                          $preNoticeEmail             Request email notification to recipient with tracking information and
     *                                                                           delivery updates. Standard service for most carriers, helps recipients
     *                                                                           track shipment progress. Requires valid recipient email.
     * @param bool|Optional                          $deliveryCarryIn            Request carrier to bring package inside the premises rather than leaving
     *                                                                           at door or entrance. Premium service for heavy/bulky items, typically
     *                                                                           incurs additional charges and requires appointment scheduling.
     * @param bool|Optional                          $special                    Indicates special handling requirements beyond standard services. Generic flag
     *                                                                           for non-standard shipments requiring manual review or carrier coordination.
     *                                                                           Specific requirements should be detailed in freeText field.
     * @param bool|Optional                          $callBeforeDelivery         Request carrier to phone recipient before delivery attempt to ensure
     *                                                                           availability and confirm delivery timing. Improves first-time delivery
     *                                                                           success for time-sensitive or high-value shipments.
     * @param bool|Optional                          $climateCompensation        Opt-in for carbon offset program to compensate for shipment's
     *                                                                           environmental impact. May incur small additional fee depending
     *                                                                           on carrier and service. Provides sustainability credentials.
     * @param DataCollection<int, ItemData>|Optional $items                      Detailed collection of individual items within the shipment,
     *                                                                           each with description, quantity, value, and HS code. More
     *                                                                           granular than parcels, used for customs, insurance, and
     *                                                                           inventory tracking. Required for international shipments.
     * @param bool|Optional                          $isQuickShipment            Indicates expedited processing for time-critical shipments requiring
     *                                                                           same-day or next-day pickup and delivery. May trigger priority handling
     *                                                                           in warehouse and carrier systems with associated rush fees.
     * @param null|CodData|Optional                  $cod                        Cash on delivery configuration when payment is collected from recipient
     *                                                                           upon delivery. Includes payment amount, currency, and payment method
     *                                                                           (cash, card). Common in markets with low e-commerce trust or unbanked populations.
     * @param bool|Optional                          $personalVerification       Require recipient to verify identity with government-issued ID before
     *                                                                           accepting delivery. Used for age-restricted goods (alcohol, tobacco)
     *                                                                           or high-value items requiring verified receipt.
     * @param bool|Optional                          $idCheck                    Require identity verification during delivery, similar to personalVerification
     *                                                                           but may have different carrier implementation or verification methods.
     *                                                                           Consult carrier documentation for specific requirements.
     * @param bool|Optional                          $signatureRequired          Mandate recipient signature upon delivery as proof of receipt. More
     *                                                                           stringent than standard delivery, prevents "leave at door" options.
     *                                                                           Recommended for valuable or liability-sensitive shipments.
     * @param bool|Optional                          $fragile                    Indicate package contains fragile items requiring careful handling during
     *                                                                           transit and delivery. May result in "Fragile" labels and special carrier
     *                                                                           handling procedures to minimize damage risk.
     * @param bool|Optional                          $delivery                   Generic delivery service flag, carrier-specific meaning. May indicate
     *                                                                           specific delivery time windows or service levels depending on carrier.
     *                                                                           Consult carrier documentation for exact semantics.
     * @param bool|Optional                          $delivery09                 Request delivery before 9:00 AM for time-critical shipments. Premium
     *                                                                           service with significant cost premium, typically limited to business
     *                                                                           addresses and major urban areas. Subject to carrier availability.
     * @param Optional|string                        $currency                   ISO 4217 currency code (e.g., EUR, USD, SEK) for all monetary values in
     *                                                                           the request including valueAmount, price, and COD amounts. Must be
     *                                                                           supported by selected carrier and service.
     * @param Optional|string                        $weightUnit                 Unit of measurement for parcel weights. Supported values typically include
     *                                                                           "kg" (kilograms) and "lb" (pounds). Should be consistent across all
     *                                                                           parcels in the shipment. Defaults to platform default if not specified.
     * @param Optional|string                        $dimensionUnit              Unit of measurement for parcel dimensions (length, width, height). Supported
     *                                                                           values typically include "cm" (centimeters) and "in" (inches). Should be
     *                                                                           consistent across all parcels. Defaults to platform default if not specified.
     * @param null|DateInformationData|Optional      $dateInformation            Scheduling information including preferred pickup date,
     *                                                                           delivery date, and time windows. Used for scheduled
     *                                                                           deliveries, appointment-based services, or coordinating
     *                                                                           warehouse pickup timing.
     * @param null|AdditionalServicesData|Optional   $additionalServices         Carrier-specific additional services beyond standard
     *                                                                           delivery, such as weekend delivery, evening delivery,
     *                                                                           installation services, or specialized handling. Service
     *                                                                           availability and pricing vary by carrier.
     * @param int|Optional                           $organizationId             Organization identifier when creating shipments on behalf of a specific
     *                                                                           business entity within a multi-tenant platform. Used for segregating
     *                                                                           shipments, billing, and access control in enterprise scenarios.
     * @param int|Optional                           $organizationMemberId       Specific team member or user within the organization who created the
     *                                                                           shipment. Used for audit trails, performance tracking, and access
     *                                                                           control in multi-user organizational accounts.
     * @param array<string, mixed>|Optional          $wolt                       Integration-specific data for Wolt delivery service including store
     *                                                                           identifiers, order references, and Wolt-specific configuration. Used
     *                                                                           when Shipit acts as intermediary for Wolt delivery bookings.
     * @param array<int, string>|Optional            $associatedShipments        Array of related shipment IDs for multi-shipment orders
     *                                                                           or shipment groups. Enables tracking relationships between
     *                                                                           split orders, return/original pairs, or bulk shipments
     *                                                                           requiring coordinated handling.
     * @param Optional|string                        $carrierContract            Carrier contract identifier or name for accounts with negotiated carrier
     *                                                                           rates or special service agreements. Ensures shipment uses contracted
     *                                                                           pricing and service levels rather than standard public rates.
     * @param int|Optional                           $carrierContractId          Numeric identifier for carrier contract, alternative or complement to
     *                                                                           carrierContract string. Used in systems that reference contracts by
     *                                                                           database ID rather than name or code.
     * @param int|Optional                           $consignmentTemplateId      Template identifier for pre-configured shipment settings including
     *                                                                           default services, preferences, and party information. Simplifies
     *                                                                           repeat shipments by loading saved configuration.
     * @param Optional|string                        $senderId                   Address book entry identifier for the sender, allowing reuse of saved sender
     *                                                                           information without providing full PartyData. Simplifies API integration
     *                                                                           for applications with stable sender addresses.
     * @param Optional|string                        $receiverId                 Address book entry identifier for the receiver, similar to senderId but for
     *                                                                           recipient information. Enables quick shipment creation using saved customer
     *                                                                           addresses from previous orders.
     * @param null|Optional|string                   $pendingShipmentId          Identifier for a previously created pending shipment being finalized
     *                                                                           or updated. Used in two-stage shipment workflows where initial
     *                                                                           creation is separate from final confirmation and label generation.
     * @param Optional|string                        $type                       Shipment type classification (e.g., "parcel", "pallet", "document", "return").
     *                                                                           Affects carrier selection, pricing, and handling requirements. Type semantics
     *                                                                           may vary by carrier and platform configuration.
     * @param Optional|string                        $selectedPayment            Payment method selection for shipment charges (e.g., "account", "credit_card",
     *                                                                           "invoice"). Determines how shipping costs are billed and collected. Available
     *                                                                           methods depend on user account type and carrier capabilities.
     * @param Optional|string                        $cartId                     Shopping cart identifier linking this shipment to an e-commerce cart session.
     *                                                                           Enables correlation between cart checkout and shipment creation for integrated
     *                                                                           shopping experiences and analytics.
     * @param Optional|string                        $cartItemId                 Specific cart item identifier when creating shipments for individual products
     *                                                                           within a cart. Supports split shipment scenarios where different cart items
     *                                                                           ship separately due to stock location or delivery timing.
     * @param int|Optional                           $resellerId                 Reseller or partner account identifier when shipment is created through a
     *                                                                           reseller channel. Enables revenue sharing, commission tracking, and partner
     *                                                                           attribution in white-label or marketplace scenarios.
     * @param Optional|string                        $printType                  Label print format specification (e.g., "PDF", "ZPL", "PNG"). Determines
     *                                                                           the format of returned shipping labels to match printer capabilities.
     *                                                                           PDF for standard printers, ZPL for thermal label printers.
     * @param bool|Optional                          $sendOrderConfirmationEmail Request automatic order confirmation email to sender and/or receiver
     *                                                                           upon successful shipment creation. Email includes shipment details,
     *                                                                           tracking information, and estimated delivery. Standard for e-commerce.
     * @param Optional|string                        $widgetIdentifier           Identifier for the integration widget or UI component used to create the
     *                                                                           shipment. Enables analytics on shipment sources, integration performance,
     *                                                                           and user behavior across different integration points.
     * @param Optional|string                        $inventory                  Inventory system identifier or warehouse location code for stock allocation
     *                                                                           and fulfillment tracking. Links shipment to specific inventory records for
     *                                                                           accurate stock management and multi-warehouse routing.
     * @param Optional|string                        $dropinId                   Drop-in widget instance identifier for embedded shipping solutions. Used to
     *                                                                           track and attribute shipments created through JavaScript widgets embedded
     *                                                                           in merchant websites or applications.
     * @param Optional|string                        $externalId                 External system identifier for the shipment (e.g., ERP order number, WMS
     *                                                                           shipment ID). Enables bidirectional synchronization and correlation between
     *                                                                           Shipit and external business systems.
     * @param Optional|string                        $pickupInstructions         Detailed instructions for carrier pickup including access codes, parking
     *                                                                           information, building entry procedures, and contact instructions. Helps
     *                                                                           drivers successfully collect shipments on first attempt.
     * @param Optional|string                        $deliveryInstructions       Detailed instructions for delivery including gate codes, intercom
     *                                                                           procedures, safe drop locations, and recipient contact preferences.
     *                                                                           Improves delivery success rates and customer satisfaction.
     * @param Optional|string                        $apiContext                 Integration context or environment identifier (e.g., "production", "staging",
     *                                                                           "partner_xyz"). Used for routing, monitoring, and debugging shipments from
     *                                                                           different integration sources or environments.
     */
    public function __construct(
        public readonly PartyData $sender,
        public readonly PartyData $receiver,
        #[DataCollectionOf(ParcelData::class)]
        public readonly DataCollection $parcels,
        public readonly string $serviceId,
        public readonly string|Optional $reference,
        public readonly PartyData|Optional|null $payer,
        public readonly PartyData|Optional|null $pickupAddress,
        public readonly string|Optional $pickupId,
        public readonly bool|Optional $returnShipment,
        public readonly bool|Optional $returnFreightDoc,
        public readonly float|Optional $valueAmount,
        public readonly string|Optional $freeText,
        public readonly string|Optional $freeTextPickUp,
        public readonly string|Optional $contents,
        public readonly ProformaData|Optional|null $proforma,
        public readonly bool|Optional $dangerous,
        public readonly bool|Optional $proofOfDelivery,
        public readonly bool|Optional $leaveAtDoor,
        public readonly bool|Optional $preNoticeSMS,
        public readonly bool|Optional $preNoticeEmail,
        public readonly bool|Optional $deliveryCarryIn,
        public readonly bool|Optional $special,
        public readonly bool|Optional $callBeforeDelivery,
        public readonly bool|Optional $climateCompensation,
        #[DataCollectionOf(ItemData::class)]
        public readonly DataCollection|Optional $items,
        public readonly bool|Optional $isQuickShipment,
        public readonly CodData|Optional|null $cod,
        public readonly bool|Optional $personalVerification,
        public readonly bool|Optional $idCheck,
        public readonly bool|Optional $signatureRequired,
        public readonly bool|Optional $fragile,
        public readonly bool|Optional $delivery,
        public readonly bool|Optional $delivery09,
        public readonly string|Optional $currency,
        public readonly string|Optional $weightUnit,
        public readonly string|Optional $dimensionUnit,
        public readonly DateInformationData|Optional|null $dateInformation,
        public readonly AdditionalServicesData|Optional|null $additionalServices,
        public readonly int|Optional $organizationId,
        public readonly int|Optional $organizationMemberId,
        public readonly array|Optional $wolt,
        public readonly array|Optional $associatedShipments,
        public readonly string|Optional $carrierContract,
        public readonly int|Optional $carrierContractId,
        public readonly int|Optional $consignmentTemplateId,
        public readonly string|Optional $senderId,
        public readonly string|Optional $receiverId,
        public readonly string|Optional|null $pendingShipmentId,
        public readonly string|Optional $type,
        public readonly string|Optional $selectedPayment,
        public readonly string|Optional $cartId,
        public readonly string|Optional $cartItemId,
        public readonly int|Optional $resellerId,
        public readonly string|Optional $printType,
        public readonly bool|Optional $sendOrderConfirmationEmail,
        public readonly string|Optional $widgetIdentifier,
        public readonly string|Optional $inventory,
        public readonly string|Optional $dropinId,
        public readonly string|Optional $externalId,
        public readonly string|Optional $pickupInstructions,
        public readonly string|Optional $deliveryInstructions,
        public readonly string|Optional $apiContext,
    ) {}
}
