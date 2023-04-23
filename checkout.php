<?php
include 'php/utils.php';
include "basket.php";
require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');


$stripe = $_SESSION['stripe-client'];

$YOUR_DOMAIN = 'http://localhost/';
$checkout_cart = [];

if (isset($_SESSION['cart'])){
  $checkout_cart = $_SESSION['cart']->getListItems();
}

$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $checkout_cart,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . 'order-placed.php',
  'cancel_url' => $YOUR_DOMAIN . 'order-canceled.php',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);