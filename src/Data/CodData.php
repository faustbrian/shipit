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
 * Represents Cash on Delivery (COD) payment information.
 *
 * Defines the payment details for shipments requiring cash collection
 * from the recipient at the time of delivery, including bank account
 * information for remittance.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CodData extends Data
{
    /**
     * Create a new COD payment data instance.
     *
     * @param float  $amount       Amount to collect from recipient at delivery in decimal format
     * @param string $currencyCode ISO 4217 three-letter currency code (e.g., EUR, USD, GBP)
     * @param string $account      Bank account number where collected funds should be deposited
     * @param string $bank         Bank identifier or BIC/SWIFT code for the receiving bank
     * @param string $reference    Payment reference number for reconciliation and tracking purposes
     */
    public function __construct(
        public readonly float $amount,
        public readonly string $currencyCode,
        public readonly string $account,
        public readonly string $bank,
        public readonly string $reference,
    ) {}
}
