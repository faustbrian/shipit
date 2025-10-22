<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Organizations;

use Cline\Shipit\Data\Responses\OrganizationResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a new organization in the system.
 *
 * Registers a new organization with the provided details, including name,
 * settings, and initial configuration.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateOrganizationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Create a new request to create an organization.
     *
     * @param array<string, mixed> $data Organization data containing fields such as name, description,
     *                                   and configuration settings required for creating the organization
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating an organization.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations';
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response                 $response The raw HTTP response from the API
     * @return OrganizationResponseData The newly created organization data
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }

    /**
     * Define the request body containing the organization creation data.
     *
     * @return array<string, mixed> The organization data to submit
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
