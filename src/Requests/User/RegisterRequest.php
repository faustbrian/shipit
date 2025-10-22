<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\User;

use Cline\Shipit\Data\RegistrationRequestData;
use Cline\Shipit\Data\Responses\RegistrationResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Registers a new user account in the system.
 *
 * Creates a new user account with the provided registration details including credentials,
 * contact information, and initial preferences. Returns authentication tokens and user
 * profile upon successful registration.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class RegisterRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * Create a new user registration request instance.
     *
     * @param RegistrationRequestData $data User registration information including required
     *                                      credentials (email, password), personal details (name,
     *                                      company), contact information, and optional preferences
     *                                      or settings. All data is validated against registration
     *                                      requirements before account creation.
     */
    public function __construct(
        private readonly RegistrationRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for user registration.
     *
     * @return string The user registration endpoint path
     */
    public function resolveEndpoint(): string
    {
        return '/v1/register';
    }

    /**
     * Transform the API response into a typed data object.
     *
     * @param  Response                 $response The HTTP response from the registration endpoint
     * @return RegistrationResponseData New user account details and authentication tokens
     */
    public function createDtoFromResponse(Response $response): RegistrationResponseData
    {
        return RegistrationResponseData::from($response->json());
    }

    /**
     * Build the request body containing registration details.
     *
     * @return array<string, mixed> User registration data for account creation
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
