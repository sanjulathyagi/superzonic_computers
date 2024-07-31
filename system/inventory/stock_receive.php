<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Manage";
$alert=false;
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add_stock.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            Add stock</a>
        <a href="<?= SYS_URL ?>inventory/add.php" class="mb-2 btn bg-dark btn-sm"><i class="fas fa-th-list"></i>
            Item Receive Report</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" class="btn-sm btn bg-secondary" name="from_date">
            <input type="date" class="btn-sm btn bg-secondary" name="to_date">
            <input type="text" class="btn-sm btn light border-dark" name="item_name" placeholder="Enter Item Name" name="Name" placeholder="Enter District Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>

               
            </div>

            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " it.purchase_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    if(!empty($item_name)){
                        $where.=" i.item_name='$item_name' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT it.id
                ,i.item_name
                ,i.colour
                ,ic.category_name
                ,it.unit_price
                ,it.qty
                ,it.purchase_date
                ,i.status
                ,s.SupplierName
               
            
    FROM
    items i
    INNER JOIN item_stock it
        ON (i.id = it.item_id)
    INNER JOIN item_category ic
        ON (ic.id = i.item_category)
    INNER JOIN supplier s
        ON (s.id = it.supplier_id) $where";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Colour</th>
                            <th>Unit_price</th>
                            <th>Qty</th>
                            <th>Purchase Date</th>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td><?= $row['colour'] ?></td>
                            <td><?= $row['unit_price'] ?></td>
                            <td><?= $row['qty'] ?></td>
                            <td><?= $row['purchase_date'] ?></td>
                            <td><?= $row['SupplierName']?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Approve</button>' :'<button class="btn btn-info btn-sm" style="width: 80px;">Pending</button>'; ?>
                            </td>
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


                                        
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>inventory/delete.stock_receive.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>
                                        <a class="btn btn-info btn-sm"
                                            href="<?= SYS_URL ?>inventory/stock_view.php?id=<?= $row['id'] ?>">
                                           <i class="fas fa-eye"></i> View</a>&nbsp;&nbsp;

                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['status']==1)?'selected': '' ?>>Approve</option>
                                        <option value="0" <?= ($row['status']==0) ? 'selected' : '' ?>>Pending</option>
                                        
                                    </select>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                </form>
                                <?php
                                
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    $id= $_POST['id'];
                                    $status = $_POST['status'];
                                
                                    if (!empty($id) && isset($status)) {
                                        $db =dbConn();
                                        $sql = "UPDATE item_stock SET status='$status' WHERE id='$id'";
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