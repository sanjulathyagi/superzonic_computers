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
    $country = null;
    $city=null;
    extract($_POST);

$where=null;
if($_SERVER['REQUEST_METHOD']=='POST') {
    if(!empty($country)){
        $where .= " Country='$country' AND";
    }
    if(!empty($city)){
        $where .= " City='$city' AND";
    }
    if(!empty($where)){
        $where = substr($where, 0,-3);
        $where = "WHERE $where";
    }
}



                $db = dbConn();
                $sql = "SELECT COUNT(o.id) AS nooforders,c.FirstName,c.LastName 
                FROM orders o 
                INNER JOIN customers c 
                    ON c.CustomerId=o.customer_id 
                    GROUP BY c.customerID
                    $where
                    ORDER BY COUNT(o.id) ASC
                    LIMIT 1";

                $result = $db->query($sql);
    ?>

    <table>
        <thead>
            <tr>


                <th>Customer</th>
                <th>No of orders</th>


            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {

            ?>
            <tr>
                <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                <td><?=$row['nooforders'] ?></td>

            </tr>

            <?php

            }
            ?>
        </tbody>
    </table>



</body>

</html>