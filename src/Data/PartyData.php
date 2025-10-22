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
 * Represents a party (sender or recipient) in a shipment.
 *
 * Contains complete contact, address, and tax identification information
 * for shipment parties. Includes all fields required for domestic and
 * international shipping, customs clearance, and tax compliance.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PartyData extends Data
{
    /**
     * Create a new party data instance.
     *
     * @param string               $name                         Full name of the individual or company name for the party
     * @param string               $email                        Email address for shipping notifications and communication
     * @param string               $phone                        Contact phone number including country code
     * @param string               $address                      Primary street address line for delivery or pickup location
     * @param Optional|string      $address2                     Optional secondary address line for apartment, suite, or building details
     * @param string               $city                         City or municipality name for the address
     * @param string               $postcode                     Postal or ZIP code for the address
     * @param Optional|string      $state                        State, province, or region code (required for some countries like US, CA)
     * @param string               $country                      ISO 3166-1 alpha-2 country code (e.g., "FI", "US", "GB")
     * @param bool|Optional        $isCompany                    Indicates if party is a company (true) or individual (false)
     * @param Optional|string      $contactPerson                Name of specific contact person at company for delivery coordination
     * @param null|Optional|string $eoriNumber                   Economic Operators Registration and Identification number for EU customs
     * @param null|Optional|string $hmrcNumber                   UK HMRC tax identification number for customs clearance
     * @param null|Optional|string $iossNumber                   Import One-Stop Shop VAT number for EU e-commerce shipments under €150
     * @param null|Optional|string $iossNumberIssuer             Country code of the EU member state that issued the IOSS number
     * @param null|Optional|string $vatNumber                    VAT (Value Added Tax) registration number for tax identification
     * @param null|Optional|string $voecNumber                   Norwegian VOEC registration number for distance sales
     * @param null|Optional|string $socialSecurityNumber         Social security or national identification number for customs purposes
     * @param null|Optional|string $employerIdentificationNumber US Federal Tax ID (EIN) for business tax identification
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $address,
        public readonly string|Optional $address2,
        public readonly string $city,
        public readonly string $postcode,
        public readonly string|Optional $state,
        public readonly string $country,
        public readonly bool|Optional $isCompany,
        public readonly string|Optional $contactPerson,
        public readonly string|Optional|null $eoriNumber,
        public readonly string|Optional|null $hmrcNumber,
        public readonly string|Optional|null $iossNumber,
        public readonly string|Optional|null $iossNumberIssuer,
        public readonly string|Optional|null $vatNumber,
        public readonly string|Optional|null $voecNumber,
        public readonly string|Optional|null $socialSecurityNumber,
        public readonly string|Optional|null $employerIdentificationNumber,
    ) {}
}
