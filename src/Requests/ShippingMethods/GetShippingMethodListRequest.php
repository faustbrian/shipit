<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\ShippingMethods;

use Cline\Shipit\Data\Responses\ShippingMethodListResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves the complete list of available shipping methods.
 *
 * This request fetches all shipping methods configured and available in the
 * merchant's Shipit account across all enabled carriers and services. Returns
 * a comprehensive catalog of shipping options without filtering by shipment
 * criteria. Useful for populating shipping method dropdowns, configuration
 * interfaces, or displaying all available carrier services to administrators.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetShippingMethodListRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for this request */
    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for shipping method list.
     *
     * @return string The endpoint path for retrieving all shipping methods
     */
    public function resolveEndpoint(): string
    {
        return '/v1/list-methods';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response                       $response The HTTP response from the Shipit API
     * @return ShippingMethodListResponseData Structured list of all shipping methods
     */
    public function createDtoFromResponse(Response $response): ShippingMethodListResponseData
    {
        return ShippingMethodListResponseData::from(['data' => $response->json()]);
    }
}
