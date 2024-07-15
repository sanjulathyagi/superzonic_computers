<?php
include_once '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_id = $_POST['item_id'];
    $status = $_POST['status'];

    if (!empty($item_id) && isset($status)) { // Check for isset instead of empty for status
        $db = dbConn();
        $status = $db->real_escape_string($status);
        $item_id = $db->real_escape_string($item_id);

        $sql = "UPDATE items SET status='$status' WHERE id='$item_id'";
        if ($db->query($sql)) {
            echo "<script>
                alert('Status updated successfully.');
                window.location.href = 'items.php';
            </script>";
        } else {
            echo "<script>alert('Error updating status: " . $db->error . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid input.');</script>";
    }
}
?>
