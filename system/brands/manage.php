<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Brands Management";
$breadcrumb_item = "Brands";
$breadcrumb_item_active = "Manage";
$alert=false;
?>
<div class="row">
    <div class="col-12">
    <a href="add.php" class="mb-2 btn btn-warning btn-sm"><i class="fas fa-plus-circle"></i>New Brand</a>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
           
            <input type="text" class="btn-sm btn light border-dark" placeholder="Enter Brand Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Brands Details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php


$db = dbConn();
$sql = "SELECT *
FROM brands
";
$result = $db->query($sql);
  ?>      

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Brand</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>

                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['brand'] ?></td>
                            <td><?= $row['item_quantity'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?>
                            </td>
                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>brands/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>brands/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>

                                    </div>
                                </div>
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
                                <?php
                                
                                
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    
                                
                                    if (!empty($id) && isset($status)) {
                                        $db =dbConn();
                                        $sql = "UPDATE brands SET status='$status' WHERE id='$id'";
                                        $result1 = $db->query($sql);
                                         if($result1){
                                            $alert=true;
                                         } else{
                                            $alert =false;
                                         }  
                                        }
                                    }
                                }
                                
                                ?>


                            </td>
                        </tr>

                        <?php
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