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
 * Updates an existing consignment template with new configuration data.
 *
 * Allows modification of template settings including carrier preferences, default
 * package dimensions, shipping options, and other consignment defaults. The entire
 * template is replaced with the provided data (PUT semantics), so include all fields
 * that should be retained.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateConsignmentTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for updating consignment template data */
    protected Method $method = Method::PUT;

    /**
     * Create a new request to update a consignment template.
     *
     * @param string               $id   Unique identifier of the consignment template to update.
     *                                   This is the template's UUID or ID as returned when the
     *                                   template was created or retrieved.
     * @param array<string, mixed> $data Template configuration data to update. Should include all
     *                                   fields that need to be retained as this is a full replacement
     *                                   operation. Typical fields include carrier settings, package
     *                                   defaults, shipping preferences, and template metadata.
     */
    public function __construct(
        private readonly string $id,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating the specific consignment template.
     *
     * @return string The fully constructed endpoint path for the PUT request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consignment-templates/'.$this->id;
    }

    /**
     * Transform the API response into a structured ConsignmentTemplateResponseData object.
     *
     * @param  Response                        $response The HTTP response containing the updated consignment template data in JSON format
     * @return ConsignmentTemplateResponseData Typed data object containing the updated consignment template details
     */
    public function createDtoFromResponse(Response $response): ConsignmentTemplateResponseData
    {
        return ConsignmentTemplateResponseData::from($response->json());
    }

    /**
     * Provide the request body containing the updated template data.
     *
     * @return array<string, mixed> The template configuration data to send in the request body
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
