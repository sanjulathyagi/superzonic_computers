<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include '../init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (!empty($id) && isset($status)) {
        $db =dbConn();
        $sql = "UPDATE items SET status='$status' WHERE id='$id'";
        if($db->query($sql)) {
            echo "<script>
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'item updated successfully',
        showConfirmButton: ok,
        timer: 1500
        }).then() => {
            window.location.href='/SIRMS/system/inventory/items.php';
    });
</script>";
        }else {
            echo "error";
        }
    }else {
            echo "error";
           
        }
    
    }

?>