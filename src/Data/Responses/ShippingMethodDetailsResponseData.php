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
 * Represents localized shipping method details from the Shipit API.
 *
 * This data object contains shipping method information with localized
 * strings for multiple languages, allowing display of service names,
 * descriptions, and other text in the user's preferred language.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodDetailsResponseData extends Data
{
    /**
     * Create a new shipping method details instance.
     *
     * @param string                         $serviceId  Unique identifier for the shipping service, used to reference
     *                                                   and select specific delivery methods across the Shipit platform.
     *                                                   This ID is used when creating shipments with this service.
     * @param array<string, string>|Optional $strings_fi localized strings in Finnish (fi) containing service names,
     *                                                   descriptions, and other text elements for displaying
     *                                                   the shipping method to Finnish-speaking users
     * @param array<string, string>|Optional $strings_en localized strings in English (en) containing service names,
     *                                                   descriptions, and other text elements for displaying
     *                                                   the shipping method to English-speaking users
     * @param array<string, string>|Optional $strings_sv localized strings in Swedish (sv) containing service names,
     *                                                   descriptions, and other text elements for displaying
     *                                                   the shipping method to Swedish-speaking users
     * @param array<string, string>|Optional $strings_et localized strings in Estonian (et) containing service names,
     *                                                   descriptions, and other text elements for displaying
     *                                                   the shipping method to Estonian-speaking users
     */
    public function __construct(
        public readonly string $serviceId,
        public readonly array|Optional $strings_fi,
        public readonly array|Optional $strings_en,
        public readonly array|Optional $strings_sv,
        public readonly array|Optional $strings_et,
    ) {}
}
