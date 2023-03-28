<?php
include "php/utils.php";
require_once "../vendor/autoload.php";
require_once "../secrets.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$stripe = \Stripe\Stripe::setApiKey($stripeSecretKey);
if (!isset($_SESSION["stripe-client"])) {
    $_SESSION["stripe-client"] = new \Stripe\StripeClient(
        "sk_test_51Mq0PDHHrXKeMNYFrjwgjhN7ldPHAA4qXL40x65oPxOoQGFOVTqV2GqE8FUBfijbRHGI9pya8LLw7S7he5LtwvZV00PLINpIFi"
    );
}
$stripe = $_SESSION["stripe-client"];

if (isset($_GET["addToCart"])) {
    if (!isset($_SESSION["cart"])) {
        console_log("NEW CART");
        $_SESSION["cart"] = new Cart();
    }

    $_SESSION["cart"]->addToCart($stripe);
}

if (isset($_GET["subtract"])) {
    if (isset($_SESSION["cart"])) {
        $_SESSION["cart"]->remove();
    }
}

if (isset($_GET["add"])) {
    if (isset($_SESSION["cart"])) {
        $_SESSION["cart"]->add();
    }
}

if (isset($_GET["emptyCart"])) {
    $_SESSION["cart"] = new Cart();
}

if (isset($_GET["changeQuantity"])) {
    if (isset($_SESSION["cart"])) {
        $_SESSION["cart"]->setQuantity($_GET["value"]);
    }
}

class Cart
{
    public $products = [];
    public $stripe = [];

    public function getCart()
    {
        return $this->products;
    }

    public function addToCart($stripe)
    {
        if ($stripe !== null) {
            $product = $stripe->products->retrieve($_GET["addToCart"], []);

            $this->products[$_GET["addToCart"]] ??= [
                "id" => $_GET["addToCart"],
                "quantity" => 1,
                "name" => $product["name"],
                "description" => $product["description"],
                "price" => number_format(
                    $stripe->prices->retrieve($product["default_price"])[
                        "unit_amount"
                    ] / 100,
                    2,
                    ".",
                    ""
                ),
                "price-id" => $product["default_price"],
                "image" => $product["images"][0],
                "cart-max" => 5,
            ];
        }
    }

    public function add()
    {
        if (
            $this->products[$_GET["add"]]["quantity"] + 1 <=
            $this->products[$_GET["add"]]["cart-max"]
        ) {
            $this->products[$_GET["add"]]["quantity"]++;
        }
    }

    public function remove()
    {
        if (isset($this->products[$_GET["subtract"]])) {
            if ($this->products[$_GET["subtract"]]["quantity"] <= 1) {
                unset(
                    $this->products[$this->products[$_GET["subtract"]]["id"]]
                );
            } else {
                $this->products[$_GET["subtract"]]["quantity"]--;
            }
        }
    }

    public function setQuantity($val)
    {
        if (isset($this->products[$_GET["changeQuantity"]])) {
            $this->products[$_GET["changeQuantity"]]["quantity"] = (int) $val;
        }
    }

    public function getListItems()
    {
      $checkout_cart = [];
      foreach($this->getCart() as $value){
        array_push($checkout_cart,
        [
          'price' => $value['price-id'],
          'quantity' => $value['quantity'],
        ]
        );
      }
      return $checkout_cart;
    }
}
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

              $cartTotal = 0;
              foreach ($array as $value) {
                // console_log($_SESSION["cart"]->getListItems());
                  $selectOptions = "<select onChange='selectSelected(this.value)'>";
                  for ($i = 1; $i <= $value["cart-max"]; $i++) {
                      $selectOptions .= "
                      <option value='?changeQuantity=" . $value["id"]
                      . "&value=" . $i . "'"
                      . ($i == $value['quantity'] ? ' selected' : '')
                      . ">". $i. "</option>";
                  }
                  $selectOptions .= "</select>";

                  $cartTotal += $value["price"] * $value["quantity"];
                  $html .=
                  '<li>
                    <img src="' . $value["image"] .'">
                    <div class="cart_details">
                        <h5>' .$value["name"] .'</h5>
                        <div class="cart_controls">
                            <p>£' .  $value["price"] * $value["quantity"] .'</p>
                            <div class="cart_quantity">
                                <a class="button load-cart" href="?subtract=' . $value["id"] .'"> - </a>
                                ' . $selectOptions . '
                                <a class="button load-cart" href="?add=' . $value["id"] .'"> + </a>
                            </div>
                        </div>
                    </div>
                  </li>';
              }
              // echo $html;
          } ?>
        </ul>
        <div class="cart_total">
          <h4>Basket Total </h4>
          <p> £</p>
        </div>
      </div>
      <div class="cart_buttons">
        <a href='?emptyCart=true' class="button load-cart">Empty Basket</a>
        <form action="/checkout.php" method="POST">
            <button type="submit" class="button load-cart" id="checkout-button">Checkout</button>
        </form>
      </div>
</section>