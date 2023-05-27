<?php

$page_title = "Search for product";
include '../general/header.php';
require '../auth/db.php';
include '../general/navigation.php';

    $results = [];
    if (isset($_GET["search"])) {
        $search_string = "%".$_GET["search"]."%";
        $stmt  = $mysqli->prepare("SELECT * FROM `products` WHERE name LIKE ? or description LIKE ?");
        $stmt->bind_param("ss", $search_string, $search_string);
        if($stmt->execute()){
            $results = $stmt->get_result();
        }
    }else{
        $results = $mysqli->query("SELECT * FROM `products`");
    }
    ?>
    <section class="products">
        <h1>Featured Products</h1>
        <?php
        foreach ($results as $value) {            
            $price = number_format($stripe->prices->retrieve($value['default_price'])['unit_amount'] / 100, 2, '.', '');
        ?>
        <div class="product">
            <div class="loading" id="loading-<?php echo $value['id'] ?>">
                <div class="loader"></div>
            </div>
            <div class="description">
                <img src="<?php echo $value['image_url'] ?>" alt="<?php echo $value['name'] ?> Shoe" />
                <h3><?php echo $value['name'] ?></h3>
                <p><?php echo $value['description'] ?></p>
            </div>
            <h5>£<?php echo $price ?></h5>
            
            <?php             
            $cart_controls = '';
            if(isset($_SESSION['cart'])){
                if(!$_SESSION['cart']->inCart($value['id'])){

                ?>  
                <div class="cart_buttons flex-center">
                    <a class="add_to_cart button load-add" href="product.php?id=<?php echo $value['id'] ?>">See More</a>
                    <a class="add_to_cart button load-add" data-product="<?php echo $value['id'] ?>" href="?addToCart=<?php echo $value['id'] ?>">
                        <i class="fa-solid fa-plus"></i><i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </div>
                <?php

                }else{
                    $item = $_SESSION['cart']->getItem($value['id']);
                    $max = isset($item['cart-max']) ? $item['cart-max'] : 5;
                    ?>
                    <div class="cart_buttons flex-center">
                        <a class="add_to_cart button load-add" href="product.php?id=<?php echo $value['id'] ?>">See More</a>
                        <div class="cart_quantity">
                            <a class="button load-add" href="?subtract=<?php echo $value['id'] ?>" data-product="<?php echo $value['id'] ?>"> 
                                <i class="fa-solid fa-minus"></i> 
                            </a>
                            <select onChange="console.log(this.value)">
                            <?php 
                                for ($i = 1; $i <= $max; $i++) {
                                    echo "<option value='?changeQuantity=" . $value["id"]. "&value=" . $i . "'". ($i == $item['quantity'] ? ' selected' : ''). ">". $i. "</option>";
                                }
                            ?>
                            </select>
                            <a class="button load-add" href="?add=<?php echo $value['id'] ?>" data-product="<?php echo $value['id'] ?>"> 
                                <i class="fa-solid fa-plus"></i> 
                            </a>
                        </div>
                    </div>';
                <?php 
                } 
            } ?>
        </div>
        <?php } ?>
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