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
 * Retrieves a single carrier contract by unique identifier.
 *
 * Fetches detailed information about a specific carrier contract including
 * negotiated rates, service levels, effective dates, and contract terms.
 * Used to review contract details and verify pricing before creating shipments.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetCarrierContractRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::GET;

    /**
     * Create a new get carrier contract request.
     *
     * @param string $id Unique identifier of the carrier contract to retrieve. Typically
     *                   a UUID or numeric ID assigned when the contract was created
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The fully constructed endpoint path with contract ID
     */
    public function resolveEndpoint(): string
    {
        return '/v1/carrier-contracts/'.$this->id;
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into a CarrierContractResponseData object
     * for type-safe access to contract details and pricing information.
     *
     * @param  Response                    $response The HTTP response from the Shipit API
     * @return CarrierContractResponseData Typed data object containing contract details
     */
    public function createDtoFromResponse(Response $response): CarrierContractResponseData
    {
        return CarrierContractResponseData::from($response->json());
    }
}
