<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Items ";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/add.php" class="btn bg-warning btn-sm mb-2"><i class="fas fa-plus-circle"></i>
            New Item</a>
        <a href="<?= SYS_URL ?>inventory/add_report.php" class="btn bg-dark btn-sm mb-2"><i class="fas fa-th-list"></i>
            Item Report</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" name="from_date" class="btn-sm btn bg-secondary">
            <input type="date" name="to_date" class="btn-sm btn bg-secondary">

            <button type="submit"  class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " stock_receives.date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT i.*, b.brand,m.model_name,ic.category_name
                FROM items i
                INNER JOIN item_category ic
                    ON (ic.id=i.item_category)
                INNER JOIN brands b
                    ON (b.id=i.brand_id)
                INNER JOIN models m
                    ON (m.id = i.model_id)";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Item </th>
                            <th>Colour</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model</th>
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
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['colour'] ?></td>
                            <td><?= $row['category_name'] ?></td>
                            <td><?= $row['brand']?></td>
                            <td><?= $row['model_name']?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?></td>
                            <td>
                                <div class="dropdown no-arrow mb-1">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>inventory/view.php?id=<?= $row['id'] ?>"
                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i> view</a>
                                        <a href="<?= SYS_URL ?>inventory/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>inventory/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>&nbsp;&nbsp;

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