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
 * Represents the API response data for a shipment creation or update operation.
 *
 * This data object encapsulates all response fields returned by the Shipit API
 * when creating, updating, or retrieving shipment information, including tracking
 * details, documentation, labels, and error information.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShipmentResponseData extends Data
{
    /**
     * Create a new shipment response data instance.
     *
     * @param int                                       $status         HTTP status code indicating the success or failure of the
     *                                                                  shipment operation. Standard codes: 200 for success, 400
     *                                                                  for validation errors, 500 for server errors.
     * @param Optional|string                           $trackingNumber Unique tracking identifier assigned by the carrier
     *                                                                  for this shipment. Used to track package movement
     *                                                                  through the delivery network. May be absent if
     *                                                                  shipment creation failed or for certain service types.
     * @param array<int, string>|Optional               $trackingUrls   Collection of tracking URLs provided by the carrier,
     *                                                                  allowing recipients to track shipment status online.
     *                                                                  Multiple URLs may be provided for multi-package
     *                                                                  shipments or services with different tracking portals.
     * @param Optional|string                           $orderId        Internal order identifier linking this shipment to the
     *                                                                  merchant's order management system. Used for correlation
     *                                                                  between shipments and business transactions.
     * @param Optional|string                           $shipitNumber   Unique Shipit platform identifier for this shipment,
     *                                                                  used for internal tracking, support queries, and API
     *                                                                  operations. This differs from the carrier tracking number.
     * @param array<string, mixed>|Optional             $freightDoc     Freight documentation data including waybills, customs
     *                                                                  forms, and commercial invoices required for international
     *                                                                  shipments. Contains URLs or base64-encoded document data.
     * @param Optional|string                           $receipt        Receipt or proof of shipment data including timestamps,
     *                                                                  costs, and confirmation details. Used for accounting
     *                                                                  and audit purposes.
     * @param array<int, array<string, mixed>>|Optional $labels         Shipping label data including URLs or base64-encoded
     *                                                                  label images in various formats (PDF, PNG, ZPL).
     *                                                                  Multiple labels may be provided for multi-package
     *                                                                  shipments or different label sizes.
     * @param Optional|string                           $cartId         Shopping cart identifier if the shipment was created through
     *                                                                  a cart-based checkout flow. Used to associate shipments with
     *                                                                  e-commerce transactions.
     * @param Optional|string                           $cartItemId     specific cart item identifier linking this shipment to an
     *                                                                  individual product or line item within a shopping cart
     * @param array<string, mixed>|Optional             $error          Error information including error codes, messages, and
     *                                                                  validation failures when the shipment operation fails.
     *                                                                  Contains structured error details for client handling.
     */
    public function __construct(
        public readonly int $status,
        public readonly string|Optional $trackingNumber,
        public readonly array|Optional $trackingUrls,
        public readonly string|Optional $orderId,
        public readonly string|Optional $shipitNumber,
        public readonly array|Optional $freightDoc,
        public readonly string|Optional $receipt,
        public readonly array|Optional $labels,
        public readonly string|Optional $cartId,
        public readonly string|Optional $cartItemId,
        public readonly array|Optional $error,
    ) {}
}
