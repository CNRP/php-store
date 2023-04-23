<?php
require_once dirname(WEBROOT)."/vendor/autoload.php";
require_once dirname(WEBROOT)."/secrets.php";
require WEBROOT.'/auth/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION["cart"] = new Cart();
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
        $_SESSION["cart"] = new Cart();
    }

    $_SESSION["cart"]->addToCart($mysqli);
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

    public function addToCart($mysqli)
    {
        if ($mysqli !== null) {
            $stmt = $mysqli->prepare("SELECT * FROM `products` WHERE `id`=?");
            $stmt->bind_param("s", $_GET["addToCart"]);
            // Execute query
            if ($stmt->execute()) {
                $result = mysqli_stmt_get_result($stmt);
                while ($product = mysqli_fetch_assoc($result)){
                    console_log($stmt);
                    $this->products[$_GET["addToCart"]] ??= [
                        "id" => $_GET["addToCart"],
                        "quantity" => 1,
                        "name" => $product["name"],
                        "description" => $product["description"],
                        "price" => $product["price_value"],
                        "price-id" => $product["default_price"],
                        "image" => $product["image_url"],
                        "cart-max" => 5,
                    ];
                }
            }
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
    public function getCartTotal(){
        $total = 0;
        foreach ($this->products as $value) {
            $total += $value['quantity'] * $value['price'];
        }
        return $total;
    }

    public function getHTML(){
        $html = "";
        foreach ($this->products as $value) {
            $selectOptions = "";
            for ($i = 1; $i <= $value["cart-max"]; $i++) {
                $selectOptions .= "<option value='?changeQuantity=" . $value["id"]. "&value=" . $i . "'". ($i == $value['quantity'] ? ' selected' : ''). ">". $i. "</option>";
            }

            $html .=
            '<li>
              <img src="' . $value["image"] .'">
              <div class="cart_details">
                  <h5>' .$value["name"] .'</h5>
                  <div class="cart_controls">
                      <p>£' .  $value["price"] * $value["quantity"] .'</p>
                      <div class="cart_quantity">
                          <a class="button load-cart" href="?subtract=' . $value["id"] .'"> <i class="fa-solid fa-minus"></i> </a>
                            <select onChange="selectSelected(this.value)">
                            ' . $selectOptions . '
                            </select>
                          <a class="button load-cart" href="?add=' . $value["id"] .'"> <i class="fa-solid fa-plus"></i> </a>
                      </div>
                  </div>
              </div>
            </li>';
        }
        return $html;
    }

    public function inCart($id){
        return array_key_exists($id, $this->products);
    }

    public function getItem($id){
        return $this->products[$id];
    }
}    

include WEBROOT.'/basket_menu.php'; 
?>