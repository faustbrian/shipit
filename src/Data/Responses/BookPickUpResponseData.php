<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Data\Responses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

/**
 * Represents a pickup booking API response.
 *
 * This data object encapsulates the result of scheduling a carrier
 * pickup for one or more shipments. Returns confirmation details on
 * success or error messages on failure, enabling clients to handle
 * pickup scheduling outcomes appropriately.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BookPickUpResponseData extends Data
{
    /**
     * Create a new book pickup response data instance.
     *
     * @param int             $status   HTTP status code indicating the pickup booking result. Success returns
     *                                  200 or 201, while failures return error codes such as 400 for invalid
     *                                  requests, 409 for scheduling conflicts, or 500 for server errors.
     * @param Optional|string $pickupId Unique identifier assigned to the scheduled pickup. Used for
     *                                  tracking, modification, or cancellation of the pickup request.
     *                                  Present only when the pickup is successfully scheduled.
     * @param Optional|string $message  Human-readable message describing the booking result. Provides
     *                                  success confirmation or detailed error information explaining
     *                                  why the pickup could not be scheduled (e.g., invalid address,
     *                                  no availability, outside service area).
     */
    public function __construct(
        public readonly int $status,
        public readonly string|Optional $pickupId,
        public readonly string|Optional $message,
    ) {}
}
