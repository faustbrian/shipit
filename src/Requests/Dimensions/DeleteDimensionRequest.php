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
 * Deletes an existing dimension preset.
 *
 * Removes a dimension from the authenticated user's configuration.
 * Requires the dimension to be owned by the current user.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteDimensionRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    /**
     * Create a new request to delete a dimension.
     *
     * @param string $id The unique identifier of the dimension to delete
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for deleting a dimension.
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
}
