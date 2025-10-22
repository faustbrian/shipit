<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\User;

use Cline\Shipit\Data\Responses\UserResponseData;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Retrieves the authenticated user's profile information.
 *
 * Fetches the complete user profile for the currently authenticated user, including
 * account details, preferences, and permissions. Requires valid authentication credentials.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetCurrentUserRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for retrieving the current user.
     *
     * @return string The current user profile endpoint path
     */
    public function resolveEndpoint(): string
    {
        return '/v1/users/me';
    }

    /**
     * Transform the API response into a typed data object.
     *
     * @param  Response         $response The HTTP response from the user profile endpoint
     * @return UserResponseData The authenticated user's profile data
     */
    public function createDtoFromResponse(Response $response): UserResponseData
    {
        return UserResponseData::from($response->json('data'));
    }
}
