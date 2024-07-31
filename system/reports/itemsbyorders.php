<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include '../../function.php';
    $db = dbConn();
    $product = null;
    extract($_POST);

//total sales quantity by products
// SELECT p.ProductName,p.price, SUM(o.quantity) AS total_quantity FROM order_details o INNER JOIN products p on p.ProductID=o.ProductID GROUP BY p.ProductID;
//total sales amount    
$sql = "SELECT i.item_name, SUM(oi.Qty) AS TOTALQTY,oi.unit_price, SUM(oi.unit_price*oi.Qty) AS TOTALAMOUNT  FROM order_items oi 
INNER JOIN items i ON i.id=oi.item_id 
GROUP BY i.id ORDER BY item_name ASC LIMIT 10 ";
    $result = $db->query($sql);


    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="">Select a Top</label>
        <input type="text" name="product" value="<?= $product ?>">
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Total Qty</th>
                <th>Price</th>
                <th>Total Amt</th>

            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {

            ?>
                <tr>
                    <td><?= $row['item_name'] ?></td>
                    <td><?= $row['TOTALQTY'] ?></td>
                    <td><?= $row['unit_price'] ?></td>
                    <td><?= number_format($row['TOTALAMOUNT'], 2) ?></td>

                </tr>

            <?php

            }
            ?>
        </tbody>
    </table>
</body>

</html>