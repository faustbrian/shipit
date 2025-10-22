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
 * Updates an existing organization's information.
 *
 * Modifies organization details such as name, settings, configuration,
 * or other attributes for a specific organization.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateOrganizationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     */
    protected Method $method = Method::PUT;

    /**
     * Create a new request to update an organization.
     *
     * @param string               $id   Unique identifier of the organization to update
     * @param array<string, mixed> $data Organization data to update, containing fields such as name,
     *                                   description, settings, or configuration changes
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating a specific organization.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->id;
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response                 $response The raw HTTP response from the API
     * @return OrganizationResponseData The updated organization data
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }

    /**
     * Define the request body containing the organization data to update.
     *
     * @return array<string, mixed> The organization update data
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
