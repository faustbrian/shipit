<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data\Responses;

use Spatie\LaravelData\Data;

/**
 * Represents the response data for country information retrieval.
 *
 * This data object encapsulates a list of countries returned by the API,
 * typically used for populating country selection dropdowns or validating
 * shipping destinations in the Shipit SDK.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CountryInfoResponseData extends Data
{
    /**
     * Create a new country information response.
     *
     * @param array<int, array<string, mixed>> $countries Collection of country data objects containing
     *                                                    country codes, names, and shipping availability
     *                                                    information. Each country entry includes metadata
     *                                                    such as ISO codes, localized names, and supported
     *                                                    shipping carriers for destination validation.
     */
    public function __construct(
        public readonly array $countries,
    ) {}
}
