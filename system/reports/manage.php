<?php
ob_start();
session_start();
include_once '../init.php';


$link = "Reports Management";
$breadcrumb_item = "Reports";
$breadcrumb_item_active = "manage";



?>
<div class="row">
    <div class="col-lg-4 ">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="NumberOfOrders"></h3>
                <p>Item Report</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="item_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 ">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="NumberOfItems"></h3>
                <p>stock report</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="stock_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 ">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="NumberOfOrders"></h3>
                <p>customer Report</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="customer_details_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 ">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="NumberOfUsers"></h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="user_details_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-4 ">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="NumberOfAppointments"></h3>
                <p>Supplier Reports</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="supplier_report.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
   
    <!-- ./col -->
</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>