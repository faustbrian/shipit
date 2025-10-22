<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\RegistrationRequestData;
use Cline\Shipit\Data\Responses\RegistrationResponseData;
use Cline\Shipit\Data\Responses\UserResponseData;
use Cline\Shipit\Requests\User\GetCurrentUserRequest;
use Cline\Shipit\Requests\User\RegisterRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * User resource for user account management.
 *
 * Provides user-related operations including retrieving the currently
 * authenticated user's profile and registering new user accounts.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UserResource extends BaseResource
{
    /**
     * Retrieve the currently authenticated user's profile information.
     *
     * Returns the complete user profile including account details,
     * preferences, and organization memberships for the authenticated user.
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return UserResponseData The current user's profile data
     */
    public function current(): UserResponseData
    {
        /** @var UserResponseData */
        return $this->connector
            ->send(
                new GetCurrentUserRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Register a new user account.
     *
     * Creates a new user account with the provided registration information
     * including email, password, and profile details.
     *
     * @param RegistrationRequestData $data User registration details
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return RegistrationResponseData The newly created user account with authentication token
     */
    public function register(RegistrationRequestData $data): RegistrationResponseData
    {
        /** @var RegistrationResponseData */
        return $this->connector
            ->send(
                new RegisterRequest($data),
            )
            ->dtoOrFail();
    }
}
