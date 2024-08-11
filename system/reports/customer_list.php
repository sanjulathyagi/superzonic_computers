
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
    if(!empty($item_name)){
        $where .= " item_name='$item_name' AND";
    }
   
    if(!empty($where)){
        $where = substr($where, 0,-3);
        $where = "WHERE $where";
    }
}

    $db = dbConn();

   
    $db= dbConn ();
    $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name FROM items i 
    INNER JOIN item_category ic ON ic.id = i.item_category 
    INNER JOIN brands b ON b.id = i.brand_id 
    INNER JOIN models m ON m.id = i.model_id $where";
    $result = $db->query($sql);

    ?>
    <!-- get data from same table to a dropdown  -->
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="">Select a Item</label>
        <select name="item_name" id="item_name">
            <option value="">--</option>

            <?php
            $sql = "SELECT DISTINCT item_name FROM items";
            $resultItem = $db->query($sql);

            while ($rowItem = $resultItem->fetch_assoc()) {

            ?>
            <option value="<?= $rowItem['item_name'] ?>"><?= $rowItem['item_name'] ?></option>
            <?php

            }
            ?>


        </select>

      
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Serial Number</th>
                <th>Item </th>
                <th>Colour</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Model</th>

        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {

            ?>
            <tr>
                <td><?= $row['serial_number'] ?></td>
                <td><?= $row['item_name'] ?></td>
                <td><?= $row['colour'] ?></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['brand']?></td>
                <td><?= $row['model_name']?></td>
            </tr>

            <?php

            }
            ?>
        </tbody>
    </table>



</body>

</html>