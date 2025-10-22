<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Agents;

use Cline\Shipit\Data\Responses\AgentResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves a single agent by unique identifier.
 *
 * Fetches detailed information about a specific agent including contact details,
 * service capabilities, and operational parameters. Agents represent service
 * locations or pickup points in the shipping network.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetAgentByIdRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::GET;

    /**
     * Create a new get agent by ID request.
     *
     * @param string $id Unique identifier of the agent to retrieve. Typically
     *                   a UUID or numeric ID assigned by the Shipit platform
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The fully constructed endpoint path with agent ID
     */
    public function resolveEndpoint(): string
    {
        return '/v1/agents/'.$this->id;
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into an AgentResponseData object
     * for type-safe access to agent information.
     *
     * @param  Response          $response The HTTP response from the Shipit API
     * @return AgentResponseData Typed data object containing agent details
     */
    public function createDtoFromResponse(Response $response): AgentResponseData
    {
        return AgentResponseData::from($response->json());
    }
}
