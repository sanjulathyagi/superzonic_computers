<?php
ob_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
        <!-- <a href="<?= SYS_URL ?>order/add_stock.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i> Add
            Stock</a> -->
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="date" name="from_date">
            <input type="date" name="to_date">

            <button type="submit">Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>

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
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " orders.order_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT o.*,c.FirstName,c.LastName FROM orders o INNER JOIN customers c ON c.CustomerId=o.customer_id";

                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Order Date</th>
                            <th>Customer</th>
                            <th>Order Number</th>
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
                            <td><?= $row['order_date'] ?></td>
                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                            <td><?= $row['order_number'] ?></td>
                            <td>
                                <!-- <? $row['status']==1 ?>
                                 ($status == 1) ? '<button class="btn btn-warning btn-sm" style="width: 80px;">Pending</button>':
                                    (($status == 2) ? '<button class="btn btn-success btn-sm" style="width: 80px;">Paid</button>' :
                                    (($status == 3) ? '<button class="btn btn-primary btn-sm" style="width: 80px;">Shipping</button>' :
                                    (($status == 4) ? '<button class="btn btn-info btn-sm" style="width: 80px;">Delivered</button>'))):''; ?> -->
                            </td>
                            <td>
                                <div class="dropdown no-arrow mb-1" >
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in" style="min-width: 7rem !important";
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;


                                        <a href="<?= SYS_URL ?>orders/view.php?order_id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm" style="width: 90px;"><i class="fas fa-eye"></i>&nbsp;view order</a>

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