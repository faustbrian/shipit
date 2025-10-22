<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Tracking;

use Cline\Shipit\Data\Responses\TrackingEventResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Queries tracking events with advanced filtering and search criteria.
 *
 * Performs a filtered search across tracking events to retrieve shipment status updates
 * based on specific criteria such as date ranges, tracking numbers, or event types.
 * Useful for batch tracking operations and historical event analysis.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class QueryTrackingEventsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * Create a new tracking events query request instance.
     *
     * @param array<string, mixed> $data Query parameters for filtering tracking events,
     *                                   including search criteria such as tracking numbers,
     *                                   date ranges, event types, carrier filters, and pagination
     *                                   options. Supports complex queries for batch shipment
     *                                   tracking and detailed event history retrieval.
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for querying tracking events.
     *
     * @return string The tracking events query endpoint path
     */
    public function resolveEndpoint(): string
    {
        return '/v1/query-tracking-events';
    }

    /**
     * Transform the API response into a typed data object.
     *
     * @param  Response                  $response The HTTP response from the tracking events query endpoint
     * @return TrackingEventResponseData Collection of matching tracking events
     */
    public function createDtoFromResponse(Response $response): TrackingEventResponseData
    {
        return TrackingEventResponseData::from($response->json());
    }

    /**
     * Build the request body containing query filters.
     *
     * @return array<string, mixed> Query parameters for event filtering
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
