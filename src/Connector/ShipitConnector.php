<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Connector;

use Cline\Shipit\Resources\AgentsResource;
use Cline\Shipit\Resources\BalanceResource;
use Cline\Shipit\Resources\CarrierContractsResource;
use Cline\Shipit\Resources\ConsignmentTemplatesResource;
use Cline\Shipit\Resources\LocationsResource;
use Cline\Shipit\Resources\OrganizationMembersResource;
use Cline\Shipit\Resources\OrganizationsResource;
use Cline\Shipit\Resources\PostalCodesResource;
use Cline\Shipit\Resources\ShipmentsResource;
use Cline\Shipit\Resources\ShippingMethodsResource;
use Cline\Shipit\Resources\TrackingResource;
use Cline\Shipit\Resources\UserResource;
use Illuminate\Support\Facades\App;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

/**
 * Main connector for the Shipit API.
 *
 * Provides access to all Shipit API resources through resource methods.
 * Handles authentication, base URL configuration, and default headers
 * for all API requests.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShipitConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;

    /**
     * Create a new Shipit API connector instance.
     *
     * @param string $apiToken API authentication token for Shipit API requests
     * @param string $baseUrl  Custom base URL for API requests
     */
    private function __construct(
        private readonly string $apiToken,
        private readonly string $baseUrl,
    ) {}

    public static function new(string $apiToken): self
    {
        if (App::isProduction()) {
            return new self($apiToken, 'https://api.shipit.fi');
        }

        return new self($apiToken, 'https://apitest.shipit.ax');
    }

    public static function live(string $apiToken): self
    {
        return new self($apiToken, 'https://api.shipit.ax');
    }

    public static function test(string $apiToken): self
    {
        return new self($apiToken, 'https://apitest.shipit.ax');
    }

    /**
     * Resolve the base URL for API requests.
     *
     * Uses the provided base URL, falls back to configuration, or defaults
     * to the production API endpoint.
     *
     * @return string The resolved base URL
     */
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Determine if an API request has failed based on HTTP status code.
     *
     * @param  Response $response The HTTP response to check
     * @return bool     True if status code is 400 or higher, false otherwise
     */
    public function hasRequestFailed(Response $response): bool
    {
        return $response->status() >= 400;
    }

    /**
     * Access shipping methods resource for retrieving available carriers and services.
     */
    public function shippingMethods(): ShippingMethodsResource
    {
        return new ShippingMethodsResource($this);
    }

    /**
     * Access shipments resource for creating, managing, and tracking shipments.
     */
    public function shipments(): ShipmentsResource
    {
        return new ShipmentsResource($this);
    }

    /**
     * Access balance resource for checking account balance and credit information.
     */
    public function balance(): BalanceResource
    {
        return new BalanceResource($this);
    }

    /**
     * Access agents resource for managing pickup and delivery agent locations.
     */
    public function agents(): AgentsResource
    {
        return new AgentsResource($this);
    }

    /**
     * Access locations resource for managing sender and receiver address locations.
     */
    public function locations(): LocationsResource
    {
        return new LocationsResource($this);
    }

    /**
     * Access organizations resource for managing organization settings and information.
     */
    public function organizations(): OrganizationsResource
    {
        return new OrganizationsResource($this);
    }

    /**
     * Access postal codes resource for validating and looking up postal code information.
     */
    public function postalCodes(): PostalCodesResource
    {
        return new PostalCodesResource($this);
    }

    /**
     * Access tracking resource for retrieving shipment tracking information.
     */
    public function tracking(): TrackingResource
    {
        return new TrackingResource($this);
    }

    /**
     * Access user resource for managing user account information and settings.
     */
    public function user(): UserResource
    {
        return new UserResource($this);
    }

    /**
     * Access carrier contracts resource for managing shipping carrier agreements.
     */
    public function carrierContracts(): CarrierContractsResource
    {
        return new CarrierContractsResource($this);
    }

    /**
     * Access consignment templates resource for managing reusable shipment templates.
     */
    public function consignmentTemplates(): ConsignmentTemplatesResource
    {
        return new ConsignmentTemplatesResource($this);
    }

    /**
     * Access organization members resource for managing team members and permissions.
     */
    public function organizationMembers(): OrganizationMembersResource
    {
        return new OrganizationMembersResource($this);
    }

    /**
     * Configure token-based authentication for API requests.
     *
     * @return TokenAuthenticator The configured token authenticator
     */
    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiToken);
    }

    /**
     * Define default headers for all API requests.
     *
     * @return array<string, string> Array of default HTTP headers
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }
}
