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
 * Represents an account balance API response.
 *
 * This data object wraps balance information returned from the API.
 * The flexible structure accommodates various balance formats and
 * details provided by different carriers or account types, including
 * current balance, credit limits, and transaction history.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BalanceResponseData extends Data
{
    /**
     * Create a new balance response data instance.
     *
     * @param mixed $data Balance information in carrier-specific format. Structure varies by
     *                    carrier but typically includes current balance amounts, available
     *                    credit, currency, and may include additional details such as pending
     *                    charges, credit limits, or historical transaction summaries. The mixed
     *                    type allows flexibility for different carrier API response formats.
     */
    public function __construct(
        public readonly mixed $data,
    ) {}
}
