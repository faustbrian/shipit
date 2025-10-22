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
 * Creates a new print template or updates an existing one.
 *
 * Stores print template configuration for a specific carrier and service combination.
 * Supports wildcard matching for applying templates to all carriers or services.
 * Includes metadata for advanced print options.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreatePrintTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Create a new request to create a print template.
     *
     * @param array<string, mixed> $data Print template data containing:
     *                                   - carrier: string (required) - Carrier ID or "*" for all
     *                                   - service: string (required unless carrier is "*") - Service ID or "*" for all
     *                                   - layout: string (required) - Print layout type
     *                                   - enforce_to_size: bool (optional) - Enforce print size
     *                                   - remove_fedex_awb: bool (optional) - Remove FedEx AWB
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating a print template.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/print-templates';
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
     * Define the request body containing the print template data.
     *
     * @return array<string, mixed> The print template data to submit
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
