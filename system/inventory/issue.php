<?php

include_once '../init.php';
$db = dbConn();
extract($_POST); //issued_data

foreach ($issued_qty as $key => $qty) { //multiple item issued_qty
    
    $issue_qty = $qty;
    $item=$items[$key];
    $price=$prices[$key];
    
    while ($issue_qty > 0) {  //run until issue_qty get 0
        // Select the stock with available quantity, ordered by purchase date (FIFO),first record
        $sql = "SELECT *
                FROM item_stock
                WHERE item_id = '$item' 
                  AND unit_price = '$price'
                  AND (qty - COALESCE(issued_qty, 0)) > 0
                ORDER BY 'purchase_date' ASC
                LIMIT 1"; //first record
        $result = $db->query($sql);  //if you want to issue latest items should change, desc for LIFO,if null get o (COALESCE)

        // If no more stock available, break the loop to avoid infinite loop
        if ($result->num_rows == 0) {        //should available one or more records     
            break;   //remove from while and next to other item
        }

        $row = $result->fetch_assoc();
        $remaining_qty = $row['qty'] - ($row['issued_qty'] ?? 0);  // here  ?? null replace by 0 value
        $item_id=$row['item_id'];
        $unit_price = $row['unit_price'];
        $i_date = date('Y-m-d');

        if ($issue_qty <= $remaining_qty) {  //if the issue quantity less than or equal to zero
            $i_qty = $issue_qty;
            $s_id = $row['id']; //stockId store in s_id

        echo  $sql = "UPDATE item_stock SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            
            $sql = "UPDATE order_items SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE order_id = '$order_id' AND item_id='$item_id'";
            $db->query($sql);
            
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty = 0;  // All quantity issued,while loop run until issued_item get 0
        } else {
            $i_qty = $remaining_qty;  //if the issue_qty is greater than remaining_qty
            $s_id = $row['id'];

            $sql = "UPDATE item_stock SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            
            $sql = "UPDATE order_items SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE order_id = '$order_id' AND item_id='$item_id'";
            $db->query($sql);
            
            $sql = "INSERT INTO order_items_issue(order_id, item_id, stock_id, unit_price, issued_qty, issue_date) 
                    VALUES ('$order_id', '$item_id', '$s_id', '$unit_price', '$i_qty', '$i_date')";
            $db->query($sql);
            $issue_qty -= $i_qty;  // Reduce the remaining quantity to be issued
        }
    }
}
 $sql = "UPDATE orders SET order_status='1' WHERE id = $order_id";
 $db->query($sql);
header("Location:../orders/view_order_items.php?order_id=$order_id");





