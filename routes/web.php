<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $token = '<INSERT-YOUR-API-TOKEN>';

    $events = Http::withToken($token)->get('https://api.nuwebgroup.com/v1/events', ['limit' => 4])->json();

    $data = [];

    foreach ($events['events'] as $event) {
        $eventTickets = Http::withToken($token)->get('https://api.nuwebgroup.com/v1/event-tickets', ['eventId' => $event['id']])->json();
        $data[] = [
            'event' => $event,
            'timeslots' => $eventTickets['timeslots'],
            'tickets' => $eventTickets['tickets']
        ];
    }

    return view('welcome', ['data' => $data]);
});

Route::get('/buy/{ticketId}', function ($ticketId) {
    $token = '<INSERT-YOUR-API-TOKEN>';

    $basket = Http::withToken($token)->post('https://api.nuwebgroup.com/v1/basket-items', [
        'items' => [
            ['id' => $ticketId, 'quantity' => 1],
            // ..
        ]
    ])->json();

    // Before the next call, you can add/remove/update items in the basket, collect customer info and process a payment.

    $orderId = $basket['id'];
    Http::withToken($token)->post('https://api.nuwebgroup.com/v1/orders/complete', [
        'basketId' => $orderId,
        'paymentMethod' => 'cash',
        'customerEmail' => 'joseph.rushton@nutickets.com',
        'customerName' => 'Joseph Rushton',
    ])->json();

    $order = Http::withToken($token)->get('https://api.nuwebgroup.com/v1/order', [
        'orderId' => $orderId,
    ])->json();

    session()->flash('success', "Item purchased successfully, order ref {$order['reference']}!");
    return back();
});
