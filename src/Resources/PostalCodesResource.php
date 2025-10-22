<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\PostalCodeRequestData;
use Cline\Shipit\Data\Responses\CountryInfoResponseData;
use Cline\Shipit\Data\Responses\PostalCodeResponseData;
use Cline\Shipit\Data\Responses\PostalCodeSuggestionsResponseData;
use Cline\Shipit\Requests\PostalCodes\GetCountryInfoRequest;
use Cline\Shipit\Requests\PostalCodes\GetMatchingPostalCodesRequest;
use Cline\Shipit\Requests\PostalCodes\GetPostalCodeSuggestionsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Postal codes resource for address validation and lookup operations.
 *
 * Provides functionality for matching postal codes, retrieving postal code
 * suggestions for autocomplete, and accessing country-specific postal code
 * information and formatting rules.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PostalCodesResource extends BaseResource
{
    /**
     * Find postal codes matching the provided search criteria.
     *
     * Validates and returns matching postal codes based on country, postal code,
     * city, or street address information for accurate address verification.
     *
     * @param PostalCodeRequestData $data Search criteria including country code and postal code
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return PostalCodeResponseData Matching postal code results with location details
     */
    public function match(PostalCodeRequestData $data): PostalCodeResponseData
    {
        /** @var PostalCodeResponseData */
        return $this->connector
            ->send(
                new GetMatchingPostalCodesRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve postal code suggestions for autocomplete functionality.
     *
     * Returns a list of postal code suggestions based on partial input,
     * useful for implementing address autocomplete in forms.
     *
     * @param array<string, mixed> $query Optional query parameters to filter suggestions
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return PostalCodeSuggestionsResponseData List of suggested postal codes
     */
    public function suggestions(array $query = []): PostalCodeSuggestionsResponseData
    {
        /** @var PostalCodeSuggestionsResponseData */
        return $this->connector
            ->send(
                new GetPostalCodeSuggestionsRequest($query),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve country-specific postal code information and formatting rules.
     *
     * Returns metadata about postal code formats, validation rules, and
     * addressing standards for different countries.
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return CountryInfoResponseData Country postal code information and formatting rules
     */
    public function countryInfo(): CountryInfoResponseData
    {
        /** @var CountryInfoResponseData */
        return $this->connector
            ->send(
                new GetCountryInfoRequest(),
            )
            ->dtoOrFail();
    }
}
