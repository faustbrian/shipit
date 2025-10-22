<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\Shipit\Resources;

use Cline\Shipit\Data\Responses\BalanceResponseData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\BaseResource;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Resource for managing financial balance, invoicing, and transaction operations.
 *
 * Provides comprehensive access to account balance information, invoices, transactions,
 * payrows, and wallet data. Supports filtering, querying, and detailed financial reporting
 * across carriers, business entities, and users.
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class BalanceResource extends BaseResource
{
    /**
     * Retrieve carrier balance reports.
     *
     * @return BalanceResponseData Carrier-specific balance reporting data
     */
    public function carrierReports(): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class() extends Request
            {
                protected Method $method = Method::GET;

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/carrier-reports';
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve balance information for all carriers.
     *
     * @return BalanceResponseData Aggregated carrier balance data
     */
    public function carriers(): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class() extends Request
            {
                protected Method $method = Method::GET;

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/carriers';
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve balance information by identifier.
     *
     * @param  string              $id The balance account or entity identifier
     * @return BalanceResponseData Detailed balance information for the specified entity
     */
    public function get(string $id): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($id) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $id,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/'.$this->id;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve payment rows for a specific invoice and balance entity.
     *
     * @param  string              $id      The balance entity identifier
     * @param  string              $invoice The invoice identifier
     * @return BalanceResponseData Payment row details for the specified invoice
     */
    public function invoicePayrows(string $id, string $invoice): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($id, $invoice) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $id,
                    protected readonly string $invoice,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/'.$this->id.'/invoice/'.$this->invoice;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Query invoices with filtering criteria.
     *
     * @param  array<string, mixed> $data query filters including date ranges, status,
     *                                    business entity, amount ranges, and pagination
     *                                    options for retrieving matching invoices
     * @return BalanceResponseData  Collection of invoices matching the query criteria
     */
    public function invoices(array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/invoices';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve a specific invoice by identifier.
     *
     * @param  string              $invoice The invoice identifier
     * @return BalanceResponseData Complete invoice details including line items
     */
    public function invoice(string $invoice): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($invoice) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $invoice,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/invoice/'.$this->invoice;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve all payment rows for a specific invoice.
     *
     * @param  string              $invoice The invoice identifier
     * @return BalanceResponseData Collection of payment rows associated with the invoice
     */
    public function allPayrows(string $invoice): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($invoice) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $invoice,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/invoice/'.$this->invoice.'/payrows';
                }
            },
        )->dtoOrFail();
    }

    /**
     * Submit booking data for invoice processing.
     *
     * @param  string               $invoice The invoice identifier
     * @param  array<string, mixed> $data    Booking information to associate with the invoice
     * @return BalanceResponseData  Updated invoice with booking data
     */
    public function invoiceBookingData(string $invoice, array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($invoice, $data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    protected readonly string $invoice,
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/invoice/'.$this->invoice.'/booking-data';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Query payment rows with filtering criteria.
     *
     * @param  array<string, mixed> $data query filters including date ranges, invoice
     *                                    identifiers, status, payment methods, and
     *                                    pagination options for retrieving payrows
     * @return BalanceResponseData  Collection of payment rows matching the query criteria
     */
    public function payrows(array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/payrows';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve a specific payment row by identifier.
     *
     * @param  string              $payrow The payment row identifier
     * @return BalanceResponseData Detailed payment row information
     */
    public function payrow(string $payrow): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($payrow) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $payrow,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/payrow/'.$this->payrow;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Query transactions with filtering criteria.
     *
     * @param  array<string, mixed> $data query filters including date ranges, transaction
     *                                    types, amounts, account identifiers, status, and
     *                                    pagination options for retrieving transactions
     * @return BalanceResponseData  Collection of transactions matching the query criteria
     */
    public function transactions(array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/transactions';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve a specific transaction by identifier.
     *
     * @param  string              $transaction The transaction identifier
     * @return BalanceResponseData Detailed transaction information
     */
    public function transaction(string $transaction): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($transaction) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $transaction,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/transaction/'.$this->transaction;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve balance information for a specific user.
     *
     * @param  string              $id The user identifier
     * @return BalanceResponseData User-specific balance data and account information
     */
    public function user(string $id): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($id) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $id,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/user/'.$this->id;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Query wallet balances with filtering criteria.
     *
     * @param  array<string, mixed> $data query filters including wallet types, currencies,
     *                                    business entities, status filters, and pagination
     *                                    options for retrieving wallet information
     * @return BalanceResponseData  Collection of wallet balances matching the query criteria
     */
    public function wallets(array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/wallets';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Retrieve pending invoices for a specific business entity.
     *
     * @param  string              $businessEntityId The business entity identifier
     * @return BalanceResponseData Collection of unpaid or pending invoices for the entity
     */
    public function pendingInvoices(string $businessEntityId): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($businessEntityId) extends Request
            {
                protected Method $method = Method::GET;

                public function __construct(
                    protected readonly string $businessEntityId,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/pending-invoices/'.$this->businessEntityId;
                }
            },
        )->dtoOrFail();
    }

    /**
     * Query shipment-related balance information with filtering criteria.
     *
     * @param  array<string, mixed> $data query filters including shipment identifiers,
     *                                    date ranges, carriers, status, cost ranges, and
     *                                    pagination options for shipment billing data
     * @return BalanceResponseData  Collection of shipment balance records matching the criteria
     */
    public function shipments(array $data): BalanceResponseData
    {
        /** @var BalanceResponseData */
        return $this->connector->send(
            new class($data) extends Request implements HasBody
            {
                use HasJsonBody;

                protected Method $method = Method::POST;

                public function __construct(
                    /** @var array<string, mixed> */
                    protected readonly array $data,
                ) {}

                public function resolveEndpoint(): string
                {
                    return '/v1/balance/shipments';
                }

                /**
                 * @return array<string, mixed>
                 */
                protected function defaultBody(): array
                {
                    return /** @var array<string, mixed> */ $this->data;
                }
            },
        )->dtoOrFail();
    }
}
