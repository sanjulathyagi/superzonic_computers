<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Repair Management";
$breadcrumb_item = "Items ";
$breadcrumb_item_active = "Manage";
$alert=false;
$limit=10;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    

    if (!empty($id) && isset($status)) {
        $db =dbConn();
        $sql = "UPDATE items SET status='$status' WHERE id='$id'";
        $result1 = $db->query($sql);
         if($result1){
            $alert=true;
         } else{
            $alert =false;
         }  
        }
    }

?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>repair/add.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            New Item</a>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
          
            <input type="text" class="btn-sm btn light border-dark" name="item_name" placeholder="Enter Item Name"
                name="Name" placeholder="Enter District Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Repair Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if(!empty($item_name)){
                        $where.=" item_name='$item_name' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT * FROM repair";

                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>serial Number</th>
                            <th>Item </th>
                            <th>Brand</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['repair_number'] ?></td>
                            <td ><?= $row['item'] ?></td>
                            <td><?= $row['brand']?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?>

                            <td>

                                <a href="<?= SYS_URL ?>inventory/view.php?id=<?= $row['id'] ?>"
                                    class="btn btn-info btn-sm"><i class="fas fa-eye"></i> view</a>


                            </td>
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['status']==1)?'selected': '' ?>>Active</option>
                                        <option value="0" <?= ($row['status']==0) ? 'selected' : '' ?>>Deactive</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                </form>


                            </td>
                        </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-middle",
        icon: "success",
        title: "status has been updated  ",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>