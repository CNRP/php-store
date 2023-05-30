<?php
include "../general/header.php";

//include auth_session.php file on all user panel pages
include "../auth/session.php";

// $data = $mysqli->query("SELECT * FROM `orders` WHERE id='" . $_GET["id"] . "' ORDER BY `created_at` DESC");
// $ticket = $data->fetch_assoc();
$user_id = $_SESSION["user"]["id"];
// $url = "?id=" . $ticket['id'];

?>

    <div class="content">
        <h1>Your Order</h1>

        <?php
        $buttons = generate_action_button("", "order/view.php", "fa-right-from-bracket") . generate_action_button("", "hello", "fa-trash"); 
        echo generate_table("SELECT id, display_id, created_at, status FROM `orders` WHERE id='".$_GET["id"]."' ORDER BY `created_at` ASC", $mysqli, false, $buttons);

        ?>
        <div class="card-grid">
        <?php

        $stmt = $mysqli->prepare("SELECT product_id FROM order_items WHERE order_id = ?");
        $stmt->bind_param("s", $_GET["id"]);
        $stmt->execute();
        $stmt->bind_result($productId);

        $count = 0;
        $product_ids = [];
        while ($stmt->fetch()) {
            // Access the product_id for each row
            array_push($product_ids, $productId);
            $count++;
        }
        if($count == 0){
            $line_items = $stripe->checkout->sessions->allLineItems($_GET["id"]);
            foreach ($line_items['data'] as $item) {
                $product_id = $item['price']['product'];
                $quantity = $item['quantity'];
                $price = number_format($stripe->prices->retrieve( $item['price']['id'])['unit_amount'] / 100, 2, '.', '');
                $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price_value, quantity) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssdi", $_GET["id"], $product_id, $price, $quantity);
                $stmt->execute();
            }
        }
        console_log($product_ids);

        foreach ($product_ids as $product_id) {
            $product = $stripe->products->retrieve(
                $product_id,
                []
              );
            console_log($product['id']);
        $price = number_format($stripe->prices->retrieve($product['default_price'])['unit_amount'] / 100, 2, '.', '');
      ?>
        <div class="featured-product-card">
          <div class="product">
              <div class="loading" id="<?php echo 'loading-'.$product['id'] ?>">
                <div class="loader"></div>
              </div>
              <div class="description">
                <img src="<?php echo $product['images'][0] ?>" alt="The cover of Stubborn Attachments" loading="lazy"/>
                  <h3><?php echo $product['name'] ?></h3>
                  <p><?php echo $product['description'] ?></p>
              </div>
              <h5>£<?php echo $price ?></h5>
          </div>
        </div>
      <?php
        }
      ?>
      </div>
    </div>
        

<?php include '../general/footer.php';?>