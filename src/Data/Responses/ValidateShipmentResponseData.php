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
 * Represents the validation result for a shipment request from the Shipit API.
 *
 * This data object contains the outcome of shipment validation, including
 * validation status, any errors that would prevent shipment creation, and
 * warnings about potential issues that don't block shipment processing.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ValidateShipmentResponseData extends Data
{
    /**
     * Create a new validate shipment response instance.
     *
     * @param int                                       $status   HTTP status code indicating the validation request result. Standard
     *                                                            codes: 200 for successful validation (regardless of valid/invalid
     *                                                            shipment), 400 for malformed requests, 500 for server errors.
     * @param bool                                      $valid    Indicates whether the shipment data passes all validation rules and
     *                                                            can be successfully created. When true, the shipment can proceed to
     *                                                            creation. When false, the errors array contains blocking issues that
     *                                                            must be resolved before shipment creation.
     * @param array<int, array<string, mixed>>|Optional $errors   Collection of validation errors that prevent shipment creation.
     *                                                            Each error contains a field identifier, error code, and
     *                                                            human-readable message. Present only when valid is false.
     *                                                            Common errors include invalid addresses, missing required
     *                                                            fields, or unsupported service configurations.
     * @param array<int, array<string, mixed>>|Optional $warnings Collection of validation warnings about potential issues that
     *                                                            don't prevent shipment creation but may affect delivery or
     *                                                            cost. Examples include unverified addresses, suboptimal
     *                                                            package dimensions, or missing optional information that
     *                                                            could improve delivery success rates.
     */
    public function __construct(
        public readonly int $status,
        public readonly bool $valid,
        public readonly array|Optional $errors,
        public readonly array|Optional $warnings,
    ) {}
}
