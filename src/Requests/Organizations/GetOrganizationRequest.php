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
 * Retrieves a specific organization by its unique identifier.
 *
 * Fetches detailed information about an organization, including its name,
 * settings, members, and configuration.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetOrganizationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve an organization.
     *
     * @param string $id Unique identifier of the organization to retrieve
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for retrieving a specific organization.
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
     * @return OrganizationResponseData The deserialized organization data
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }
}
