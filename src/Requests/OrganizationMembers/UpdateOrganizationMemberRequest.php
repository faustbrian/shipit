<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Requests\OrganizationMembers;

use Cline\Shipit\Data\Responses\OrganizationMemberResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Updates an existing organization member's information.
 *
 * Modifies member details such as role, permissions, or other attributes
 * for a specific member within an organization.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class UpdateOrganizationMemberRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    /**
     * Create a new request to update an organization member.
     *
     * @param string               $organizationId Unique identifier of the organization containing the member
     * @param string               $memberId       Unique identifier of the member to update
     * @param array<string, mixed> $data           Member data to update, containing fields like role, permissions, or status
     */
    public function __construct(
        private readonly string $organizationId,
        private readonly string $memberId,
        private readonly array $data,
    ) {}

    /**
     * Resolve the API endpoint for updating a specific organization member.
     *
     * @return string The fully qualified endpoint URL
     */
    public function resolveEndpoint(): string
    {
        return '/v1/organizations/'.$this->organizationId.'/members/'.$this->memberId;
    }

    /**
     * Transform the API response into a strongly-typed data object.
     *
     * @param  Response                       $response The raw HTTP response from the API
     * @return OrganizationMemberResponseData The updated member data
     */
    public function createDtoFromResponse(Response $response): OrganizationMemberResponseData
    {
        return OrganizationMemberResponseData::from($response->json());
    }

    /**
     * Define the request body containing the member data to update.
     *
     * @return array<string, mixed> The member update data
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
