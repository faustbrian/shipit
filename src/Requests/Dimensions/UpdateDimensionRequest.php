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
 * Updates an existing dimension preset.
 *
 * Modifies dimension configuration for the specified dimension ID.
 * Requires the dimension to be owned by the current user.
 * All fields are optional for partial updates.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateDimensionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * Create a new request to update a dimension.
     *
     * @param string               $id   The unique identifier of the dimension to update
     * @param array<string, mixed> $data Dimension data to update (all fields optional):
     *                                   - type: string - Dimension type enum value
     *                                   - name: string - Name for the dimension preset
     *                                   - service: string - Service ID
     *                                   - parcel_type: string - Parcel type enum value
     *                                   - length: numeric - Length measurement
     *                                   - width: numeric - Width measurement
     *                                   - height: numeric - Height measurement
     *                                   - weight: numeric - Weight measurement
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating a dimension.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/dimensions/'.$this->id;
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
     * Define the request body containing the dimension update data.
     *
     * @return array<string, mixed> The dimension data to submit
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
