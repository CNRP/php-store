<section class="navigation">
    <ul>
        <li><a href="index.php">Home</a></li>
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
    </div>
</section>

<script>
    function toggleNav() {
        console.log("YTOOYOO")
        var element = document.getElementById("cart");
        element.classList.toggle("visible");
    }
</script>

<style>
.cart_menu{
    margin-top: 2em;
    opacity: 0;
    transform: translateX(200%);
    transition: all 0.5s ease-in-out;
}

.visible{
    transform: translateX(0);
    opacity: 1;
}

.navigation{
    top:0;
    left:0;
    z-index: 5;
    position: fixed;
    width: 100%;
    background-color: white;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #cccccc;
}

.navigation ul{
    width: 100%;
    display: flex;
    justify-content: center;
    margin-block: 1em;
}


.navigation .right{
    display: flex;
    margin-inline: 1em;
    padding-block: 0.4em;
}

.navigation .right form{
    display: flex;
}

.navigation .right form input{
    border-radius: 5px;
    border: 1px solid rgb(226, 226, 226);
    display: flex;
    background-color: #f1f1f1;
    padding-inline: 1em;
    border-top-right-radius: 0px;
    border-bottom-right-radius: 0px;
}

.navigation .right form button{
    text-align: center;
    margin-right: 1em;
    border-top-left-radius: 0px;
    border-bottom-left-radius: 0px;
}

#cart-toggle p{
    min-width: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.navigation button{
    font-size: 1rem;
    padding: 0.4em;
    border-radius: 5px;
    background-color: var(--button-colour);
    border: 1px solid rgb(226, 226, 226);
    color: green;
}

.navigation button:hover{
    background-color: #f4f4f4;
}

.navigation button p{
    display: flex;
}

.navigation #cart-toggle i{
    color: black;
    margin-left: 0.5em;
}
</style>