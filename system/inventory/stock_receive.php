<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Items";
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add_stock.php" class="btn bg-warning btn-sm mb-2"><i class="fas fa-plus-circle"></i>
            Add stock</a>
        <a href="<?= SYS_URL ?>inventory/add.php" class="btn bg-dark btn-sm mb-2"><i class="fas fa-th-list"></i>
            Item Receive Report</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" class="btn-sm btn bg-secondary" name="from_date">
            <input type="date" class="btn-sm btn bg-secondary" name="to_date">
            <input type="text" class="btn-sm btn light border-dark" name="item_name" placeholder="Enter Item Name">
            <input type="text" class="btn-sm btn light border-dark" name="supplier_name"
                placeholder="Enter Supplier Name">
            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>

               
            </div>

            <div class="card-body table-responsive p-0">
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
                    
                    if(!empty($Supplier_name)){
                        $where.=" s.SupplierName='$SupplierName' AND";
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
        ON (s.id = it.supplier_id) $where;";
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
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?>
                            </td>
                            <td>
                                <div class="dropdown no-arrow mb-1">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        &nbsp;&nbsp;


                                        
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>inventory/delete.php?id=<?= $row['id'] ?>"
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