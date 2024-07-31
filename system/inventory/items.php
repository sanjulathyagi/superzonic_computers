<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Items ";
$breadcrumb_item_active = "Manage";
$alert=false;
?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            New Item</a>
        <a href="<?= SYS_URL ?>inventory/add_report.php" class="mb-2 btn bg-dark btn-sm"><i class="fas fa-th-list"></i>
            Item Report</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" name="from_date" class="btn-sm btn bg-secondary">
            <input type="date" name="to_date" class="btn-sm btn bg-secondary">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath 
                FROM items i 
                INNER JOIN item_category ic ON ic.id = i.item_category 
                INNER JOIN brands b ON b.id = i.brand_id 
                INNER JOIN models m ON m.id = i.model_id 
                LEFT JOIN itemimages im ON im.ItemID = i.id GROUP BY i.id $where";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Item </th>
                            <th>Item Image</th>
                            <th>Colour</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model</th>
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
                            <td><?= $row['serial_number'] ?></td>
                            <td><?= $row['item_name'] ?></td>
                            <td><img src="<?= SYS_URL ?>uploads/<?=  $row['ImagePath'] ?>" alt="item_image"></td>

                            <td><?= $row['colour'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td><?= $row['brand']?></td>
                            <td><?= $row['model_name']?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?>

                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        &nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>inventory/view.php?id=<?= $row['id'] ?>"
                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i> view</a>
                                        <a href="<?= SYS_URL ?>inventory/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>inventory/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i>
                                            Delete</a>&nbsp;&nbsp;

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
                                    $id = $_POST['id'];
                                    $status = $_POST['status'];
                                
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
        position: "top-end",
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

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>