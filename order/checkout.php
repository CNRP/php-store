<?php

include '../general/utils.php';
include "basket.php";

header('Content-Type: application/json');
$stripe = $_SESSION['stripe-client'];

$YOUR_DOMAIN = 'http://store.localhost/';
$checkout_cart = [];

if (isset($_SESSION['cart'])){
  $cart_items = $_SESSION['cart']->getListItems();
  $checkout = [
    'line_items' => $cart_items,
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'order/placed.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => $YOUR_DOMAIN . 'order/cancelled.php',
  ];
  $checkout_session = \Stripe\Checkout\Session::create($checkout);
  
  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
}
