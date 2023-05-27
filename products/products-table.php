<table>
    <thead>
        <tr>
            <th>Prod ID</th>
            <th>Name</th>
            <th>Img</th>
            <th>Price</th>
            <th>Created At</th>
            <th>Last Updated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
<?php

    global $mysqli;
    $rows = "";
    mysqli_data_seek($data, 0);
    while ($product = mysqli_fetch_assoc($data)){
        $date = date_parse($product['created_at']);
?>
        <tr>
            <td class="id"><p><?php echo $product['id'] ?></p></td>
            <td class="name"><p><?php echo $product['name'] ?></p></td>
            <td><img src="<?php echo $product['image_url'] ?>"></td>

            <td class="id"><p>£<?php echo $product['price_value'] ?></p></td>
            <td><?php echo $product['created_at'] ?></td>
            <td><?php echo $product['updated_at'] ?></td>
            <td>
                <div class="buttons">
                    <a href="/products/item.php?id=<?php echo $product['id'] ?>" class="button">
                        <i class="fa-solid fa-up-right-from-square"></i>
                    </a>
                    <a class="button">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </td>
        </tr>
<?php
    }
?>
    </tbody>
</table>