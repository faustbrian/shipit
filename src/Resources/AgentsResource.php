<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\AgentResponseData;
use Cline\Shipit\Data\Responses\AgentsResponseData;
use Cline\Shipit\Requests\Agents\GetAgentByIdRequest;
use Cline\Shipit\Requests\Agents\GetAgentsRequest;
use Saloon\Http\BaseResource;

/**
 * Resource for managing and querying shipping agents.
 *
 * Provides access to shipping agent information including profiles, service areas,
 * capabilities, and operational details. Agents represent authorized service providers
 * or carriers available for shipment processing.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class AgentsResource extends BaseResource
{
    /**
     * Retrieve a filtered list of shipping agents.
     *
     * @param  array<string, mixed> $data Query parameters for filtering agents including
     *                                    search criteria, service area filters, capability
     *                                    requirements, status filters, and pagination options.
     *                                    Returns agents matching the specified criteria.
     * @return AgentsResponseData   Collection of agents matching the query filters
     */
    public function get(array $data): AgentsResponseData
    {
        /** @var AgentsResponseData */
        return $this->connector
            ->send(
                new GetAgentsRequest($data),
            )
            ->dtoOrFail();
    }

    /**
     * Retrieve a specific shipping agent by identifier.
     *
     * @param  string            $id The unique identifier of the shipping agent
     * @return AgentResponseData Complete agent profile including service details
     */
    public function getById(string $id): AgentResponseData
    {
        /** @var AgentResponseData */
        return $this->connector
            ->send(
                new GetAgentByIdRequest($id),
            )
            ->dtoOrFail();
    }
}
