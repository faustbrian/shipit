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
 * Represents an API response containing multiple agent locations.
 *
 * This data object wraps a collection of agent locations returned from
 * agent search or lookup operations. Used when querying for available
 * service points, pickup locations, or drop-off facilities within a
 * geographic area or for specific carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class AgentsResponseData extends Data
{
    /**
     * Create a new agents response data instance.
     *
     * @param int                                    $status    HTTP status code indicating the result of the agent lookup request.
     *                                                          Success typically returns 200, while errors return appropriate HTTP
     *                                                          error codes (e.g., 404 for no agents found, 400 for invalid parameters).
     * @param DataCollection<int, AgentResponseData> $locations Collection of agent location objects
     *                                                          matching the search criteria. May be
     *                                                          empty if no agents are available in the
     *                                                          requested area. Agents are typically
     *                                                          sorted by distance or relevance.
     */
    public function __construct(
        public readonly int $status,
        #[DataCollectionOf(AgentResponseData::class)]
        public readonly DataCollection $locations,
    ) {}
}
