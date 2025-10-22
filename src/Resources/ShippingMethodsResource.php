<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\QuickShippingMethodsResponseData;
use Cline\Shipit\Data\Responses\ShippingMethodDetailsResponseData;
use Cline\Shipit\Data\Responses\ShippingMethodListResponseData;
use Cline\Shipit\Data\Responses\ShippingMethodsResponseData;
use Cline\Shipit\Data\ShippingMethodsRequestData;
use Cline\Shipit\Requests\ShippingMethods\GetQuickShippingMethodsRequest;
use Cline\Shipit\Requests\ShippingMethods\GetShippingMethodDetailsRequest;
use Cline\Shipit\Requests\ShippingMethods\GetShippingMethodListRequest;
use Cline\Shipit\Requests\ShippingMethods\GetShippingMethodsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;

/**
 * Shipping methods resource for carrier service rate retrieval.
 *
 * Provides access to available shipping methods, carrier services, and
 * rate calculations. Includes functionality for retrieving comprehensive
 * shipping options, quick rates, service details, and complete carrier lists.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ShippingMethodsResource extends BaseResource
{
    /**
     * Retrieve available shipping methods with rates for a shipment.
     *
     * Calculates shipping rates from multiple carriers based on shipment
     * parameters including origin, destination, package dimensions, and weight.
     * Returns comprehensive pricing and service options.
     *
     * @param ShippingMethodsRequestData $data Shipment details for rate calculation
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShippingMethodsResponseData Available shipping methods with rates and delivery estimates
     */
    public function get(ShippingMethodsRequestData $data): ShippingMethodsResponseData
    {
        /** @var ShippingMethodsResponseData */
        return $this->connector
            ->send(
                new GetShippingMethodsRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a complete list of all available shipping carriers and services.
     *
     * Returns the full catalog of shipping methods supported by the platform,
     * useful for displaying available options or filtering carriers.
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShippingMethodListResponseData Complete list of carriers and service levels
     */
    public function list(): ShippingMethodListResponseData
    {
        /** @var ShippingMethodListResponseData */
        return $this->connector
            ->send(
                new GetShippingMethodListRequest(),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve detailed information about a specific shipping service.
     *
     * Returns comprehensive details about a specific carrier service including
     * capabilities, restrictions, and service-level information.
     *
     * @param string $serviceId The unique identifier of the shipping service
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return ShippingMethodDetailsResponseData Detailed service information and capabilities
     */
    public function details(string $serviceId): ShippingMethodDetailsResponseData
    {
        /** @var ShippingMethodDetailsResponseData */
        return $this->connector
            ->send(
                new GetShippingMethodDetailsRequest($serviceId),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve quick shipping rate estimates with minimal data.
     *
     * Provides fast rate estimates using simplified input parameters,
     * ideal for checkout pages or quick price comparisons.
     *
     * @param array<string, mixed> $data Minimal shipment data for quick rate lookup
     *
     * @throws FatalRequestException
     * @throws RequestException
     *
     * @return QuickShippingMethodsResponseData Quick rate estimates from available carriers
     */
    public function quick(array $data): QuickShippingMethodsResponseData
    {
        /** @var QuickShippingMethodsResponseData */
        return $this->connector
            ->send(
                new GetQuickShippingMethodsRequest($data),
            )
            ->dtoOrFail();
    }
}
