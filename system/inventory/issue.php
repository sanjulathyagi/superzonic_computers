<?php

include_once '../init.php';
$db = dbConn();

$issue_qty = 2;
$item_id = 1;

while ($issue_qty > 0) {
     // Select the stock with available quantity, ordered by purchase date (FIFO)

    $sql = "SELECT * FROM item_stock
            WHERE item_id = $item_id AND (qty - COALESCE(issued_qty, 0)) > 0
            ORDER BY purchase_date ASC
            LIMIT 1";
    $result = $db->query($sql);
    // here  ?? null replace by 0 value
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $remaining_qty = $row['qty'] - ($row['issued_qty'] ?? 0);

        if ($issue_qty <= $remaining_qty) {
            $i_qty = $issue_qty;
            $s_id = $row['id'];//id of stockId store in s_id
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $issue_qty = 0; //while loop run until issued_item get 0
        } else {
            $i_qty = $remaining_qty; //if the issue_qty is less than remaining_qty
            $s_id = $row['id'];
            $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) + $i_qty WHERE id = $s_id";
            $db->query($sql);
            $issue_qty -= $i_qty;  //decrement remaining_qty from issue_          
        }
    }else{
        break;
    }
}