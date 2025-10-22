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
 * Represents organization data in API responses.
 *
 * This data object encapsulates complete organization information including
 * identification, descriptive details, configuration settings, and audit timestamps.
 * Used throughout the Shipit SDK for managing multi-tenant organization structures
 * and organization-specific configurations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class OrganizationResponseData extends Data
{
    /**
     * Create a new organization response data instance.
     *
     * @param int|string                    $id          Unique identifier for this organization within the system.
     *                                                   Can be numeric database ID or string UUID depending on
     *                                                   the backend implementation and data model design.
     * @param string                        $name        organization name used for display and identification purposes
     *                                                   throughout the application interface, such as "Acme Corp" or
     *                                                   "Downtown Shipping Co"
     * @param Optional|string               $description Optional detailed description of the organization's purpose,
     *                                                   business type, or operational notes. Provides additional context
     *                                                   for administrative users and multi-organization management.
     * @param array<string, mixed>|Optional $settings    Organization-specific configuration settings and preferences
     *                                                   that control features, behavior, and defaults for this
     *                                                   organization. May include shipping preferences, branding
     *                                                   options, API keys, and feature flags.
     * @param Optional|string               $created_at  timestamp when this organization record was created in the system,
     *                                                   typically in ISO 8601 format for tracking account age and
     *                                                   auditing purposes
     * @param Optional|string               $updated_at  timestamp of the most recent update to this organization record,
     *                                                   used for change tracking, cache invalidation, and data
     *                                                   synchronization between systems
     */
    public function __construct(
        public readonly string|int $id,
        public readonly string $name,
        public readonly string|Optional $description,
        public readonly array|Optional $settings,
        public readonly string|Optional $created_at,
        public readonly string|Optional $updated_at,
    ) {}
}
