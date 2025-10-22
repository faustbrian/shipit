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
 * Represents quick shipping methods response with available carriers and services.
 *
 * This data object encapsulates the API response for quick shipping method lookups,
 * including all available shipping options, their details, and user preferences.
 * Used to populate shipping method selection interfaces with carrier options and
 * highlight frequently used services for improved user experience.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class QuickShippingMethodsResponseData extends Data
{
    /**
     * Create a new quick shipping methods response.
     *
     * @param int                                             $status   HTTP status code or response status indicator
     *                                                                  representing the success or failure state of
     *                                                                  the shipping methods lookup operation
     * @param DataCollection<int, ShippingMethodResponseData> $methods  Collection of available shipping methods and
     *                                                                  carrier services with pricing, transit times,
     *                                                                  and service details. Each method represents
     *                                                                  a distinct carrier and service level combination
     *                                                                  available for the requested route.
     * @param array<int, mixed>                               $mostUsed List of frequently used shipping methods based
     *                                                                  on the user's shipping history. Used to surface
     *                                                                  preferred carriers at the top of selection lists
     *                                                                  and streamline the shipping workflow.
     */
    public function __construct(
        public readonly int $status,
        #[DataCollectionOf(ShippingMethodResponseData::class)]
        public readonly DataCollection $methods,
        public readonly array $mostUsed,
    ) {}
}
