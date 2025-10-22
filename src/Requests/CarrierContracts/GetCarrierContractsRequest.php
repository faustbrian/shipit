<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\CarrierContracts;

use Cline\Shipit\Data\Responses\CarrierContractResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves all carrier contracts for the authenticated account.
 *
 * Fetches a complete list of active carrier contracts including negotiated
 * rates, service levels, and contract terms. Used to display available contracts
 * and determine which carriers offer preferential pricing for the account.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetCarrierContractsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::GET;

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The endpoint path for listing carrier contracts
     */
    public function resolveEndpoint(): string
    {
        return '/v1/carrier-contracts';
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into a CarrierContractResponseData object
     * containing the collection of all carrier contracts for the account.
     *
     * @param  Response                    $response The HTTP response from the Shipit API
     * @return CarrierContractResponseData Typed data object with contract collection
     */
    public function createDtoFromResponse(Response $response): CarrierContractResponseData
    {
        return CarrierContractResponseData::from($response->json());
    }
}
