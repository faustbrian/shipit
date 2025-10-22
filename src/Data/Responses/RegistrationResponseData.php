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
 * Represents user registration response data.
 *
 * This data object encapsulates the API response for user registration operations,
 * including the registration status, optional success or error messages, newly
 * created user details, and authentication token for immediate session establishment.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class RegistrationResponseData extends Data
{
    /**
     * Create a new registration response data instance.
     *
     * @param int                       $status  HTTP status code or registration status indicator
     *                                           representing success, validation failure, or error
     *                                           conditions during the registration process
     * @param Optional|string           $message Optional human-readable message providing feedback
     *                                           about the registration result. Contains success
     *                                           confirmation or error details to display to users
     *                                           or log for debugging purposes.
     * @param Optional|UserResponseData $user    Newly created user data object containing profile
     *                                           information for the registered user. Present on
     *                                           successful registration and used to populate user
     *                                           interfaces and establish the user session.
     * @param Optional|string           $token   Authentication token (JWT or API token) issued to
     *                                           the newly registered user for immediate authentication.
     *                                           Enables seamless login after registration without
     *                                           requiring a separate login step.
     */
    public function __construct(
        public readonly int $status,
        public readonly string|Optional $message,
        public readonly UserResponseData|Optional $user,
        public readonly string|Optional $token,
    ) {}
}
