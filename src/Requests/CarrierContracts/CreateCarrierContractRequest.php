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
 * Creates a new carrier contract in the Shipit system.
 *
 * Establishes a contractual agreement between a shipper and a carrier, defining
 * pricing terms, service levels, and operational parameters. Carrier contracts
 * enable negotiated rates and custom service options for high-volume shippers.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateCarrierContractRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::POST;

    /**
     * Create a new carrier contract creation request.
     *
     * @param array<string, mixed> $data Contract configuration including carrier ID, pricing structure,
     *                                   service levels, effective dates, and terms. Typically includes
     *                                   negotiated rates, volume commitments, and service-level agreements
     *                                   that differ from standard carrier offerings
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The endpoint path for creating carrier contracts
     */
    public function resolveEndpoint(): string
    {
        return '/v1/carrier-contracts';
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into a CarrierContractResponseData object
     * containing the newly created contract details including assigned ID.
     *
     * @param  Response                    $response The HTTP response from the Shipit API
     * @return CarrierContractResponseData Typed data object with created contract information
     */
    public function createDtoFromResponse(Response $response): CarrierContractResponseData
    {
        return CarrierContractResponseData::from($response->json());
    }

    /**
     * Provides the request body with contract details.
     *
     * @return array<string, mixed> The contract data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
