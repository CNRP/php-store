<?php

  include 'cart-menu.php';

if (isset($_GET["search"])) {
    $results = [];
    $results = array_merge($results,(array) $stripe->products->search(['query' => 'name:\''.$_GET["search"].'\''])['data']);
    $results = array_merge($results, (array) $stripe->products->search(['query' => 'description:\''.$_GET["search"].'\''])['data']);
    $results = array_unique($results);
    // console_log($results);
}else if(isset($_SESSION["search"])){
    $results = $_SESSION["search"];
}
else{
    $results = $stripe->products->all(['limit' => 1])['data'][0];
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="assets/fa/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
  </head>
    <body>
        <?php include 'php/navigation.php' ?>
        <section class="products">
        <h1>Featured Products</h1>
        <?php
            $html = "";
            // console_log($_SESSION['cart']->inCart());

            foreach ($results as $value) {
            $price = number_format($stripe->prices->retrieve($value['default_price'])['unit_amount'] / 100, 2, '.', '');
            $cart_controls = '';
            if(isset($_SESSION['cart'])){
                if(!$_SESSION['cart']->inCart($value['id'])){
                $cart_controls = '
                <div class="cart_buttons flex-center">
                    <a class="add_to_cart button load-add" href="product.php?id='.$value['id'].'">See More</a><a class="add_to_cart button load-add" data-product="'.$value['id'].'" href="?addToCart='.$value['id'].'"><i class="fa-solid fa-plus"></i><i class="fa-solid fa-cart-shopping"></i></a>
                </div>';
                }else{
                $selectOptions = "";
                $item = $_SESSION['cart']->getItem($value['id']);

                $max = 5;
                if(isset($item['cart-max'])){
                    $max = $item['cart-max'];
                }
                // console_log($item['cart-max']);
                for ($i = 1; $i <= $max; $i++) {
                    $selectOptions .= "<option value='?changeQuantity=" . $value["id"]. "&value=" . $i . "'". ($i == $item['quantity'] ? ' selected' : ''). ">". $i. "</option>";
                }

                $cart_controls = '
                <div class="cart_buttons flex-center">
                    <a class="add_to_cart button load-add" href="product.php?id='.$value['id'].'">See More</a>
                    <div class="cart_quantity">
                        <a class="button load-add" href="?subtract=' . $value["id"] .'"  data-product="'.$value['id'].'" > <i class="fa-solid fa-minus"></i> </a>
                        <select onChange="selectSelected(this.value)">
                        ' . $selectOptions . '
                        </select>
                        <a class="button load-add" href="?add=' . $value["id"] .'"  data-product="'.$value['id'].'" > <i class="fa-solid fa-plus"></i> </a>
                    </div>
                </div>';
                }
            }

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
                <h5>£'. $price .'</h5>
                '.$cart_controls.'
                </div>
            ';
            }
            echo $html;
        ?>
        <script>
            function selectSelected(value){
            loadCart();
            if (value) window.location.href=value;
            }

            function loadCart(){
            var loading = document.getElementById("loading-cart");
            loading.classList.add('show');
            }
        </script>

        </section>
        <script src="script.js"></script>
    </body>
</html>