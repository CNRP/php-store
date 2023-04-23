<section class="navigation">
    <ul>
        <li><a href="/index.php">Home</a></li>
    </ul>
    <div class="right">
        <form action="/search.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
        <button id="cart-toggle" onclick="toggleNav()">
            <p>
            <?php
                $val = 0;
                if(isset($_SESSION["cart"])){
                $val = sizeof($_SESSION["cart"]->getCart());
                }
                echo $val;
            ?> Item(s)<i class="fa-solid fa-cart-shopping"></i>
            </p>  
        </button>
        <?php if(isset($_SESSION['user'])){?>
            <button style="margin-left: 10px;" onclick="window.location.href='/account.php';" id="cart-toggle" class="" onclick="toggleNav()">
                <p>Account <i class="fa-solid fa-user"></i></p>
            </button>
        <?php }else {?>
            <button style="margin-left: 10px;" onclick="window.location.href='/auth/login.php';" id="cart-toggle" class="" onclick="toggleNav()">
                <p>Login <i class="fa-solid fa-user"></i></p>
            </button>
        <?php }?>
    </div>
</section>
