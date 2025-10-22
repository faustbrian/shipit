<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Locations;

use Cline\Shipit\Data\Responses\LocationResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a new location for the authenticated account.
 *
 * Locations represent physical addresses used for shipping operations, such as
 * warehouses, retail stores, or fulfillment centers. Each location stores address
 * details, contact information, and operational settings that can be referenced
 * when creating shipments or managing inventory.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateLocationRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for creating a new location */
    protected Method $method = Method::POST;

    /**
     * Create a new request to add a location.
     *
     * @param array<string, mixed> $data Location data including address details, contact information,
     *                                   and operational settings. Required fields typically include
     *                                   name, address components (street, city, state, postal code,
     *                                   country), and may include phone, email, and business hours.
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for creating a new location.
     *
     * @return string The endpoint path for the POST request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/locations';
    }

    /**
     * Transform the API response into a structured LocationResponseData object.
     *
     * @param  Response             $response The HTTP response containing the newly created location data in JSON format
     * @return LocationResponseData Typed data object containing the created location details including assigned ID
     */
    public function createDtoFromResponse(Response $response): LocationResponseData
    {
        return LocationResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the new location data.
     *
     * @return array<string, mixed> The location data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
