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
 * Retrieves available print template options.
 *
 * Fetches dynamic options for print templates including available carriers,
 * shipping methods for a given carrier, and supported print types for
 * carrier/service combinations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetPrintTemplateOptionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * HTTP method for this request.
     */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve print template options.
     *
     * @param null|string $carrier Optional carrier ID to filter shipping methods
     * @param null|string $service Optional service ID to filter print types
     */
    public function __construct(
        private readonly ?string $carrier = null,
        private readonly ?string $service = null,
    ) {}

    /**
     * Resolve the API endpoint for retrieving print template options.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/print-templates/options';
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response             $response The raw HTTP response from the API
     * @return array<string, mixed> The options data containing carriers, shipping_methods, and print_types
     */
    public function createDtoFromResponse(Response $response): array
    {
        /** @var array<string, mixed> */
        return $response->json('data');
    }

    /**
     * Define query parameters for filtering options.
     *
     * @return array<string, mixed> Query parameters to append to the request
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->carrier !== null) {
            $query['carrier'] = $this->carrier;
        }

        if ($this->service !== null) {
            $query['service'] = $this->service;
        }

        return $query;
    }
}
