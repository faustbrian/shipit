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
 * Represents a user registration request.
 *
 * This data object encapsulates the information required to create
 * a new user account in the shipping platform. All fields are required
 * for successful registration and account provisioning.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class RegistrationRequestData extends Data
{
    /**
     * Create a new registration request data instance.
     *
     * @param string $email    Valid email address for the user account. Used for login authentication,
     *                         account verification, and communication. Must be unique within the
     *                         platform and follow standard email format validation.
     * @param string $password User's chosen password for account security. Should meet minimum
     *                         security requirements such as length and complexity as defined by
     *                         the platform's security policy.
     * @param string $name     Full name or company name of the user registering for the account.
     *                         Used for account identification, shipping documentation, and customer
     *                         service interactions.
     * @param string $phone    Contact phone number for the user account. Used for account verification,
     *                         two-factor authentication, and shipment notifications. Should include
     *                         country code for international users.
     * @param string $country  ISO 3166-1 alpha-2 country code (e.g., "US", "GB", "DE") representing
     *                         the user's country of operation. Determines available shipping services,
     *                         pricing, and regional settings for the account.
     */
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $name,
        public readonly string $phone,
        public readonly string $country,
    ) {}
}
