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
use Spatie\LaravelData\Optional;

/**
 * Represents the complete API response when querying available shipping methods.
 *
 * This data object encapsulates the full response from the shipping methods endpoint,
 * including available delivery options, optional service point locations for pickup
 * methods, and cart-related identifiers for e-commerce integrations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodsResponseData extends Data
{
    /**
     * Create a new shipping methods response instance.
     *
     * @param int                                                    $status     HTTP status code indicating the success or failure of the shipping
     *                                                                           methods query. Standard codes: 200 for success, 400 for validation
     *                                                                           errors (e.g., invalid address), 500 for server errors.
     * @param DataCollection<int, ShippingMethodResponseData>        $methods    Collection of available shipping method options
     *                                                                           for the specified route and package parameters.
     *                                                                           Each method includes pricing, carrier details,
     *                                                                           and service capabilities. The collection may be
     *                                                                           empty if no methods are available for the route.
     * @param DataCollection<int, ServicePointLocationData>|Optional $locations  Collection of service point locations (parcel
     *                                                                           lockers, pickup points, stores) available for
     *                                                                           pickup-based shipping methods. Only present when
     *                                                                           at least one method requires location selection.
     * @param Optional|string                                        $cartId     Shopping cart identifier linking this shipping method query
     *                                                                           to a specific cart session. Used to maintain state across
     *                                                                           multi-step checkout flows in e-commerce integrations.
     * @param Optional|string                                        $cartItemId specific cart item identifier when querying shipping methods
     *                                                                           for individual products or line items within a shopping cart
     * @param Optional|string                                        $error      Error message or error code when the shipping methods query fails.
     *                                                                           Contains details about validation failures, unavailable routes,
     *                                                                           or system errors that prevented method calculation.
     */
    public function __construct(
        public readonly int $status,
        #[DataCollectionOf(ShippingMethodResponseData::class)]
        public readonly DataCollection $methods,
        #[DataCollectionOf(ServicePointLocationData::class)]
        public readonly DataCollection|Optional $locations,
        public readonly string|Optional $cartId,
        public readonly string|Optional $cartItemId,
        public readonly string|Optional $error,
    ) {}
}
