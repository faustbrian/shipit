# User Management

Manage user accounts and registration.

## Get Current User

Retrieve information about the authenticated user:

```php
$user = $shipit->user()->me();

// Returns UserResponseData
echo $user->id;
echo $user->name;
echo $user->email;
echo $user->phone;
echo $user->role;
```

## Register New User

Create a new user account:

```php
use Cline\Shipit\Data\RegistrationRequestData;

$registration = $shipit->user()->register(
    RegistrationRequestData::from([
        'name' => 'John Doe',
        'email' => 'john@company.com',
        'phone' => '+358401234567',
        'password' => 'secure-password',
        'password_confirmation' => 'secure-password',
        'company' => 'Company Ltd',
        'businessId' => '1234567-8',
    ])
);

// Returns RegistrationResponseData
echo $registration->userId;
echo $registration->apiToken;  // Save this for API authentication
```

## User Authentication Flow

Implement user registration and authentication:

```php
class UserManager
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function registerUser(array $userData): RegistrationResponseData
    {
        $registration = $shipit->user()->register(
            RegistrationRequestData::from($userData)
        );

        // Store API token for future use
        $this->storeApiToken(
            $registration->userId,
            $registration->apiToken
        );

        return $registration;
    }

    public function getCurrentUser(): UserResponseData
    {
        return $this->shipit->user()->me();
    }

    private function storeApiToken(string $userId, string $token): void
    {
        // Store in your database
        DB::table('shipit_tokens')->insert([
            'user_id' => $userId,
            'api_token' => $token,
            'created_at' => now(),
        ]);
    }
}
```

## User Profile

Display user profile information:

```php
$user = $shipit->user()->me();

echo "Name: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Phone: {$user->phone}\n";
echo "Role: {$user->role}\n";

// Organization information
if ($user->organization) {
    echo "Organization: {$user->organization->name}\n";
    echo "Business ID: {$user->organization->businessId}\n";
}
```

## User Roles and Permissions

Different user roles have different permissions:

```php
$user = $shipit->user()->me();

switch ($user->role) {
    case 'admin':
        // Full access to all features
        echo "Admin user - full access";
        break;

    case 'member':
        // Can create shipments and view reports
        echo "Member - can create shipments";
        break;

    case 'viewer':
        // Read-only access
        echo "Viewer - read-only access";
        break;
}
```

## API Token Management

Manage API tokens for different users or applications:

```php
// Register a new application user
$registration = $shipit->user()->register(
    RegistrationRequestData::from([
        'name' => 'Production API User',
        'email' => 'api@company.com',
        'phone' => '+358401234567',
        'password' => 'secure-password',
        'password_confirmation' => 'secure-password',
        'company' => 'Company Ltd',
        'businessId' => '1234567-8',
    ])
);

// Store different tokens for different environments
$tokens = [
    'production' => $registration->apiToken,
    'staging' => $stagingRegistration->apiToken,
    'development' => $devRegistration->apiToken,
];

// Use appropriate token based on environment
$connector = ShipitConnector::new($tokens[env('APP_ENV')]);
```

## Integration with Your Application

Integrate user management with your application's authentication:

```php
class ShipitUserService
{
    public function createShipitUser(User $appUser): void
    {
        $connector = ShipitConnector::new(config('shipit.admin_token'));

        $registration = $connector->user()->register(
            RegistrationRequestData::from([
                'name' => $appUser->name,
                'email' => $appUser->email,
                'phone' => $appUser->phone,
                'password' => Str::random(32),
                'password_confirmation' => Str::random(32),
                'company' => $appUser->company->name,
                'businessId' => $appUser->company->business_id,
            ])
        );

        // Store Shipit API token with user record
        $appUser->shipit_token = $registration->apiToken;
        $appUser->shipit_user_id = $registration->userId;
        $appUser->save();
    }

    public function getShipitConnectorForUser(User $appUser): ShipitConnector
    {
        return ShipitConnector::new($appUser->shipit_token);
    }
}
```

## User Registration Validation

Validate registration data before submission:

```php
$registrationData = [
    'name' => 'John Doe',
    'email' => 'john@company.com',
    'phone' => '+358401234567',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'company' => 'Company Ltd',
    'businessId' => '1234567-8',
];

// Validate email format
if (!filter_var($registrationData['email'], FILTER_VALIDATE_EMAIL)) {
    throw new InvalidArgumentException('Invalid email format');
}

// Validate phone format
if (!preg_match('/^\+\d{10,15}$/', $registrationData['phone'])) {
    throw new InvalidArgumentException('Invalid phone format');
}

// Passwords match
if ($registrationData['password'] !== $registrationData['password_confirmation']) {
    throw new InvalidArgumentException('Passwords do not match');
}

// Register user
$registration = $shipit->user()->register(
    RegistrationRequestData::from($registrationData)
);
```

## Next Steps

- [Balance & Accounting](./10-balance-accounting.md)
- [Advanced Features](./11-advanced-features.md)
