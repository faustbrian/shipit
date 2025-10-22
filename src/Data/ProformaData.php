<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data;

use Spatie\LaravelData\Data;

/**
 * Represents a proforma invoice for international shipments.
 *
 * This data object encapsulates all financial and shipping information
 * required for customs clearance and international shipping documentation.
 * Proforma invoices are used to declare the value of goods, calculate
 * duties and taxes, and provide detailed cost breakdowns for customs
 * authorities and carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ProformaData extends Data
{
    /**
     * Create a new proforma invoice data instance.
     *
     * @param float  $invoiceSubTotal     Subtotal amount before discounts, charges, and taxes. Represents
     *                                    the base value of goods being shipped for customs declaration
     *                                    purposes.
     * @param float  $otherCharges        Additional charges beyond freight and insurance, such as handling
     *                                    fees, packaging costs, or special service fees. Used in total
     *                                    customs value calculation.
     * @param float  $insurance           Insurance cost for the shipment. May be required for high-value
     *                                    goods or specific trade terms. Included in customs value calculations
     *                                    depending on the Incoterms used.
     * @param string $incoTerms           International Commercial Terms (Incoterms) defining the responsibility
     *                                    division between buyer and seller for shipping costs, risk transfer,
     *                                    and insurance (e.g., "FOB", "CIF", "DDP", "EXW").
     * @param string $shipperName         Legal name of the shipper or exporter. Required for customs
     *                                    documentation and must match the sender information on the
     *                                    shipping label.
     * @param string $invoiceNumber       Unique identifier for the proforma invoice. Used for tracking,
     *                                    reference in customs documentation, and reconciliation with
     *                                    commercial invoices.
     * @param float  $totalWeight         Total weight of the shipment in kilograms or pounds, depending on
     *                                    carrier requirements. Used for freight calculations and customs
     *                                    declarations.
     * @param float  $freightCharges      Transportation cost for shipping the goods. May be included in
     *                                    customs value calculation depending on the Incoterms specified.
     * @param string $invoiceCurrency     ISO 4217 three-letter currency code (e.g., "USD", "EUR", "GBP")
     *                                    representing the currency for all monetary amounts on the
     *                                    proforma invoice.
     * @param float  $discount            Total discount amount applied to the invoice subtotal. Reduces the
     *                                    customs value and may require justification for significant discounts.
     * @param float  $invoiceTotal        Final total amount including all charges, discounts, duties, and
     *                                    taxes. Represents the complete financial obligation for the
     *                                    shipment.
     * @param string $shippingDate        Date when the shipment is scheduled to be shipped, typically in
     *                                    ISO 8601 format (YYYY-MM-DD). Required for customs documentation
     *                                    and shipping manifests.
     * @param float  $totalDutiesAndTaxes Combined total of all customs duties and taxes applicable
     *                                    to the shipment. Calculated based on destination country
     *                                    regulations and commodity classifications.
     * @param float  $totalDuties         Total customs duties payable at the destination country. Calculated
     *                                    based on tariff schedules, commodity codes, and trade agreements.
     * @param float  $totalTaxes          Total tax amount including VAT, GST, or other applicable taxes at
     *                                    the destination. Separate from customs duties and varies by country
     *                                    and commodity type.
     */
    public function __construct(
        public readonly float $invoiceSubTotal,
        public readonly float $otherCharges,
        public readonly float $insurance,
        public readonly string $incoTerms,
        public readonly string $shipperName,
        public readonly string $invoiceNumber,
        public readonly float $totalWeight,
        public readonly float $freightCharges,
        public readonly string $invoiceCurrency,
        public readonly float $discount,
        public readonly float $invoiceTotal,
        public readonly string $shippingDate,
        public readonly float $totalDutiesAndTaxes,
        public readonly float $totalDuties,
        public readonly float $totalTaxes,
    ) {}
}
