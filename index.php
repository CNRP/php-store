<?php 
session_start();

$cart = array();

function addToCart() {
  $cart = array();
  array_push($cart, $_GET['addToCart']);
  echo 'Have a great day'.'<br>';
}


if (isset($_GET['addToCart'])) {
  addToCart();
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
    <section>
      <div class="product">
        <img src="https://i.imgur.com/EHyR2nP.png" alt="The cover of Stubborn Attachments" />
        <div class="description">
          <h3>Stubborn Attachments</h3>
          <h5>$20.00</h5>
        </div>
      </div>
      <form action="/checkout.php" method="POST">
        <!-- <button type="submit" id="checkout-button">Checkout</button> -->
        <a href='?addToCart=id1'>Execute PHP Function</a>
      </form>
    </section>

    <script src="script.js"></script>
  </body>
</html>S