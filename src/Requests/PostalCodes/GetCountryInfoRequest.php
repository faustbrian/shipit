<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\PostalCodes;

use Cline\Shipit\Data\Responses\CountryInfoResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves comprehensive postal code information for all supported countries.
 *
 * Fetches country-specific postal code metadata, including format patterns,
 * validation rules, and regional postal code structures.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetCountryInfoRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for retrieving country postal code information.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/postalcode/country-info';
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response                $response The raw HTTP response from the API
     * @return CountryInfoResponseData The deserialized country postal code information
     */
    public function createDtoFromResponse(Response $response): CountryInfoResponseData
    {
        return CountryInfoResponseData::from($response->json());
    }
}
