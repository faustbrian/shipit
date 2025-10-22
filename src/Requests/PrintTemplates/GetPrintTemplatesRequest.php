<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\PrintTemplates;

use Cline\Shipit\Data\Responses\PrintTemplateResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves all print templates for the authenticated user.
 *
 * Fetches a list of print templates with optional filtering by carrier.
 * Returns paginated results with template configurations including
 * layout preferences and metadata.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetPrintTemplatesRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve print templates.
     *
     * @param null|string $carrier_id Optional carrier ID to filter templates
     */
    public function __construct(
        private readonly ?string $carrier_id = null,
    ) {}

    /**
     * Resolve the API endpoint for retrieving print templates.
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
     * @param  Response                  $response The raw HTTP response from the API
     * @return PrintTemplateResponseData The deserialized print templates collection data
     */
    public function createDtoFromResponse(Response $response): PrintTemplateResponseData
    {
        return PrintTemplateResponseData::from($response->json());
    }

    /**
     * Define query parameters for filtering print templates.
     *
     * @return array<string, mixed> Query parameters to append to the request
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->carrier_id !== null) {
            $query['carrier_id'] = $this->carrier_id;
        }

        return $query;
    }
}
