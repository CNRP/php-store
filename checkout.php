<?php

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4242';

$cart = [
  [
    'price' => 'price_1Mq0j6HHrXKeMNYF54hEQEgE',
    'quantity' => 2,
  ],
  [
    'price' => 'price_1Mq0gCHHrXKeMNYFaie5dLi4',
    'quantity' => 1,
  ]
];

$items = [
  'line_items' => $cart,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
];

$checkout_session = \Stripe\Checkout\Session::create($items);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);