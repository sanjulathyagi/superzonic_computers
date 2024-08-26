<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "Manage";
$alert=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    

    if (!empty($id) && isset($order_status)) {
        $db =dbConn();
        $sql = "UPDATE orders SET order_status='$order_status' WHERE id='$id'";
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
    <!-- <a href="<?= SYS_URL ?>orders/add.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            Add New order</a> -->
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" class="btn-sm btn bg-secondary" name="from_date">
            <input type="date" class="btn-sm btn bg-secondary" name="to_date">
        <input type="text" class="btn-sm btn light border-dark" name="Name" placeholder="Enter Customer Name">

        <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " order_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    if(!empty($FirstName) && !empty($LastName)){
                        $where.=" FirstName='$FirstName' AND LastName='$LastName' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db = dbConn();
                $sql = "SELECT o.*,c.FirstName,c.LastName 
                FROM orders o 
                INNER JOIN customers c 
                    ON c.CustomerId=o.customer_id $where";

                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Order Date</th>
                            <th>Customer</th>
                            <th>Order Number</th>
                            <th>Amount(Rs.)</th>
                            <th>Status</th>
                            <th>Actions</th>
                            

                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                            <td><?= $row['order_number'] ?></td>
                            <td><?= $row['total_amount'] ?></td>
                            <td>
                                <?php 
                                if ($row['order_status'] == 0) {
                                    echo '<span class="badge badge-warning">Pending</span>';
                                } elseif($row['order_status'] == 1) {
                                    echo '<span class="badge badge-info">Issued</span>';
                                    
                                } elseif($row['order_status'] == 2) {
                                        echo '<span class="badge badge-secondary">Shipping</span>';
                                    
                                } elseif($row['order_status'] == 3) {
                                        echo '<span class="badge badge-success">Delivered</span>';
                                } elseif($row['order_status'] == 4) {
                                    echo '<span class="badge badge-danger">Canceled</span>';
                                }
                                ?>
                            </td>
                            
                            <td><a href="<?= SYS_URL ?>orders/view_order_items.php?order_id=<?= $row['id'] ?>"
                                            class="btn btn-info btn-sm" style="width: 90px;"><i class="fas fa-eye"></i> view</a>
                               
                            </td>
                            <?php
                            if($row['order_status'] == 1) {
                                ?>
                                <td><a href="<?= SYS_URL ?>customers/coupon.php"
                                class="btn btn-secondary btn-sm" style="width: 120px;"><i class="fas fa-circle"></i> Issue coupons</a></td>
                            <?php
                            }
                            
                                ?>
                            
      
                           
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