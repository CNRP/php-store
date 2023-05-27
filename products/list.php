<?php 
$page_title = "Products View";
include '../general/header.php';
include "../auth/session.php";
require '../auth/db.php';


$id = $_SESSION['user']['id'];

    // console_log($array);
    $array = $stripe->products->all(['limit' => 100]);
    foreach ($array as $value) {
        $price_value = number_format($stripe->prices->retrieve($value->default_price)["unit_amount"] / 100,2,".","");
        $updated_at = date_create()->format('Y-m-d H:i:s');
        $stmt = $mysqli->prepare("INSERT INTO products (id, name, description, image_url, default_price, price_value, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), image_url = VALUES(image_url), default_price = VALUES(default_price), updated_at = VALUES(updated_at)");
        $stmt->bind_param('sssssss', $value->id, $value->name, $value->description, $value->images[0], $value->default_price, $price_value, $updated_at);
        if ($stmt->execute()) {
            console_log($value->images[0]);
        }else{
            echo"Failed to update product";
        }
    }
?>
    <div class="content">
        <h2>Your Products</h2>
        <?php
            $data = $mysqli->query("SELECT * FROM `products` ORDER BY `created_at` DESC");
            include "products-table.php";
        ?>
    </div>
<?php include '../general/footer.php'; ?> 