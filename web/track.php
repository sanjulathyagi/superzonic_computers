<?php

include '../config.php';
include 'header.php';
include '../function.php';


if (!isset($_SESSION['USERID'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Fetch logged-in user details
$userid = $_SESSION['USERID'];

// Fetch user’s customer ID from the database
$db = dbConn();
$sql = "SELECT CustomerId FROM customers WHERE UserId='$userid'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$customerid = $row['CustomerId'];

?>
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="justify-content-between align-items-center">
                <div class="col-lg-12">

                    <!-- <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                        style="text-align:right">
                        <input type="date" class="btn-sm btn bg-secondary" name="from_date">
                        <input type="date" class="btn-sm btn bg-secondary" name="to_date">
                        <input type="text" class="btn-sm btn light border-dark" name="Name"
                            placeholder="Enter order Name">

                        <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i>
                            Search</button>
                    </form> -->
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
                        $where.=" FirstName='$FirstName'";
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
                    ON c.CustomerId=o.customer_id
                    Where c.CustomerId='$customerid' $where";

                $result = $db->query($sql);
                ?>

                            <table class="table table-hover text-nowrap" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Order Date</th>
                                        <th>Billing Name</th>
                                        <th>Delivery Name</th>
                                        <th>Delivery Address</th>
                                        <th>Payment</th>
                                        <th>Delivery Method</th>
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
                                        <td><?= $row['order_number'] ?></td>
                                        <td><?= $row['order_date'] ?></td>
                                        <td><?= $row['billing_name'] ?>
                                        <td><?= $row['delivery_name'] ?></td>
                                        <td><?= $row['delivery_address'] ?></td>
                                        <td><?= $row['payment_method'] ?></td>
                                        <td><?= $row['delivery_method'] ?></td>
                                        <td><?= ($row['order_status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Paid</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">pending</button>'; ?>
                                        </td>
                                        <td><a href="<?= WEB_URL ?>order_summary.php?order_id=<?= $row['id'] ?>"
                                                class="btn btn-info btn-sm" style="width: 170px;"> <i
                                                    class="fas fa-eye"></i> view order summary</a>
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

        </div>




        <?php
include 'footer.php';
?>