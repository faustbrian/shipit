<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\Tracking;

use Cline\Shipit\Data\Responses\TrackingLinkResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Retrieves a shareable tracking link for a shipment.
 *
 * Generates a public-facing tracking URL that can be shared with customers to
 * view real-time shipment status and delivery updates without requiring authentication.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetTrackingLinkRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::GET;

    /**
     * Create a new tracking link request instance.
     *
     * @param string $trackingNumber the carrier tracking number or shipment identifier used
     *                               to locate the specific shipment and generate a publicly
     *                               accessible tracking URL with current delivery status
     */
    public function __construct(
        private readonly string $trackingNumber,
    ) {}

    /**
     * Resolve the API endpoint for retrieving the tracking link.
     *
     * @return string The tracking link endpoint with tracking number parameter
     */
    public function resolveEndpoint(): string
    {
        return '/v1/tracking-link/'.$this->trackingNumber;
    }

    /**
     * Transform the API response into a typed data object.
     *
     * @param  Response                 $response The HTTP response from the tracking link endpoint
     * @return TrackingLinkResponseData The shareable tracking URL and metadata
     */
    public function createDtoFromResponse(Response $response): TrackingLinkResponseData
    {
        return TrackingLinkResponseData::from($response->json());
    }
}
