<?php

?>

<section id="cart" class="cart_menu">
      <div class="cart_header">
        <h3>
          Basket (
          <?php
            $val = 0;
            if(isset($_SESSION["cart"])){
              $val = sizeof($_SESSION["cart"]->getCart());
            }
            echo $val;
          ?>
          Items)
        </h3>
      </div>
      <div class="cart_list">
        <div class="loading" id="loading-cart">
              <div class="loader"></div>
        </div>
        <ul>
          <?php if (isset($_SESSION["cart"])) {
            echo $_SESSION["cart"]->getHTML();
          } ?>
        </ul>
        <div class="cart_total">
          <h4>Basket Total </h4>
          <p> £<?php if(isset($_SESSION["cart"])){ echo $_SESSION["cart"]->getCartTotal(); }?></p>
        </div>
      </div>
      <div class="cart_buttons">
        <a href='?emptyCart=true' class="button load-cart">Empty Basket</a>
        <form action="/checkout.php" method="POST">
            <button type="submit" class="button load-cart" id="checkout-button">Checkout</button>
        </form>
      </div>
</section>