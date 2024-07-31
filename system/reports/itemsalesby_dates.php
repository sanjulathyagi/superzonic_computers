<?php
session_start();
?>

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
$startdate=null;
$enddate=null;
    extract($_POST);


                $db = dbConn();
                $sql = "SELECT o.order_date,SUM(oi.unit_price*oi.qty) as TOTALAMOUNT FROM orders o 
                INNER JOIN order_items oi ON oi.order_id=o.id 
                WHERE o.order_date BETWEEN '$startdate' AND '$enddate'
                GROUP BY o.order_date;";

                $result = $db->query($sql);
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="">start date</label>
        <input type="date" name="startdate" value="<?=$startdate ?>">
        <label for="">end date</label>
        <input type="date" name="enddate" value="<?=$enddate ?>">
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>total amount</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $total=0;
            while ($row = $result->fetch_assoc()) {

                $total+=$row['TOTALAMOUNT'];
            ?>
            <tr>
                <td><?= $row['order_date'] ?></td>
                <td><?=number_format($row['TOTALAMOUNT'],2) ?></td>

            </tr>

            <?php

            }
            ?>
            <tr>
                <td>total</td>
                <td><?= number_format($total,2) ?></td>
            </tr>
        </tbody>
    </table>



</body>

</html>