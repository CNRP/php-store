<?php

$page_title = "Order Placed";
include '../general/header.php';
require WEBROOT.'/auth/db.php';

try {

  $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
  $line_items = $stripe->checkout->sessions->allLineItems($_GET['session_id'], ['limit' => 5]);

  console_log($line_items);
  $email = mysqli_real_escape_string($mysqli, $session['customer_details']['email']);
  $result = $mysqli->query("SELECT id FROM users WHERE email = '$email'")->fetch_assoc();
  $user_id = $result['id'];
  $order_id = $session['id'];

  $stmt = $mysqli->prepare("SELECT id FROM orders WHERE id = ?");
  $stmt->bind_param("s", $order_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    // order with the same ID already exists, handle the error here
    $error = "Error: Order with ID $order_id already exists.";
  } else {
    $display_id = rand(10000,99999);
    // order with the same ID doesn't exist, insert the new order
    $stmt = $mysqli->prepare("INSERT INTO orders (id, display_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $order_id, $display_id, $user_id);
    if ($stmt->execute()) {
      $error = "New order created successfully.";
    } else {
      $error = "Error creating order: " . $stmt->error;
    }

    foreach ($line_items['data'] as $item) {
      $product_id = $item['price']['product'];
      $quantity = $item['quantity'];
      $price = number_format($stripe->prices->retrieve( $item['price']['id'])['unit_amount'] / 100, 2, '.', '');
      $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, price_value, quantity) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssdi", $order_id, $product_id, $price, $quantity);
      if ($stmt->execute()) {
        $error = "New order created successfully.";
      } else {
        $error = "Error creating order: " . $stmt->error;
      }
    }
  }

} catch (Error $e) {
  echo json_encode(['error' => $e->getMessage()]);
}

  echo '<div class="notification"><p>'.$error.'</p></div>';
?>
  <section class="content">
      <h1>Order Placed!</h1>
      <br>
        <?php 
        foreach ($line_items['data'] as $item) {
          $product_ids[] = $item['price']['product'];
        }
        $product_id_list = implode("', '", $product_ids);
        $sql = "SELECT id, name, description FROM products WHERE id IN ('$product_id_list')";

        console_log($product_ids);
        echo generate_table($sql, $mysqli, false, false);
        ?>
        <p>
          Checkout total: £<?php echo number_format($session['amount_subtotal'] / 100, 2) ?>
        </p>
        <p>
          <br>
          We appreciate you shopping with us! If you have any questions, please <a href="mailto:orders@example.com">get in touch</a>
        </p>
  </section>
<?php include '../general/footer.php' ?>