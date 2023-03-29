<?php

  include 'cart-menu.php';

if (isset($_GET["id"])) {
    $product = $stripe->products->retrieve(
        $_GET["id"],
        []
      );
    $_SESSION["product-page"] = $product;
}else if(isset($_SESSION["product-page"])){
    $product = $_SESSION["product-page"];
}
else{
    $product = $stripe->products->all(['limit' => 1])['data'][0];
}

$price = number_format($stripe->prices->retrieve($product['default_price'])['unit_amount'] / 100, 2, '.', '');

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
        <style>
            .product-page{
                background-color: white;
                max-width: 60%;
                margin-inline: auto;
                padding: 2em;
                margin-block: 4em;
                display: flex;
                flex-wrap: wrap;
            }

            .product-page .left, .product-page .right{
                width: 50%;
                padding-block: 2em;
            }

            .product-page .right{
                padding-left: 2em;
            }

            .product-page .product-title{
                font-size: 2rem;
                width: 100%;
            }

            .product-page p{
                font-size: 1.2rem;
                margin-block: 2em;
            }

            .product-page img{
                width: 100%;
            }

            .product-page .tags{
                width: 100%;
                list-style: none;
                display: flex;
                padding: 0.5em;
                background-color: #f1f1f1;
            }

            .product-page .tags li{
                margin-inline: 0.25em;
                border-radius: 5px;
                opacity: 0.8;
                padding: 0.5em;
            }

            .product-page .button{
                margin-block: 2em;
            }


        </style>
        <section class="product-page">
            <?php

            $meta = $product['metadata']['colours'];
            $colours = str_replace(' ', '', explode(',', $meta));

            $tags = "";
            foreach ($colours as $colour) {
                $tags .= '<li style="background-color: '. $colour .';"></li>';
            }

            console_log($colours);
                $html =
                '
                <h1 class="product-title">'. $product['name'] .'</h1>
                <div class="left">
                    <img src="'. $product['images'][0] .'" alt="">
                    <h3>Filters:</h3>
                    <ul class="tags">
                        '. $tags .'
                    </ul>
                </div>
                <div class="right">
                    <p class="product-description">'. $product['description'] .'</p>
                    <p class="product-price">£'.$price .'</p>
                    <a class="add_to_cart button load-add" data-product="'.$product['id'].'" href="?addToCart='.$product['id'].'">Add to cart</a>
                </div>';

                echo $html;
            ?>
        </section>
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
        <script src="script.js"></script>
    </body>
</html>