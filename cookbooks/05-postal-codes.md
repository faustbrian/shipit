# Postal Codes

Validate postal codes and get address suggestions.

## Match Postal Code

Validate a postal code and get city information:

```php
use Cline\Shipit\Data\PostalCodeRequestData;

$match = $shipit->postalCodes()->match(
    PostalCodeRequestData::from([
        'country' => 'FI',
        'postalCode' => '00100',
    ])
);

// Returns PostalCodeResponseData
echo $match->city;        // "Helsinki"
echo $match->postalCode;  // "00100"
echo $match->country;     // "FI"
echo $match->isValid;     // true
```

## Get Postal Code Suggestions

Get autocomplete suggestions while typing:

```php
$suggestions = $shipit->postalCodes()->suggestions([
    'country' => 'FI',
    'query' => 'Helsin',
]);

// Returns PostalCodeSuggestionsResponseData
foreach ($suggestions->suggestions as $suggestion) {
    echo $suggestion->city;        // "Helsinki"
    echo $suggestion->postalCode;  // "00100"
    echo $suggestion->displayText; // "00100 Helsinki"
}
```

## Get Country Information

Retrieve postal code format and validation rules:

```php
$countries = $shipit->postalCodes()->countryInfo();

// Returns CountryInfoResponseData
foreach ($countries->countries as $country) {
    echo $country->code;           // "FI"
    echo $country->name;           // "Finland"
    echo $country->postalFormat;   // "#####"
    echo $country->requiresState;  // false
}
```

## Validate Address Input

Use postal code validation in your forms:

```php
// User enters postal code
$userInput = '00100';

try {
    $match = $shipit->postalCodes()->match(
        PostalCodeRequestData::from([
            'country' => 'FI',
            'postalCode' => $userInput,
        ])
    );

    if ($match->isValid) {
        echo "Valid postal code for {$match->city}";

        // Pre-fill city field
        $cityField = $match->city;
    } else {
        echo "Invalid postal code";
    }
} catch (\Exception $e) {
    echo "Postal code validation failed";
}
```

## Autocomplete Implementation

Implement postal code autocomplete:

```php
// Frontend sends partial input
$query = $_GET['q'] ?? '';
$country = $_GET['country'] ?? 'FI';

if (strlen($query) >= 2) {
    $suggestions = $shipit->postalCodes()->suggestions([
        'country' => $country,
        'query' => $query,
    ]);

    $results = array_map(function($suggestion) {
        return [
            'value' => $suggestion->postalCode,
            'label' => $suggestion->displayText,
            'city' => $suggestion->city,
        ];
    }, $suggestions->suggestions->toArray());

    return json_encode($results);
}
```

## Country-Specific Validation

Different countries have different postal code formats:

```php
$countries = $shipit->postalCodes()->countryInfo();

foreach ($countries->countries as $country) {
    echo "{$country->code}: {$country->postalFormat}\n";
    // FI: #####
    // SE: ### ##
    // DK: ####
    // NO: ####
}

// Validate based on country
$match = $shipit->postalCodes()->match(
    PostalCodeRequestData::from([
        'country' => 'SE',
        'postalCode' => '111 22',  // Swedish format with space
    ])
);
```

## Integration with Address Forms

Complete address validation flow:

```php
// 1. User selects country
$country = 'FI';

// 2. User types postal code - show suggestions
$suggestions = $shipit->postalCodes()->suggestions([
    'country' => $country,
    'query' => $userTypedText,
]);

// 3. User selects or enters complete postal code - validate
$match = $shipit->postalCodes()->match(
    PostalCodeRequestData::from([
        'country' => $country,
        'postalCode' => $selectedPostalCode,
    ])
);

// 4. Auto-fill city field
if ($match->isValid) {
    $formData['city'] = $match->city;
    $formData['postalCode'] = $match->postalCode;
}
```

## Next Steps

- [Service Points](./04-service-points.md)
- [Creating Shipments](./03-creating-shipments.md)
