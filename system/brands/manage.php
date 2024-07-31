<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Brands Management";
$breadcrumb_item = "Brands";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
    <a href="add.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>New</a>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">

            <button type="submit">Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Brands Details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php


$db = dbConn();
$sql = "SELECT
`items`.`id`
,`items`.`item_name`
,`brands`.`item_quantity`
,`items`.`brand_id`
,`brands`.`brand`
,`brands`.`status`
FROM
`items`
INNER JOIN `brands` 
ON (`brands`.`id` = `items`.`brand_id`)";
$result = $db->query($sql);
  ?>      

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Brand</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Actions</th>

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
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['item_quantity'] ?></td>
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
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>brands/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-info btn-sm"
                                            href="<?= SYS_URL ?>brands/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>

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