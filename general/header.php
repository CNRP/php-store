<?php 
    include 'utils.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $page_title ?></title>    
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/assets/fa/css/all.min.css">
    <link rel="stylesheet" href="/css/support/style.css" />
    <?php
        $pages = array('tickets-overview.php', 'account.php', 'ticket.php', 'list.php', 'view.php', 'placed.php', 'table.php');
        if (in_array(basename($_SERVER['PHP_SELF']), $pages)):
    ?>
        <link rel="stylesheet" href="/css/support/table-style.css" />
    <?php endif; ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>  
    <div class="demo"><p>demo demo demo demo demo demo demo demo</p><p>demo demo demo demo demo demo demo demo</p></div>
    <style>
        .demo p{
            position: absolute; 
            font-size: 3rem;
            color: white;
            opacity: 0.1;
        }

        .demo p:nth-child(1){
            top: 3em;
            left: 0;
        }

        .demo p:nth-child(2){
            position: absolute; 
            bottom: 0;
            right: 0;
        }

    </style>
    <?php 
    include WEBROOT.'/order/basket.php';
    include WEBROOT.'/general/navigation.php';
    ?>