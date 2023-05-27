<?php 
$page_title = "Account View";
include 'general/header.php';
include "auth/session.php";
include "support/tickets-table.php";
include 'order/table.php';

$id = $_SESSION['user']['id'];

$page_title = "Account View";
?>
    <div class="content">
        <h3>Hey, <?php echo $_SESSION['user']['first_name']." ".$_SESSION['user']['last_name']; ?>!</h3>
        <h4><a href="">Show account details</a></h4>
        <p>Email: <span class="censor"> <?php echo $_SESSION['user']['email'] ?> </span></p>
        <p>Account Created: <span class="censor"> <?php echo $_SESSION['user']['created_at']?></span></p>
        <h2>Your Orders</h2>
        <?php 
            $buttons = generate_action_button("", "order/view.php", "fa-right-from-bracket") . generate_action_button("", "hello", "fa-trash"); 
            echo generate_table("SELECT id, display_id, created_at, status FROM `orders` WHERE user_id=$id ORDER BY `created_at` ASC", $mysqli, true, false)?>


            $array = $stripe->Orders
        <h2>Your support tickets</h2>
        
        <?php 
            $buttons = generate_action_button("", "support/ticket.php", "fa-right-from-bracket") . generate_action_button("", "hello", "fa-trash");
            echo generate_table("SELECT * FROM `tickets` WHERE user_id=$id ORDER BY `status`='pending' DESC, `created_at` ASC", $mysqli, false, $buttons); 
        ?>

        <a class="button" href="/auth/logout.php">Logout</a>
        <?php if($_SESSION['user']['user_type'] == 2){ ?>
            <br>
            <a href="support/tickets-overview.php" class="button">All Tickets</a>
            <a href="products/list.php" class="button">Refresh Products</a>
        <?php } ?>
    </div>

<script>
  // Get all the expand buttons in the table
  const tableActionButtons = document.querySelectorAll('.action-button');

  // Add a click event listener to each button
  tableActionButtons.forEach(button => {
    button.addEventListener('click', () => {
      // Get the ID of the table from the data-table-id attribute of the parent tr element
      const tableId = button.closest('tr').getAttribute('data-table-id');

    // Construct the URL with the table ID as a parameter
    //   const url = `/expanded-view.html?tableId=${tableId}`;
    const url = button.getAttribute('data-url') + "?id=" + tableId;

    // Navigate to the URL
    window.location.href = url;

    });
  });
</script>
<?php include 'general/footer.php';?>