<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Dimensions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a new dimension preset.
 *
 * Stores a dimension configuration with measurements and optional
 * service associations. Supports both predefined and custom dimension types.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateDimensionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Create a new request to create a dimension.
     *
     * @param array<string, mixed> $data Dimension data containing:
     *                                   - type: string (required) - Dimension type enum value
     *                                   - name: string (optional) - Name for the dimension preset
     *                                   - service: string (optional, required unless type is 'predefined')
     *                                   - parcel_type: string (optional) - Parcel type enum value
     *                                   - length: numeric (required) - Length measurement
     *                                   - width: numeric (required) - Width measurement
     *                                   - height: numeric (required) - Height measurement
     *                                   - weight: numeric (required) - Weight measurement
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating a dimension.
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
     * @param Response $response The raw HTTP response from the API
     */
    public function createDtoFromResponse(Response $response): void
    {
        // No content returned
    }

    /**
     * Define the request body containing the dimension data.
     *
     * @return array<string, mixed> The dimension data to submit
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
