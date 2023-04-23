<?php 
include 'php/header.php';
include "auth/session.php";
include "support/tickets-table.php";
require 'auth/db.php';

$id = $_SESSION['user']['id'];
$tickets = $mysqli->query("SELECT * FROM `tickets` WHERE user_id=$id ORDER BY `status`='pending' DESC, `created_at` ASC");

$page_title = "Account View";


?>
    <div class="content">
        <h3>Hey, <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']; ?>!</h3>
        <h4><a href="">Show account details</a></h4>
        <p>Email: <span class="censor"> <?php echo $_SESSION['user']['email'] ?> </span></p>
        <p>Account Created: <span class="censor"> <?php echo $_SESSION['user']['created_at']?></span></p>
        <h2>Your Orders</h2>

        <h2>Your support tickets</h2>
        <?php echo get_table_html($tickets); ?>

        <a class="button" href="/auth/logout.php">Logout</a>
        <?php if($_SESSION['user']['user_type'] == 2){ ?>
            <br>
            <a href="/support/tickets-overview.php" class="button">All Tickets</a>
            <a href="/orders/products.php" class="button">Refresh Products</a>
        <?php } ?>
    </div>
<?php include 'php/footer.php';?>