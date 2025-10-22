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

    /**
     * HTTP method for creating a new organization.
     */
    protected Method $method = Method::POST;

    /**
     * Create a new request to create an organization.
     *
     * @param array<string, mixed> $data Organization data containing required fields such as name,
     *                                   description, and configuration settings. Typical fields include
     *                                   organization name, contact information, billing details, and
     *                                   operational preferences for the new organization account.
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating an organization.
     *
     * @return string The endpoint path for the POST request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations';
    }

    /**
     * Transform the API response into a structured OrganizationResponseData object.
     *
     * @param  Response                 $response The HTTP response containing the newly created organization data in JSON format
     * @return OrganizationResponseData Typed data object containing the created organization details including assigned ID
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the new organization data.
     *
     * @return array<string, mixed> The organization data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
