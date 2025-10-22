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
 * Represents organization member data in API responses.
 *
 * This data object encapsulates member information returned when querying
 * organization membership details. The flexible structure accommodates various
 * member data formats returned by different API endpoints.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class OrganizationMemberResponseData extends Data
{
    /**
     * Create a new organization member response data instance.
     *
     * @param mixed $data Flexible member data structure containing user information,
     *                    roles, permissions, and membership metadata. The mixed type
     *                    accommodates various API response formats including arrays,
     *                    objects, or nested data structures depending on the endpoint.
     */
    public function __construct(
        public readonly mixed $data,
    ) {}
}
