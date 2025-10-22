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
 * Represents a consignment template API response.
 *
 * This data object wraps consignment template information returned
 * from the API. Templates allow users to save and reuse shipment
 * configurations, including addresses, package dimensions, service
 * preferences, and custom settings for frequently shipped routes.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ConsignmentTemplateResponseData extends Data
{
    /**
     * Create a new consignment template response data instance.
     *
     * @param mixed $data Template configuration in carrier-specific format. Structure varies by
     *                    carrier but typically includes template identifier, name, saved addresses
     *                    (origin and destination), package specifications, service types, special
     *                    handling instructions, and metadata. The mixed type provides flexibility
     *                    to accommodate different carrier template schemas and custom fields.
     */
    public function __construct(
        public readonly mixed $data,
    ) {}
}
