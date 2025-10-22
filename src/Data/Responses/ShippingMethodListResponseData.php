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
 * Represents a collection of available shipping methods from the Shipit API.
 *
 * This data object wraps a collection of shipping method responses, typically
 * returned when querying available delivery options for a specific route or
 * retrieving the complete catalog of supported shipping services.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodListResponseData extends Data
{
    /**
     * Create a new shipping method list instance.
     *
     * @param DataCollection<int, ShippingMethodResponseData> $data Collection of shipping method data objects,
     *                                                              each representing a distinct delivery service
     *                                                              with its pricing, capabilities, and requirements.
     *                                                              The collection is indexed numerically and can be
     *                                                              filtered or sorted based on business logic needs.
     */
    public function __construct(
        #[DataCollectionOf(ShippingMethodResponseData::class)]
        public readonly DataCollection $data,
    ) {}
}
