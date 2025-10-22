<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\Shipit\Connector\ShipitConnector;
use Cline\Shipit\Data\ParcelData;
use Cline\Shipit\Data\PartyData;
use Cline\Shipit\Data\Responses\ShipmentResponseData;
use Cline\Shipit\Data\ShipmentRequestData;
use Cline\Shipit\Data\ShippingMethodsRequestData;

test('can get agents', function (): void {
    $connector = ShipitConnector::test(env('SHIPIT_API_KEY'));

    $response = $connector->agents()->get([
        'postcode' => '00100',
        'country' => 'FI',
        'serviceId' => [
            'posti.po2103',
            'mh.mh80',
        ],
        'type' => 'parcel_locker',
    ]);

    $data = $response->toArray();
    $data['locations'] = collect($data['locations'])->sortBy('id')->values()->all();

    expect($data)->toMatchSnapshot();
})->skip(fn (): bool => empty(getenv('SHIPIT_API_KEY')), 'SHIPIT_API_KEY is not set in the environment.');

test('can list shipping methods', function (): void {
    $connector = ShipitConnector::test(env('SHIPIT_API_KEY'));

    $response = $connector->shippingMethods()->list();

    $data = $response->toArray();
    $data['data'] = collect($data['data'])->sortBy('serviceId')->values()->all();

    expect($data)->toMatchSnapshot();
})->skip(fn (): bool => empty(getenv('SHIPIT_API_KEY')), 'SHIPIT_API_KEY is not set in the environment.');

test('can get shipping methods', function (): void {
    $connector = ShipitConnector::test(env('SHIPIT_API_KEY'));

    $sender = PartyData::from([
        'postcode' => '00100',
        'country' => 'FI',
        'name' => 'Test Sender',
        'email' => 'sender@test.com',
        'phone' => '+358401234567',
        'address' => 'Test Street 1',
        'city' => 'Helsinki',
    ]);

    $receiver = PartyData::from([
        'postcode' => '112 22',
        'country' => 'SE',
        'name' => 'Test Receiver',
        'email' => 'receiver@test.com',
        'phone' => '+46701234567',
        'address' => 'Test Gatan 1',
        'city' => 'Stockholm',
    ]);

    $parcel = ParcelData::from([
        'type' => 'PACKAGE',
        'length' => 15,
        'width' => 15,
        'height' => 15,
        'weight' => 1,
        'copies' => 1,
    ]);

    $request = ShippingMethodsRequestData::from([
        'sender' => $sender,
        'receiver' => $receiver,
        'parcels' => [$parcel],
    ]);

    $response = $connector->shippingMethods()->get($request);

    $data = $response->toArray();
    $data['methods'] = collect($data['methods'])->sortBy('serviceId')->values()->all();

    expect($data)->toMatchSnapshot();
})->skip(fn (): bool => empty(getenv('SHIPIT_API_KEY')), 'SHIPIT_API_KEY is not set in the environment.');

test('can create shipment with api', function (): void {
    $connector = ShipitConnector::test(env('SHIPIT_API_KEY'));

    $sender = PartyData::from([
        'name' => 'Wayne Enterprises Oy',
        'email' => fake()->safeEmail(),
        'phone' => '+358405557890',
        'address' => 'Vantaankoskentie 14',
        'city' => 'Vantaa',
        'postcode' => '01730',
        'country' => 'FI',
        'address2' => '',
        'state' => 'Uusimaa',
        'isCompany' => true,
        'contactPerson' => 'Bruce Wayne',
        'vatNumber' => 'FI23456789',
    ]);

    $receiver = PartyData::from([
        'name' => 'Ha-Ha Chemicals Oy',
        'email' => fake()->safeEmail(),
        'phone' => '+358509876543',
        'address' => 'Hämeenkatu 10',
        'city' => 'Tampere',
        'postcode' => '33100',
        'country' => 'FI',
        'address2' => '',
        'state' => 'Pirkanmaa',
        'isCompany' => true,
        'contactPerson' => 'Jack Napier',
        'vatNumber' => 'FI87654321',
    ]);

    $parcel = ParcelData::from([
        'type' => 'PACKAGE',
        'length' => 15,
        'width' => 15,
        'height' => 15,
        'weight' => 1,
        'copies' => 1,
    ]);

    $shipmentRequest = ShipmentRequestData::from([
        'sender' => $sender,
        'receiver' => $receiver,
        'parcels' => [$parcel],
        'serviceId' => 'posti.po2103',
        'contents' => 'Electronic components and accessoriesss',
        'freeText' => 'Handle with care - Contains electronic components',
        'reference' => 'ORD-2023-12345',
        'externalId' => 'EXT-2023-12345',
        'inventory' => 'INV-LOC-HEL-001',
        'sendOrderConfirmationEmail' => false,
    ]);

    $response = $connector->shipments()->create($shipmentRequest);

    expect($response)->toBeInstanceOf(ShipmentResponseData::class);
})->skip(fn (): bool => empty(getenv('SHIPIT_API_KEY')), 'SHIPIT_API_KEY is not set in the environment.');
