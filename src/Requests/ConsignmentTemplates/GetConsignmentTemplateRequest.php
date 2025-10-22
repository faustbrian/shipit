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
 * Retrieves a single consignment template by its unique identifier.
 *
 * Consignment templates provide reusable configurations for shipping consignments,
 * including carrier settings, package defaults, and shipping preferences. This
 * request fetches the complete template data for viewing or modification.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetConsignmentTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for retrieving consignment template data */
    protected Method $method = Method::GET;

    /**
     * Create a new request to retrieve a consignment template.
     *
     * @param string $id Unique identifier of the consignment template to retrieve.
     *                   This is the template's UUID or ID as returned when the
     *                   template was created or listed.
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolve the API endpoint for retrieving the specific consignment template.
     *
     * @return string The fully constructed endpoint path for the GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consignment-templates/'.$this->id;
    }

    /**
     * Transform the API response into a structured ConsignmentTemplateResponseData object.
     *
     * @param  Response                        $response The HTTP response containing the consignment template data in JSON format
     * @return ConsignmentTemplateResponseData Typed data object containing the consignment template details
     */
    public function createDtoFromResponse(Response $response): ConsignmentTemplateResponseData
    {
        return ConsignmentTemplateResponseData::from($response->json());
    }
}
