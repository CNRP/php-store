<?php 
$page_title = "Account View";

include '../general/header.php';
include "../support/tickets-table.php";
include "../auth/session.php";
$id = $_SESSION['user']['id'];

$page_title = "Account View";
?>
    <div class="content">
        <h2>All Orders</h2>
        <?php 
        
            $buttons = generate_action_button("", "order/view.php", "fa-right-from-bracket") . generate_action_button("", "hello", "fa-trash"); 
            echo generate_table("SELECT id, display_id, created_at, status FROM `orders` WHERE user_id=$id ORDER BY `created_at` ASC", $mysqli, true, false)?>

        <a class="button" href="/auth/logout.php">Logout</a>
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
<?php include '../general/footer.php';?>