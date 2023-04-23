<?php 
if (isset($_SESSION["cart"] )) {
  $_SESSION["cart"] = new Cart();
}


$page_title = "Order Placed";
include 'php/header.php';

?>
  <section class="page-container">
    <div class="form-container">
      <p>
        We appreciate your business! If you have any questions, please email
        <a href="mailto:orders@example.com">orders@example.com</a>
      </p>
    </div>
  </section>
<?php include 'php/footer.php' ?>