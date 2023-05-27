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

        
    </div>
<?php include '../general/footer.php';?>