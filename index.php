<?php 
include 'cart.php';

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
$stripe = new \Stripe\StripeClient(
  'sk_test_51Mq0PDHHrXKeMNYFrjwgjhN7ldPHAA4qXL40x65oPxOoQGFOVTqV2GqE8FUBfijbRHGI9pya8LLw7S7he5LtwvZV00PLINpIFi'
);


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
            <div class="loading" id="loading-'.$value['id'].'">
              <div class="loader"></div>
            </div>
            <div class="description">
              <img src="'.$value['images'][0].'" alt="The cover of Stubborn Attachments" />
                <h3>'.$value['name'].'</h3>
                <p>'.$value['description'].'</p>
            </div>
            <div class="cart">
              <h5>£'. $price .'</h5>
              <a class="add_to_cart button load-clicked" data-product="'.$value['id'].'" href="?addToCart='.$value['id'].'">Add to cart</a>
            </div>
          </div>
        ';
      }
      echo $html;

      ?>
    </section>
    <script src="script.js"></script>
  </body>
</html>