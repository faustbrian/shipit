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
 * Represents a carrier contract API response.
 *
 * This data object wraps carrier contract information returned from
 * the API. Contracts define negotiated rates, service levels, and
 * terms between the shipper and carrier. The flexible structure
 * accommodates various contract formats across different carriers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CarrierContractResponseData extends Data
{
    /**
     * Create a new carrier contract response data instance.
     *
     * @param mixed $data Contract details in carrier-specific format. Structure varies by carrier
     *                    but typically includes contract identifiers, rate schedules, service
     *                    level agreements, validity periods, discount structures, and terms and
     *                    conditions. The mixed type accommodates different carrier API schemas
     *                    while maintaining type safety at runtime through Spatie Data casting.
     */
    public function __construct(
        public readonly mixed $data,
    ) {}
}
