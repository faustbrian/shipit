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
 * Retrieves a collection of all consignment templates for the authenticated account.
 *
 * Consignment templates are reusable shipping configurations that streamline the
 * creation of consignments by storing common settings like carrier preferences,
 * package dimensions, and shipping options. This request fetches all available
 * templates for selection and management.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class GetConsignmentTemplatesRequest extends Request implements HasBody
{
    use HasJsonBody;

    /** @var Method HTTP method for listing consignment templates */
    protected Method $method = Method::GET;

    /**
     * Resolve the API endpoint for retrieving all consignment templates.
     *
     * @return string The endpoint path for the collection GET request
     */
    public function resolveEndpoint(): string
    {
        return '/v1/consignment-templates';
    }

    /**
     * Transform the API response into a structured ConsignmentTemplateResponseData object.
     *
     * @param  Response                        $response The HTTP response containing the collection of consignment templates in JSON format
     * @return ConsignmentTemplateResponseData Typed data object containing the array of consignment templates
     */
    public function createDtoFromResponse(Response $response): ConsignmentTemplateResponseData
    {
        return ConsignmentTemplateResponseData::from($response->json());
    }
}
