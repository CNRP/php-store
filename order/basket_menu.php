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
        <button id="cart-toggle" onclick="toggleNav()">
          <i class="fa-solid fa-rectangle-xmark"></i>
        </button>
      </div>
      <div class="cart_list">
        <div class="loading" id="loading-cart">
              <div class="loader"></div>
        </div>
        <ul class="cart_items">
          <?php if (isset($_SESSION["cart"])) {
            echo $_SESSION["cart"]->getHTML();
          } ?>
        </ul>
      </div>
      <div class="cart_total">
          <h4>Basket Total </h4>
          <p> £<?php if(isset($_SESSION["cart"])){ echo $_SESSION["cart"]->getCartTotal(); }?></p>
        </div>
      <div class="cart_buttons">
        <a href='?emptyCart=true' class="button load-cart">Empty Basket</a>
        <form action="/order/checkout.php" method="POST">
            <button type="submit" class="button load-cart" id="checkout-button">Checkout</button>
        </form>
      </div>
</section>