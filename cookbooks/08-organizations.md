# Organizations

Manage organizations and organization members.

## List All Organizations

```php
$organizations = $shipit->organizations()->index();

// Returns OrganizationResponseData with collection
foreach ($organizations->organizations as $org) {
    echo $org->id;
    echo $org->name;
    echo $org->businessId;
    echo $org->email;
}
```

## Get Specific Organization

```php
$organization = $shipit->organizations()->show('org-id');

// Returns OrganizationResponseData
echo $organization->name;
echo $organization->businessId;
echo $organization->email;
echo $organization->phone;
echo $organization->address;
```

## Create Organization

```php
$organization = $shipit->organizations()->store([
    'name' => 'My Company Ltd',
    'businessId' => '1234567-8',
    'email' => 'info@company.com',
    'phone' => '+358401234567',
    'address' => 'Business Street 1',
    'city' => 'Helsinki',
    'postcode' => '00100',
    'country' => 'FI',
]);

// Returns OrganizationResponseData
echo $organization->id;
```

## Update Organization

```php
$organization = $shipit->organizations()->update('org-id', [
    'name' => 'Updated Company Name Ltd',
    'email' => 'contact@company.com',
]);

// Returns updated OrganizationResponseData
```

## Delete Organization

```php
$result = $shipit->organizations()->destroy('org-id');

// Returns OrganizationResponseData with deletion confirmation
```

## Organization Members

### List Organization Members

```php
$members = $shipit->organizationMembers()->index('org-id');

// Returns collection of member data
foreach ($members->members as $member) {
    echo $member->id;
    echo $member->name;
    echo $member->email;
    echo $member->role;
}
```

### Add Organization Member

```php
$member = $shipit->organizationMembers()->store('org-id', [
    'email' => 'user@company.com',
    'role' => 'admin',  // admin, member, viewer
]);
```

### Update Member Role

```php
$member = $shipit->organizationMembers()->update('org-id', 'member-id', [
    'role' => 'member',
]);
```

### Remove Organization Member

```php
$result = $shipit->organizationMembers()->destroy('org-id', 'member-id');
```

## Organization Roles

Available roles for organization members:

```php
// Admin - Full access
$member = $shipit->organizationMembers()->store('org-id', [
    'email' => 'admin@company.com',
    'role' => 'admin',
]);

// Member - Create shipments, view reports
$member = $shipit->organizationMembers()->store('org-id', [
    'email' => 'member@company.com',
    'role' => 'member',
]);

// Viewer - Read-only access
$member = $shipit->organizationMembers()->store('org-id', [
    'email' => 'viewer@company.com',
    'role' => 'viewer',
]);
```

## Multi-Organization Management

Handle multiple organizations:

```php
class OrganizationManager
{
    public function __construct(
        private ShipitConnector $shipit
    ) {}

    public function switchOrganization(string $orgId): OrganizationResponseData
    {
        return $this->shipit->organizations()->show($orgId);
    }

    public function getCurrentUserOrganizations(): array
    {
        $response = $this->shipit->organizations()->index();
        return $response->organizations->toArray();
    }

    public function inviteUserToOrganization(
        string $orgId,
        string $email,
        string $role = 'member'
    ): mixed {
        return $this->shipit->organizationMembers()->store($orgId, [
            'email' => $email,
            'role' => $role,
        ]);
    }
}
```

## Organization Settings

Store organization-specific shipping settings:

```php
$organization = $shipit->organizations()->show('org-id');

// Use organization details as default sender
$defaultSender = [
    'name' => $organization->name,
    'email' => $organization->email,
    'phone' => $organization->phone,
    'address' => $organization->address,
    'city' => $organization->city,
    'postcode' => $organization->postcode,
    'country' => $organization->country,
];

// Use in shipments
use Cline\Shipit\Data\ShipmentRequestData;

$shipment = $shipit->shipments()->create(
    ShipmentRequestData::from([
        'sender' => $defaultSender,
        'receiver' => [...],
        'parcels' => [...],
        'serviceId' => 'posti.2103',
    ])
);
```

## Next Steps

- [User Management](./09-user-management.md)
- [Balance & Accounting](./10-balance-accounting.md)
