<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Stock Return ";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>order/add_stock.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            Add New Return</a>
        <a href="<?= SYS_URL ?>inventory/add.php" class="mb-2 btn bg-dark btn-sm"><i class="fas fa-th-list"></i>
            Item Return Report</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" name="from_date" class="btn-sm btn bg-secondary">
            <input type="date" name="to_date" class="btn-sm btn bg-secondary">

            <button type="submit"  class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Stock Return Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= "return_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT ri.*, i.item_name
                FROM order_return_items ri
                INNER JOIN items i
                    ON i.Id = ri.item_id $where";
                $result = $db->query($sql);
               ?> 

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Return type</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $status = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['unit_price'] ?></td>
                            <td><?= $row['qty'] ?></td>
                            <td><?= $row['return_type'] ?></td>
                            <td><?= $row['return_date'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Approved</button>' :'' ; ?></td>
                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">


                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>inventory/delete_stock_return.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>
                                        <a class="btn btn-info btn-sm"
                                            href="<?= SYS_URL ?>inventory/view.php?id=<?= $row['id'] ?>">
                                           <i class="fas fa-eye"></i> View</a>&nbsp;&nbsp;
                                    </div>
                                </div>
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
$content = ob_get_clean();
include '../layouts.php';
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>