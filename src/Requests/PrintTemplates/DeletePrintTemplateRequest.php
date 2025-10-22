<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\PrintTemplates;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Deletes an existing print template.
 *
 * Removes a print template from the authenticated user's configuration.
 * Requires the template to be owned by the current user.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeletePrintTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::DELETE;

    /**
     * Create a new request to delete a print template.
     *
     * @param string $id The unique identifier of the print template to delete
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for deleting a print template.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/print-templates/'.$this->id;
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
