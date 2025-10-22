<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Agents;

use Cline\Shipit\Data\Responses\AgentsResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves a paginated list of agents with optional filtering.
 *
 * Queries the Shipit API for agents matching specified criteria such as location,
 * service type, or operational status. Uses POST method to support complex filter
 * payloads that exceed query string limitations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetAgentsRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::POST;

    /**
     * Create a new get agents request.
     *
     * @param array<string, mixed> $data Filter criteria and pagination parameters for querying agents.
     *                                   May include fields like location coordinates, service capabilities,
     *                                   page number, and items per page to refine the result set
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The endpoint path for agent listing
     */
    public function resolveEndpoint(): string
    {
        return '/v1/agents';
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into an AgentsResponseData object
     * containing the paginated list of agents matching the filter criteria.
     *
     * @param  Response           $response The HTTP response from the Shipit API
     * @return AgentsResponseData Typed data object with agent collection and pagination metadata
     */
    public function createDtoFromResponse(Response $response): AgentsResponseData
    {
        return AgentsResponseData::from($response->json());
    }

    /**
     * Provides the request body for filtering agents.
     *
     * @return array<string, mixed> The filter criteria to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
