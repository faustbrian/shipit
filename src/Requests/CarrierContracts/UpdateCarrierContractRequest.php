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
 * Updates an existing carrier contract in the Shipit system.
 *
 * Modifies contract terms including pricing, service levels, or effective dates.
 * Typically used to adjust negotiated rates or extend contract periods. Changes
 * apply immediately and affect all future shipments using this contract.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateCarrierContractRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::PUT;

    /**
     * Create a new carrier contract update request.
     *
     * @param string               $id   Unique identifier of the carrier contract to update. Typically
     *                                   a UUID or numeric ID assigned when the contract was created
     * @param array<string, mixed> $data Updated contract configuration including modified pricing,
     *                                   service levels, effective dates, or terms. Only provided
     *                                   fields are updated; omitted fields retain their existing values
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
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
     * containing the updated contract details with all modifications applied.
     *
     * @param  Response                    $response The HTTP response from the Shipit API
     * @return CarrierContractResponseData Typed data object with updated contract information
     */
    public function createDtoFromResponse(Response $response): CarrierContractResponseData
    {
        return CarrierContractResponseData::from($response->json());
    }

    /**
     * Provides the request body with updated contract details.
     *
     * @return array<string, mixed> The updated contract data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
