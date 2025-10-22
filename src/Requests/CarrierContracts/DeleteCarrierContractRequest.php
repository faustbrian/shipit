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
 * Deletes an existing carrier contract from the Shipit system.
 *
 * Permanently removes a carrier contract, terminating the negotiated agreement
 * and reverting to standard carrier rates. Use with caution as this action
 * cannot be undone and may affect active shipments or rate calculations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteCarrierContractRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::DELETE;

    /**
     * Create a new carrier contract deletion request.
     *
     * @param string $id Unique identifier of the carrier contract to delete. Typically
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
     * containing confirmation of the deleted contract.
     *
     * @param  Response                    $response The HTTP response from the Shipit API
     * @return CarrierContractResponseData Typed data object with deleted contract information
     */
    public function createDtoFromResponse(Response $response): CarrierContractResponseData
    {
        return CarrierContractResponseData::from($response->json());
    }
}
