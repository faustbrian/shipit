<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Shipments;

use Cline\Shipit\Data\BookPickUpRequestData;
use Cline\Shipit\Data\Responses\BookPickUpResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Books a carrier pick-up for shipment collection.
 *
 * This request schedules a carrier to collect packages from a specified location
 * at a designated time. Used when merchants need scheduled pick-up services rather
 * than dropping packages at carrier facilities. The API returns confirmation details
 * including pick-up reference numbers and scheduled collection times.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BookPickUpRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for this request */
    protected Method $method = Method::POST;

    /**
     * Create a new pick-up booking request.
     *
     * @param BookPickUpRequestData $data Pick-up scheduling information including collection
     *                                    address, preferred time windows, number of packages,
     *                                    total weight, and carrier-specific requirements. This
     *                                    data determines pick-up availability and scheduling options.
     */
    public function __construct(
        private readonly BookPickUpRequestData $data,
    ) {}

    /**
     * Resolve the API endpoint for pick-up booking.
     *
     * @return string The endpoint path for scheduling carrier pick-ups
     */
    public function resolveEndpoint(): string
    {
        return '/v1/pick-ups';
    }

    /**
     * Transform the API response into a structured data object.
     *
     * @param  Response               $response The HTTP response from the Shipit API
     * @return BookPickUpResponseData Structured pick-up confirmation including reference numbers
     */
    public function createDtoFromResponse(Response $response): BookPickUpResponseData
    {
        return BookPickUpResponseData::from($response->json());
    }

    /**
     * Provide the request body for pick-up booking.
     *
     * @return array<string, mixed> Pick-up data serialized as an array
     */
    protected function defaultBody(): array
    {
        /** @var array<string, mixed> */
        return $this->data->toArray();
    }
}
