<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\ConsignmentTemplates;

use Cline\Shipit\Data\Responses\ConsignmentTemplateResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a new consignment template in the Shipit system.
 *
 * Establishes a reusable shipment configuration template containing predefined
 * sender/receiver information, package dimensions, service options, and preferences.
 * Templates streamline repetitive shipping workflows by eliminating redundant data
 * entry for frequently used shipment configurations.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class CreateConsignmentTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::POST;

    /**
     * Create a new consignment template creation request.
     *
     * @param array<string, mixed> $data Template configuration including name, sender/receiver addresses,
     *                                   default parcel dimensions, preferred carriers, service options,
     *                                   and shipping preferences. Supports partial templates where only
     *                                   specific fields are predefined while others remain customizable
     */
    public function __construct(
        private readonly array $data,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The endpoint path for creating consignment templates
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consignment-templates';
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into a ConsignmentTemplateResponseData object
     * containing the newly created template details including assigned ID.
     *
     * @param  Response                        $response The HTTP response from the Shipit API
     * @return ConsignmentTemplateResponseData Typed data object with created template information
     */
    public function createDtoFromResponse(Response $response): ConsignmentTemplateResponseData
    {
        return ConsignmentTemplateResponseData::from($response->json());
    }

    /**
     * Provides the request body with template configuration.
     *
     * @return array<string, mixed> The template data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
