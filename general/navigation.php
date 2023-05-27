<section class="navigation">
    <ul>
        <li><h2>SHOESTORE</h2></li>
        <li><a href="/index.php">Home</a></li>
        <li><a href="/index.php">Products</a></li>
        <li><a href="/index.php">Support</a></li>
    </ul>
    <?php if(isset($_SESSION['user'])){?>
            <button onclick="window.location.href='/account.php';" class="nav-btn" onclick="toggleNav()">
                <p>Account <i class="fa-solid fa-user"></i></p>
            </button>
    <?php }else {?>
            <button onclick="window.location.href='/auth/login.php';" class="nav-btn" onclick="toggleNav()">
                <p>Login <i class="fa-solid fa-user"></i></p>
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