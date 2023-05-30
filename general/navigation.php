<section class="navigation">
    <ul>
        <li><h2>SHOESTORE</h2></li>
        <li><a href="/index.php">Home</a></li>
        <li><a href="/products/query.php">Products</a></li>
        <li><a href="/support/new-ticket.php">Support</a></li>
    </ul>
    <?php if(isset($_SESSION['user'])){?>
            <button onclick="window.location.href='/account.php';" class="nav-btn" onclick="toggleNav()">
                <p><i class="fa-solid fa-user"></i></p>
            </button>
    <?php }else {?>
            <button onclick="window.location.href='/auth/login.php';" class="nav-btn" onclick="toggleNav()">
                <p><i class="fa-solid fa-right-to-bracket"></i></p>
            </button>
    <?php }?>
</section>

<button id="cart-toggle" onclick="toggleNav()">
        <?php
            $val = 0;
            if(isset($_SESSION["cart"])){
            $val = sizeof($_SESSION["cart"]->getCart());
            }
            echo $val;
        ?>
        <i class="fa-solid fa-cart-shopping"></i>
</button>

<div class="cart-alert added">
    <h1>Added to cart</h1>
</div>
<script>
function addToCart() {
  var cartAlert = document.querySelector('.cart-alert');
  cartAlert.style.display = 'block';
  setTimeout(function() {
    cartAlert.style.display = 'none';
  }, 5000); // 5000 milliseconds = 5 seconds
}
</script>
<?php if (isset($_GET["addToCart"])): ?>
    <script>addToCart()</script>
<?php endif; ?>


<a href="https://connorprice.info/" style="text-decoration: none; color: black; font-weight: bold; position: fixed; bottom: 1em; left: 1em; background-color: white; padding: 1em 2em;"><i class="fa-solid fa-arrow-left"></i> back to connorprice.info</a>