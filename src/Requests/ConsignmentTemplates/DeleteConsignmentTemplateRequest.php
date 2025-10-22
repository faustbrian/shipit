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
 * Deletes an existing consignment template from the Shipit system.
 *
 * Permanently removes a shipment configuration template from the account.
 * Use with caution as this action cannot be undone. Deletion does not affect
 * shipments previously created using this template.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class DeleteConsignmentTemplateRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for the request */
    protected Method $method = Method::DELETE;

    /**
     * Create a new consignment template deletion request.
     *
     * @param string $id Unique identifier of the consignment template to delete. Typically
     *                   a UUID or numeric ID assigned when the template was created
     */
    public function __construct(
        private readonly string $id,
    ) {}

    /**
     * Resolves the API endpoint for the request.
     *
     * @return string The fully constructed endpoint path with template ID
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consignment-templates/'.$this->id;
    }

    /**
     * Creates a strongly-typed DTO from the API response.
     *
     * Transforms the raw JSON response into a ConsignmentTemplateResponseData object
     * containing confirmation of the deleted template.
     *
     * @param  Response                        $response The HTTP response from the Shipit API
     * @return ConsignmentTemplateResponseData Typed data object with deleted template information
     */
    public function createDtoFromResponse(Response $response): ConsignmentTemplateResponseData
    {
        return ConsignmentTemplateResponseData::from($response->json());
    }
}
