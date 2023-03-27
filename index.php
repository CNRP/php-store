<?php 
include 'cart.php';
session_start();

function console_log($output, $with_script_tags = true) {
  $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
  if ($with_script_tags) {
      $js_code = '<script>' . $js_code . '</script>';
  }
  echo $js_code;
}

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
$stripe = new \Stripe\StripeClient(
  'sk_test_51Mq0PDHHrXKeMNYFrjwgjhN7ldPHAA4qXL40x65oPxOoQGFOVTqV2GqE8FUBfijbRHGI9pya8LLw7S7he5LtwvZV00PLINpIFi'
);

if (isset($_GET['addToCart'])) {
  if (!isset($_SESSION['cart'])){
    $cart = $_SESSION['cart'] = new Cart;
  }

  $_SESSION['cart']->add($stripe);
}

if (isset($_GET['subtractFromCart'])) {
  if (isset($_SESSION['cart'])){
    $_SESSION['cart']->remove();
  }
}


if (isset($_GET['clearCart'])) {
  unset($_SESSION['cart']);
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    
    <section class="products">
      <h1>Featured Products</h1>
      <?php
      $html = "";

      $array = $stripe->products->all();
      foreach ($array as $value) {
        // console_log($value);
        $price = number_format($stripe->prices->retrieve($value['default_price'])['unit_amount'] / 100, 2, '.', '');
        $html .= '
          <div class="product">
            <div class="description">
              <img src="'.$value['images'][0].'" alt="The cover of Stubborn Attachments" />
                <h3>'.$value['name'].'</h3>
                <p>'.$value['description'].'</p>
            </div>
            <div class="cart">
              <h5>£'. $price .'</h5>
              <a class="add_to_cart button" href="?addToCart='.$value['id'].'">Add to cart</a>
            </div>
          </div>
        ';
      }
      echo $html;

      ?>
    </section>
    <section class="cart_menu">
      <div class="cart_list">
        <ul>
          <?php
          $cartTotal = 0;
          if (isset($_SESSION['cart'])) {
            // console_log("CART SET");
            $array = $_SESSION['cart']->getCart();
            $html = "";
            
            $cartTotal = 0;
            foreach ($array as $value) {
              // console_log($value);

              $price = $value['price'];
              $cartTotal += $price * $value['quantity'];
              $html .= '
                <li>
                  <img src="'.$value['image'].'" />
                  <div class="cart_details">
                    <h5>'.$value['name'].'</h5>
                    <div class="cart_controls">
                      <a class="button" href="?subtractFromCart='.$value['id'].'"> - </a>
                      <p>' .$value['quantity']. '</p>
                      <a class="button" href="?addToCart='.$value['id'].'"> + </a>
                      <p> £' .$price * $value['quantity'] . '</p>
                    </div>
                  </div>
                </li>
              ';
            }
            echo $html;
          }
          ?>
        </ul>
        <div class="cart_total">
          <h4>Basket Total </h4>
          <p> £<?php echo $cartTotal; ?></p>
        </div>
      </div>
      <div class="cart_buttons">
        <a href='?clearCart=true' class="button">Clear Cart</a>
        <form action="/checkout.php" method="POST">
            <button type="submit" class="button" id="checkout-button">Checkout</button>
        </form>
      </div>
    </section>
    <script src="script.js"></script>
  </body>
</html>