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
 * Represents API error response data.
 *
 * This data object encapsulates error information returned by the Shipit API
 * when requests fail. It provides structured error details including error codes,
 * human-readable messages, and additional error metadata for debugging and
 * user-facing error handling.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ErrorResponseData extends Data
{
    /**
     * Create a new error response data instance.
     *
     * @param int|string                    $code      Error code identifying the type of error that occurred.
     *                                                 Can be numeric (HTTP status codes) or string (custom error codes)
     *                                                 used for programmatic error handling and logging purposes.
     * @param string                        $message   Human-readable error message describing what went wrong.
     *                                                 Provides context about the error for end-users and developers,
     *                                                 suitable for display in user interfaces or log files.
     * @param array<string, mixed>|Optional $errordata Additional structured error context and metadata.
     *                                                 Contains detailed information about the error condition,
     *                                                 such as validation failures, field-specific errors, or
     *                                                 debugging information to help diagnose the issue.
     * @param array<int, string>|Optional   $messages  Collection of multiple error messages when the error
     *                                                 affects multiple fields or contains multiple validation
     *                                                 failures. Each message provides specific details about
     *                                                 individual error conditions within the same request.
     */
    public function __construct(
        public readonly string|int $code,
        public readonly string $message,
        public readonly array|Optional $errordata,
        public readonly array|Optional $messages,
    ) {}
}
