<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\PostalCodes;

use Cline\Shipit\Data\Responses\PostalCodeSuggestionsResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves postal code suggestions from the Shipit API.
 *
 * This request queries the postal code suggestions endpoint to retrieve
 * location data based on partial postal code input. Useful for implementing
 * autocomplete functionality in address forms or validating postal codes
 * during shipment creation workflows.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetPostalCodeSuggestionsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for this request */
    protected Method $method = Method::GET;

    /**
     * Create a new postal code suggestions request.
     *
     * @param array<string, mixed> $queryParams Query parameters for filtering postal code suggestions.
     *                                          Typically includes partial postal code strings, country codes,
     *                                          or region filters to narrow down the suggestion results
     *                                          returned by the API endpoint.
     */
    public function __construct(
        private readonly array $queryParams = [],
    ) {}

    /**
     * Resolve the API endpoint for postal code suggestions.
     *
     * @return string The endpoint path for retrieving postal code suggestions
     */
    public function resolveEndpoint(): string
    {
        return '/postalcode/suggestions';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                          $response The HTTP response from the Shipit API
     * @return PostalCodeSuggestionsResponseData Structured postal code suggestions data
     */
    public function createDtoFromResponse(Response $response): PostalCodeSuggestionsResponseData
    {
        return PostalCodeSuggestionsResponseData::from($response->json());
    }

    /**
     * Provide default query parameters for the request.
     *
     * @return array<string, mixed> Query parameters configured during request construction
     */
    protected function defaultQuery(): array
    {
        return $this->queryParams;
    }
}
