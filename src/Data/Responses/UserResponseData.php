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
 * Represents user account information from the Shipit API.
 *
 * This data object contains comprehensive user profile data including identity,
 * contact information, billing status, business entity details, and wallet
 * information for managing shipments and payments.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UserResponseData extends Data
{
    /**
     * Create a new user response data instance.
     *
     * @param string                        $id                Unique identifier for the user account within the Shipit platform.
     *                                                         This ID is used for all user-specific API operations and maintains
     *                                                         consistency across the system.
     * @param string                        $name              Full name of the user as registered in their account profile.
     *                                                         Used for display purposes and as default sender information
     *                                                         when creating shipments.
     * @param string                        $email             Primary email address for the user account. Used for authentication,
     *                                                         notifications, receipts, and important account communications.
     *                                                         Must be unique within the platform.
     * @param Optional|string               $phone             Contact phone number for the user. Used for delivery notifications,
     *                                                         customer service communications, and as default sender phone
     *                                                         information. May be absent if user hasn't provided phone details.
     * @param Optional|string               $country           ISO 3166-1 alpha-2 country code (e.g., FI, SE, EE) indicating
     *                                                         the user's primary country. Used for default address settings,
     *                                                         localization, and available shipping services.
     * @param Optional|string               $locale            User's preferred language and region code (e.g., fi_FI, en_US, sv_SE).
     *                                                         Used to determine UI language, email communications language, and
     *                                                         localized content display. Follows BCP 47 language tag format.
     * @param bool|Optional                 $isBillingCustomer Indicates whether this user has billing customer status with
     *                                                         enhanced features such as invoicing, credit terms, or volume
     *                                                         discounts. Affects available payment methods and pricing.
     * @param array<string, mixed>|Optional $businessEntity    Business entity information including company name, VAT number,
     *                                                         business registration details, and tax information. Present
     *                                                         for business accounts used in B2B shipping scenarios.
     * @param array<string, mixed>|Optional $wallet            Wallet and payment information including account balance, credit,
     *                                                         payment methods, and transaction history. Used for prepaid shipping
     *                                                         and account-based payment processing.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string|Optional $phone,
        public readonly string|Optional $country,
        public readonly string|Optional $locale,
        public readonly bool|Optional $isBillingCustomer,
        public readonly array|Optional $businessEntity,
        public readonly array|Optional $wallet,
    ) {}
}
