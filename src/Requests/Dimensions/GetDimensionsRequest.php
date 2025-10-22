<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Dimensions;

use Cline\Shipit\Data\Responses\DimensionResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves all dimensions for the authenticated user.
 *
 * Fetches a list of dimension presets with optional filtering by type and service.
 * Returns paginated results with dimension measurements and configurations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetDimensionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve dimensions.
     *
     * @param null|string $type    Optional dimension type to filter results
     * @param null|string $service Optional service ID to filter dimensions
     */
    public function __construct(
        private readonly ?string $type = null,
        private readonly ?string $service = null,
    ) {}

    /**
     * Resolve the API endpoint for retrieving dimensions.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/dimensions';
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response              $response The raw HTTP response from the API
     * @return DimensionResponseData The deserialized dimensions collection data
     */
    public function createDtoFromResponse(Response $response): DimensionResponseData
    {
        return DimensionResponseData::from($response->json());
    }

    /**
     * Define query parameters for filtering dimensions.
     *
     * @return array<string, mixed> Query parameters to append to the request
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->type !== null) {
            $query['type'] = $this->type;
        }

        if ($this->service !== null) {
            $query['service'] = $this->service;
        }

        return $query;
    }
}
