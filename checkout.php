<?php
include 'cart.php';

session_start();

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$stripe = new \Stripe\StripeClient(
  'sk_test_51Mq0PDHHrXKeMNYFrjwgjhN7ldPHAA4qXL40x65oPxOoQGFOVTqV2GqE8FUBfijbRHGI9pya8LLw7S7he5LtwvZV00PLINpIFi'
);

$YOUR_DOMAIN = 'http://localhost:4242';
$checkout_cart = [];

if (isset($_SESSION['cart'])){
  $array = $_SESSION['cart']->getCart();
  $checkout_cart = [];
  foreach($array as $key => $item){
    $price = $stripe->products->retrieve(
      $key,
      []
    );
    array_push($checkout_cart,
    [
      'price' => $price['default_price'],
      'quantity' => $item['quantity'],
    ]
    );
  }
}

$items = [
  'line_items' => $checkout_cart,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.html',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
];

$checkout_session = \Stripe\Checkout\Session::create($items);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);