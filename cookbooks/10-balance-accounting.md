# Balance & Accounting

Manage account balance, invoices, transactions, and carrier reports.

## Get Carrier Reports

Retrieve reports from different carriers:

```php
$reports = $shipit->balance()->carrierReports();

// Returns BalanceResponseData
foreach ($reports->reports as $report) {
    echo $report->carrier;
    echo $report->period;
    echo $report->totalCost;
    echo $report->shipmentsCount;
}
```

## Get Carriers

List all available carriers:

```php
$carriers = $shipit->balance()->carriers();

// Returns BalanceResponseData
foreach ($carriers->carriers as $carrier) {
    echo $carrier->name;
    echo $carrier->code;
    echo $carrier->isActive;
}
```

## Get Balance

Retrieve account balance information:

```php
$balance = $shipit->balance()->get('balance-id');

// Returns BalanceResponseData
echo $balance->amount;
echo $balance->currency;
echo $balance->lastUpdated;
```

## Get Invoices

List invoices for a date range:

```php
$invoices = $shipit->balance()->invoices([
    'start_date' => '2025-01-01',
    'end_date' => '2025-01-31',
]);

// Returns BalanceResponseData
foreach ($invoices->invoices as $invoice) {
    echo $invoice->id;
    echo $invoice->number;
    echo $invoice->date;
    echo $invoice->dueDate;
    echo $invoice->amount;
    echo $invoice->status;  // paid, pending, overdue
}
```

## Get Specific Invoice

Retrieve details for a single invoice:

```php
$invoice = $shipit->balance()->invoice('invoice-id');

// Returns BalanceResponseData
echo $invoice->number;
echo $invoice->amount;
echo $invoice->currency;
echo $invoice->status;
echo $invoice->pdfUrl;  // Download invoice PDF

// Line items
foreach ($invoice->items as $item) {
    echo $item->description;
    echo $item->quantity;
    echo $item->unitPrice;
    echo $item->total;
}
```

## Get Payrows

Get payment rows for an invoice:

```php
$payrows = $shipit->balance()->payrows([
    'invoice_id' => 'invoice-id',
]);

// Returns BalanceResponseData
foreach ($payrows->payrows as $payrow) {
    echo $payrow->description;
    echo $payrow->amount;
    echo $payrow->date;
}
```

## Get Transactions

List account transactions:

```php
$transactions = $shipit->balance()->transactions([
    'start_date' => '2025-01-01',
    'end_date' => '2025-01-31',
]);

// Returns BalanceResponseData
foreach ($transactions->transactions as $transaction) {
    echo $transaction->id;
    echo $transaction->date;
    echo $transaction->type;  // debit, credit
    echo $transaction->amount;
    echo $transaction->description;
    echo $transaction->balance;
}
```

## Get Wallets

List account wallets:

```php
$wallets = $shipit->balance()->wallets([
    'user_id' => 'user-id',
]);

// Returns BalanceResponseData
foreach ($wallets->wallets as $wallet) {
    echo $wallet->id;
    echo $wallet->name;
    echo $wallet->balance;
    echo $wallet->currency;
}
```

## Get Pending Invoices

Get pending invoices for a business entity:

```php
$pending = $shipit->balance()->pendingInvoices('business-entity-id');

// Returns BalanceResponseData
foreach ($pending->invoices as $invoice) {
    echo $invoice->number;
    echo $invoice->amount;
    echo $invoice->dueDate;

    // Days until due
    $daysUntilDue = now()->diffInDays($invoice->dueDate);
    echo "Due in {$daysUntilDue} days";
}
```

## Get Shipments Report

Get shipment-level accounting data:

```php
$shipments = $shipit->balance()->shipments([
    'start_date' => '2025-01-01',
    'end_date' => '2025-01-31',
]);

// Returns BalanceResponseData
foreach ($shipments->shipments as $shipment) {
    echo $shipment->trackingNumber;
    echo $shipment->serviceId;
    echo $shipment->cost;
    echo $shipment->carrier;
    echo $shipment->createdAt;
}
```

## Financial Reporting

Generate financial reports:

```php
class FinancialReporter
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function monthlyReport(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();

        $invoices = $this->shipit->balance()->invoices([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);

        $transactions = $this->shipit->balance()->transactions([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);

        $shipments = $this->shipit->balance()->shipments([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);

        return [
            'period' => $startDate->format('F Y'),
            'total_invoiced' => $this->sumInvoices($invoices),
            'total_spent' => $this->sumTransactions($transactions),
            'shipment_count' => count($shipments->shipments),
            'average_cost_per_shipment' => $this->calculateAverage($shipments),
        ];
    }

    private function sumInvoices($invoices): float
    {
        return collect($invoices->invoices)
            ->sum('amount');
    }

    private function sumTransactions($transactions): float
    {
        return collect($transactions->transactions)
            ->where('type', 'debit')
            ->sum('amount');
    }

    private function calculateAverage($shipments): float
    {
        $total = collect($shipments->shipments)->sum('cost');
        $count = count($shipments->shipments);

        return $count > 0 ? $total / $count : 0;
    }
}
```

## Cost Analysis by Carrier

Analyze costs per carrier:

```php
$startDate = '2025-01-01';
$endDate = '2025-01-31';

$shipments = $shipit->balance()->shipments([
    'start_date' => $startDate,
    'end_date' => $endDate,
]);

$costByCarrier = [];
foreach ($shipments->shipments as $shipment) {
    $carrier = $shipment->carrier;
    if (!isset($costByCarrier[$carrier])) {
        $costByCarrier[$carrier] = [
            'count' => 0,
            'total_cost' => 0,
        ];
    }

    $costByCarrier[$carrier]['count']++;
    $costByCarrier[$carrier]['total_cost'] += $shipment->cost;
}

// Display results
foreach ($costByCarrier as $carrier => $data) {
    $avgCost = $data['total_cost'] / $data['count'];
    echo "{$carrier}: {$data['count']} shipments, €{$data['total_cost']}, avg €{$avgCost}\n";
}
```

## Export Invoice Data

Export invoice data for accounting systems:

```php
$invoices = $shipit->balance()->invoices([
    'start_date' => '2025-01-01',
    'end_date' => '2025-01-31',
]);

$csvData = [];
$csvData[] = ['Invoice Number', 'Date', 'Due Date', 'Amount', 'Status', 'PDF URL'];

foreach ($invoices->invoices as $invoice) {
    $csvData[] = [
        $invoice->number,
        $invoice->date,
        $invoice->dueDate,
        $invoice->amount,
        $invoice->status,
        $invoice->pdfUrl,
    ];
}

// Write to CSV file
$fp = fopen('invoices.csv', 'w');
foreach ($csvData as $row) {
    fputcsv($fp, $row);
}
fclose($fp);
```

## Monitor Account Balance

Check and monitor account balance:

```php
$balance = $shipit->balance()->get('balance-id');

if ($balance->amount < 100.00) {
    // Send low balance notification
    notifyAdmins("Shipit account balance is low: €{$balance->amount}");
}

// Get pending invoices
$pending = $shipit->balance()->pendingInvoices('business-entity-id');

$overdue = array_filter($pending->invoices, function($invoice) {
    return $invoice->dueDate < now();
});

if (count($overdue) > 0) {
    // Alert about overdue invoices
    notifyAdmins(count($overdue) . " overdue invoices");
}
```

## Next Steps

- [Advanced Features](./11-advanced-features.md)
- [Error Handling](./12-error-handling.md)
