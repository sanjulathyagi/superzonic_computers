<?php
include_once '../init.php';
$db = dbConn();
extract($_POST); //issued_data

foreach ($issued_qty as $key => $qty) {
    
    $issue_qty = $qty;
    $item=$items[$key];
    $price=$prices[$key];

while ($issue_qty > 0) {
     // Select the stock with available quantity, ordered by purchase date (FIFO)

     echo $sql = "SELECT *
                FROM `item_stock`
                WHERE item_id = '$item' 
                  AND unit_price = '$price'
                  AND (qty - COALESCE(issued_qty, 0)) > 0
                ORDER BY `purchase_date` ASC 
                LIMIT 1";
                //if you want to issue latest items should change, desc for LIFO
        $result = $db->query($sql);

        
    // If no more stock available, break the loop to avoid infinite loop
    
    if ($result->num_rows == 0) {           
        break; //remove from while and next to other item
    }

        $row = $result->fetch_assoc();
        $remaining_qty = $row['qty'] - ($row['issued_qty'] ?? 0); // here  ?? null replace by 0 value
        $item_id=$row['item_id'];
        $unit_price = $row['unit_price'];
        $i_date = date('Y-m-d');

        if ($issue_qty <= $remaining_qty) {
            $i_qty = $issue_qty;
            $s_id = $row['id'];//stockId store in s_id
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty = 0; //while loop run until issued_item get 0
        } else {

            $i_qty = $remaining_qty; //if the issue_qty is less than remaining_qty
            $s_id = $row['id'];
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty -= $i_qty;  //decrement remaining_qty from issue_          
        }
   
    }
}
header("Location:../orders/view.php?order_id=$order_id");