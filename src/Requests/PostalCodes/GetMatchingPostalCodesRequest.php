<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\PostalCodes;

use Cline\Shipit\Data\PostalCodeRequestData;
use Cline\Shipit\Data\Responses\PostalCodeResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves postal codes matching the provided search criteria.
 *
 * Searches for postal codes based on location parameters such as country,
 * city, region, or partial postal code patterns, returning matching results.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetMatchingPostalCodesRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Create a new request to retrieve matching postal codes.
     *
     * @param PostalCodeRequestData $data Search criteria containing location parameters such as country,
     *                                    city, region, or postal code pattern to match against
     */
    public function __construct(
        private readonly PostalCodeRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for searching postal codes.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/postal-codes';
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response               $response The raw HTTP response from the API
     * @return PostalCodeResponseData The matching postal code results
     */
    public function createDtoFromResponse(Response $response): PostalCodeResponseData
    {
        return PostalCodeResponseData::from($response->json());
    }

    /**
     * Define the request body containing the postal code search criteria.
     *
     * @return array<string, mixed> The search parameters serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
