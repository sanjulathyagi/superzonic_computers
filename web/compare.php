
<?php
include '../config.php';

include '../function.php';
print_r($_POST);
extract($_POST);
//extract the stock id and check add to cart button click or not by operate
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $db = dbConn();
    //pass selected one item record 
    $sql = "SELECT i.item_name,f.item_features,ff.feature_value ,im.ImagePath
    FROM item_stock s 
    INNER JOIN items i ON i.id = s.item_id
    INNER JOIN itemimages im ON im.ItemID = i.id
    INNER JOIN item_features ff ON ff.item_id = i.id
    INNER JOIN features f ON f.id = ff.feature_name
    WHERE s.id='$id'
    GROUP BY ff.feature_name";

    $result = $db->query($sql);
    //array inside a associative array pass qty
    //cart[1]=array("stock_id"=>'1',"item_id"=>'1',"qty"=>'2',"price"=>'980.50',);



    //check if the compare session and stock_id compare[1] set or not if set add 1 to current_qty
    $row = $result->fetch_assoc();
    if (isset($_SESSION['compare']) && isset($_SESSION['compare'][$id])) {
        $current_qty = $_SESSION['compare'][$id]['qty'] += 1;
    } else {
        $current_qty = 1; //first item purchase
    }

    //cart session array pass values to outside array $arr[$id]='1',...
    $_SESSION['compare'][$id] = array('stock_id' => $row['id'], 'item_id' => $row['item_id'],
    'ImagePath' => $row['ImagePath'], 
    'item_name' => $row['item_name'],
     'unit_price' => $row['unit_price'],
     'feature_value' => $row['feature_value'],
     'item_features' => $row['item_features'],
      'qty' => $current_qty);
   
       print_r($_SESSION['compare']); 
    // header('Location:compare_result.php');
}



