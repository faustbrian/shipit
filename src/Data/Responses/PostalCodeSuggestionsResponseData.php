<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data\Responses;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Represents a collection of postal code suggestions.
 *
 * This data object encapsulates multiple postal code results returned when
 * searching or validating postal codes. Used for autocomplete features and
 * address validation flows where multiple matches may exist for ambiguous input.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class PostalCodeSuggestionsResponseData extends Data
{
    /**
     * Create a new postal code suggestions response.
     *
     * @param DataCollection<int, PostalCodeResponseData> $suggestions Collection of postal code matches
     *                                                                 with associated geographic information.
     *                                                                 Each suggestion represents a valid postal
     *                                                                 code that matches the user's query, ordered
     *                                                                 by relevance or geographic proximity for
     *                                                                 optimal user selection experience.
     */
    public function __construct(
        #[DataCollectionOf(PostalCodeResponseData::class)]
        public readonly DataCollection $suggestions,
    ) {}
}
