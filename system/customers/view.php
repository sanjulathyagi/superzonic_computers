<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customers";
$breadcrumb_item_active = "View ";

extract($_GET); 


$db = dbConn();
$sql ="SELECT c.*, d.Name ,u.UserName,o.*
        FROM customers c
        INNER JOIN districts d
         ON d.Id = c.DistrictId
         INNER JOIN orders o
         ON o.customer_id = c.CustomerId
        INNER JOIN users u
         ON u.UserId = c.UserId WHERE c.CustomerId='$CustomerId'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Customer Details</b></h3>


            </div> <br>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <div class="row">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3>Customer Details</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6><b>Customer Id:</b></h6>
                                        <?= $row['CustomerId'] ?><br><br>
                                        <h6><b>First Name:</b></h6>
                                        <?= $row['FirstName'] ?><br><br>
                                        <h6><b>Last Name:</b></h6>
                                        <?= $row['LastName'] ?><br><br>
                                        <h6><b>Gender:</b></h6>
                                        <?= $row['Gender'] ?><br><br>
                                       

                                    </div>

                                    <div class="col-md-6">
                                        <h6><b>Reg No:</b></h6>
                                        <?= $row['RegNo'] ?><br><br>
                                        <h6><b>UserName:</b></h6>
                                        <?= $row['UserName'] ?><br><br>
                                        
                                        
                                        
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Contact Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6><b>Mobile No:</b></h6>
                                        <?= $row['MobileNo'] ?><br><br>
                                        <h6><b>Email:</b></h6>
                                        <?= $row['Email'] ?><br><br>
                                    </div>

                                    <div class="col-md-6">
                                        <h6><b>Tel No:</b></h6>
                                        <?= $row['TelNo'] ?><br><br>
                                        <h6><b>Address:</b></h6>
                                        <?= $row['AddressLine1'] ?>,<br><?= $row['AddressLine2'] ?>,<br><?= $row['AddressLine3'] ?><br><br>
                                        <h6><b>District:</b></h6>
                                        <?= $row['Name'] ?><br><br>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3>Delivery Details</h3>
                                <div class="row">
                                    <div class="col-md-">
                                        <h6><b>Delivery Name:</b></h6>
                                        <?= $row['delivery_name'] ?><br><br>
                                        <h6><b>Delivery Address:</b></h6>
                                        <?= $row['delivery_address'] ?><br><br>
                                        <h6><b>Delivery Phone</b></h6>
                                        <?= $row['delivery_phone'] ?><br><br>
                                        
                                       

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Billing Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="col-md-">
                                        <h6><b>Billing Name:</b></h6>
                                        <?= $row['billing_name'] ?><br><br>
                                        <h6><b>Billing Address:</b></h6>
                                        <?= $row['billing_address'] ?><br><br>
                                        <h6><b>Billing Phone</b></h6>
                                        <?= $row['delivery_phone'] ?><br><br>
                                        
                                       

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

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