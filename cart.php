<?php
include 'php/utils.php';

session_start();

require_once '../vendor/autoload.php';
require_once '../secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
$stripe = new \Stripe\StripeClient(
  'sk_test_51Mq0PDHHrXKeMNYFrjwgjhN7ldPHAA4qXL40x65oPxOoQGFOVTqV2GqE8FUBfijbRHGI9pya8LLw7S7he5LtwvZV00PLINpIFi'
);

if (isset($_GET['addToCart'])) {
  if (!isset($_SESSION['cart'])){
    console_log("NEW CART");
    $_SESSION['cart'] = new Cart;
  }

  $_SESSION['cart']->addToCart($stripe);
}

if (isset($_GET['subtract'])) {
  if (isset($_SESSION['cart'])){
    $_SESSION['cart']->remove();
  }
}

if (isset($_GET['add'])) {
  if (isset($_SESSION['cart'])){
    $_SESSION['cart']->add();
  }
}


if (isset($_GET['clearCart'])) {
  $_SESSION['cart'] = new Cart;
}

if (isset($_GET['changeQuantity'])) {
  if (isset($_SESSION['cart'])){
    $_SESSION['cart']->setQuantity($_GET['value']);
  }
}




class Cart{
  public $products = array();
  public $stripe = [];

  public function getCart(){
    return $this->products;
  }

  public function addToCart($stripe){
    if($stripe !== null){
      $product = $stripe->products->retrieve(
        $_GET['addToCart'],
        []
      );

      $this->products[$_GET['addToCart']] ??= [
          'id' => $_GET['addToCart'],
          'quantity' => 1,
          'name' => $product['name'],
          'description' => $product['description'],
          'price' => number_format($stripe->prices->retrieve($product['default_price'])['unit_amount'] / 100, 2, '.', ''),
          'image' => $product['images'][0],
          'cart-max' => 5,
      ];
      
    }
  }

  public function add(){
    if($this->products[$_GET['add']]["quantity"] + 1 <= $this->products[$_GET['add']]["cart-max"]){
      $this->products[$_GET['add']]["quantity"]++;
    }
  }

  public function remove(){
    if(isset($this->products[$_GET['subtract']])){
      if($this->products[$_GET['subtract']]['quantity'] <= 1){
        unset($this->products[$this->products[$_GET['subtract']]['id']]);
      }else{
        $this->products[$_GET['subtract']]['quantity']--;
      }
    }
  }

  public function setQuantity($val){
    if(isset($this->products[$_GET['changeQuantity']])){
      $this->products[$_GET['changeQuantity']]['quantity'] = $val;
    }
  }
}

?>

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

              $selectOptions = "";
              for($i = 1; $i <= $value['cart-max']; $i++){
                if($i == $value['quantity']){
                  $selectOptions .= "<option value='?changeQuantity=".$value['id']."&value=".$i."' selected>". $i ."</option>";
                }else{
                  $selectOptions .= "<option value='?changeQuantity=".$value['id']."&value=".$i."'>". $i ."</option>";
                }
              }


              $price = $value['price'];
              $cartTotal += $price * $value['quantity'];
              $html .= '
                <li>
                  <img src="'.$value['image'].'" />
                  <div class="cart_details">
                    <h5>'.$value['name'].'</h5>
                    <div class="cart_controls">

                      <a class="button" href="?subtract='.$value['id'].'"> - </a>
                      <select onChange="if (this.value) window.location.href=this.value">
                        '.$selectOptions.'
                      </select>
                      <a class="button" href="?add='.$value['id'].'"> + </a>

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