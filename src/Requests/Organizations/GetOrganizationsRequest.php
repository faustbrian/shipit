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
 * Retrieves all organizations accessible to the authenticated user.
 *
 * Fetches a complete list of organizations, including their basic information,
 * settings, and associated metadata.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetOrganizationsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     */
    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for retrieving all organizations.
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
     * @return OrganizationResponseData The deserialized organizations collection data
     */
    public function createDtoFromResponse(Response $response): OrganizationResponseData
    {
        return OrganizationResponseData::from($response->json());
    }
}
