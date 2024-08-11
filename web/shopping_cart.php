
<?php
include '../config.php';

include '../function.php';

extract($_POST);
//extract the stock id and check add to cart button click or not by operate
if ($_SERVER['REQUEST_METHOD'] == "POST" && $operate == 'add_cart') {

    $db = dbConn();
    //pass selected one item record 
      $sql = "SELECT * FROM item_stock INNER JOIN items 
        ON (items.id = item_stock.item_id)
        INNER JOIN itemimages im ON im.ItemID = items.id WHERE item_stock.id='$id'";

    $result = $db->query($sql);
    //array inside a associative array pass qty
    //cart[1]=array("stock_id"=>'1',"item_id"=>'1',"qty"=>'2',"price"=>'980.50',);



    //check if the cart session and stock_id cart[1] set or not if set add 1 to current_qty
    $row = $result->fetch_assoc();
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id])) {
        $current_qty = $_SESSION['cart'][$id]['qty'] += 1;
    } else {
        $current_qty = 1; //first item purchase
    }

    //cart session array pass values to outside array $arr[$id]='1',...
    $_SESSION['cart'][$id] = array('stock_id' => $row['id'], 'item_id' => $row['item_id'],
    'ImagePath' => $row['ImagePath'], 
    'item_name' => $row['item_name'],
     'unit_price' => $row['unit_price'],
      'qty' => $current_qty);
   
    //    print_r($_SESSION['cart']); 
    header('Location:item.php');
}



