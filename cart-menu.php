<?php
include "php/utils.php";
include "cart-processing.php";
?>

<section class="cart_menu">
      <div class="cart_list">
        <ul>
          <div class="loading" id="loading-cart">
            <div class="loader"></div>
          </div>
          <?php if (isset($_SESSION["cart"])) {
              $array = $_SESSION["cart"]->getCart();
                $html = "<li><h3>Basket (" . sizeof($array) . " Items)</h3></li>";
                echo $_SESSION["cart"]->getHTML();
          } ?>
        </ul>
        <div class="cart_total">
          <h4>Basket Total </h4>
          <p> £<?php echo $_SESSION["cart"]->getCartTotal() ?></p>
        </div>
      </div>
      <div class="cart_buttons">
        <a href='?emptyCart=true' class="button load-cart">Empty Basket</a>
        <form action="/checkout.php" method="POST">
            <button type="submit" class="button load-cart" id="checkout-button">Checkout</button>
        </form>
      </div>
</section>