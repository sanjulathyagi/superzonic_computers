<?php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once 'init.php';


$link = "Dashboard";
$breadcrumb_item = "Home";
$breadcrumb_item_active = "Dashboard";

checkRole("B");

$db = dbConn();
$sql ="SELECT leave_date FROM employee_leaves GROUP BY leave_date";
$result = $db->query($sql);

$customDates = array();
if ($result->num_rows>0){
    while ($row=$result->fetch_assoc()){
        $customDates[] = $row['leave_date'];  //fill array variable to employee leave dates
    }
}

?>
<style>
    .highlight {
        background-color: yellow;
    }
</style>
<?php
$db = dbConn();
$sql = "SELECT DATE_FORMAT(o.order_date, '%M') as month, SUM(i.unit_price * i.qty) as amt 
        FROM order_items i 
        INNER JOIN orders o ON o.id = i.order_id 
        GROUP BY month 
        ORDER BY MONTH(o.order_date)";
$result = $db->query($sql);

//create empty array variables
$months = [];
$amounts = [];


//read each record seperately
while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $amounts[] = $row['amt'];
}

// Encode data as JSON
$months_json = json_encode($months);  //convert php variables into javascript variable using json_encode
$amounts_json = json_encode($amounts);
?>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="NumberOfOrders"></h3>
                <p>New </p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="NumberOfItems"></h3>
                <p>Total Active Items</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="NumberOfUsers"></h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="NumberOfAppointments"></h3>
                <p>New Appointments</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="highestSalesItem"></h3>
                <p>Highest Sales Item</p>
                <?php
    
    $db = dbConn();

    extract($_POST);

$sql = "SELECT i.item_name, SUM(oi.Qty) AS TOTALQTY,oi.unit_price, SUM(oi.unit_price*oi.Qty) AS TOTALAMOUNT  FROM order_items oi 
INNER JOIN items i ON i.id=oi.item_id 
GROUP BY i.id ORDER BY item_name ASC LIMIT 1 ";
    $result = $db->query($sql);

    ?>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                
                 <b>Item Name: </b><?= $row['item_name'] ?><br>
                <b>Total Qty: </b> <?= $row['TOTALQTY'] ?>
                
            <?php
            }
            ?>

            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="lowestSalesItem"></h3>
                <p>Lowest Sales Item</p>
                <?php
    
    $db = dbConn();

    extract($_POST);

$sql = "SELECT i.item_name, SUM(oi.Qty) AS TOTALQTY,oi.unit_price, SUM(oi.unit_price*oi.Qty) AS TOTALAMOUNT  FROM order_items oi 
INNER JOIN items i ON i.id=oi.item_id 
GROUP BY i.id ORDER BY item_name DESC LIMIT 1 ";
    $result = $db->query($sql);

    ?>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                
                 <b>Item Name: </b><?= $row['item_name'] ?><br>
                <b>Total Qty: </b> <?= $row['TOTALQTY'] ?>
                
            <?php
            }
            ?>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="NumberOfUsers"></h3>
                <p>Total sales</p>
                <?php
    
    $db = dbConn();

    extract($_POST);

$sql = "SELECT YEAR(o.order_date)AS orderyear,SUM(oi.unit_price*oi.qty) as TOTALAMOUNT FROM orders o 
                INNER JOIN order_items oi ON oi.order_id=o.id 
                WHERE o.order_date BETWEEN '1990-04-07' AND '2024-07-04'
                GROUP BY orderyear;";
    $result = $db->query($sql);

    ?>

<?php
            $total=0;
            while ($row = $result->fetch_assoc()) {
                $total+=$row['TOTALAMOUNT'];

            ?>
                <tr>
                    <td>Year : <?= $row['orderyear'] ?></td>
                    <td>Total : <?=number_format($row['TOTALAMOUNT'],2) ?></td><br>

                </tr>

            <?php

            }
            ?>
            <tr>
            <td>Total : </td>
            <td><?= number_format($total,2) ?></td>
            </tr>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="NumberOfAppointments"></h3>
                <p>Total Sales </p>
                <?php
    
    $db = dbConn();

    extract($_POST);

$sql = "SELECT YEAR(o.order_date)AS orderyear,MONTHNAME(o.order_date)AS Month, SUM(oi.unit_price*oi.qty) as TOTALAMOUNT FROM orders o 
                INNER JOIN order_items oi ON oi.order_id=o.id 
                WHERE o.order_date
                GROUP BY Month";
    $result = $db->query($sql);

    ?>

            <?php
            while ($row = $result->fetch_assoc()) {
            ?>
                
                 <b>Year: </b><?= $row['orderyear'] ?><br>
                <b>Month: </b> <?= $row['Month'] ?>
                <b>Total: </b> <?= $row['TOTALAMOUNT'] ?><br>
                
                
            <?php
            }
            ?>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>

<!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart">
                    <!-- use canvas tag to design charts -->
                    <canvas id="barChart"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <!-- /.card -->

        <!-- DIRECT CHAT -->
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>

                <div class="card-tools">
                    <span title="3 New Messages" class="badge badge-primary">3</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                        <i class="fas fa-comments"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                        <div class="clearfix direct-chat-infos">
                            <span class="float-left direct-chat-name">Alexander Pierce</span>
                            <span class="float-right direct-chat-timestamp">23 Jan 2:00 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="assets/dist/img/user1-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            Is this template really for free? That's unbelievable!
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                        <div class="clearfix direct-chat-infos">
                            <span class="float-right direct-chat-name">Sarah Bullock</span>
                            <span class="float-left direct-chat-timestamp">23 Jan 2:05 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="assets/dist/img/user3-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            You better believe it!
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg">
                        <div class="clearfix direct-chat-infos">
                            <span class="float-left direct-chat-name">Alexander Pierce</span>
                            <span class="float-right direct-chat-timestamp">23 Jan 5:37 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="assets/dist/img/user1-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            Working with AdminLTE on a great new app! Wanna join?
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                    <!-- Message to the right -->
                    <div class="direct-chat-msg right">
                        <div class="clearfix direct-chat-infos">
                            <span class="float-right direct-chat-name">Sarah Bullock</span>
                            <span class="float-left direct-chat-timestamp">23 Jan 6:10 pm</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img class="direct-chat-img" src="assets/dist/img/user3-128x128.jpg" alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            I would love to.
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->

                </div>
                <!--/.direct-chat-messages-->

                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user1-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Count Dracula
                                        <small class="float-right contacts-list-date">2/28/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">How have you been? I was...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user7-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Sarah Doe
                                        <small class="float-right contacts-list-date">2/23/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">I will be waiting for...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user3-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Nadia Jolie
                                        <small class="float-right contacts-list-date">2/20/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">I'll call you back at...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user5-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Nora S. Vans
                                        <small class="float-right contacts-list-date">2/10/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">Where is your new...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user6-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        John K.
                                        <small class="float-right contacts-list-date">1/27/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">Can I take a look at...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="assets/dist/img/user8-128x128.jpg"
                                    alt="User Avatar">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Kenneth M.
                                        <small class="float-right contacts-list-date">1/4/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">Never mind I found...</span>
                                </div>
                                <!-- /.contacts-list-info -->
                            </a>
                        </li>
                        <!-- End Contact Item -->
                    </ul>
                    <!-- /.contacts-list -->
                </div>
                <!-- /.direct-chat-pane -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <form action="#" method="post">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-primary">Send</button>
                        </span>
                    </div>
                </form>
            </div>
            <!-- /.card-footer-->
        </div>
        <!--/.direct-chat -->

        <!-- TO DO List -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="mr-1 ion ion-clipboard"></i>
                    To Do List
                </h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm">
                        <li class="page-item"><a href="#" class="page-link">&laquo;</a></li>
                        <li class="page-item"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <ul class="todo-list" data-widget="todo-list">
                    <li>
                        <!-- drag handle -->
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo1" id="todoCheck1">
                            <label for="todoCheck1"></label>
                        </div>
                        <!-- todo text -->
                        <span class="text">Design a nice theme</span>
                        <!-- Emphasis label -->
                        <small class="badge badge-danger"><i class="far fa-clock"></i> 2 mins</small>
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo2" id="todoCheck2" checked>
                            <label for="todoCheck2"></label>
                        </div>
                        <span class="text">Make the theme responsive</span>
                        <small class="badge badge-info"><i class="far fa-clock"></i> 4 hours</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo3" id="todoCheck3">
                            <label for="todoCheck3"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-warning"><i class="far fa-clock"></i> 1 day</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo4" id="todoCheck4">
                            <label for="todoCheck4"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-success"><i class="far fa-clock"></i> 3 days</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo5" id="todoCheck5">
                            <label for="todoCheck5"></label>
                        </div>
                        <span class="text">Check your messages and notifications</span>
                        <small class="badge badge-primary"><i class="far fa-clock"></i> 1 week</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <span class="handle">
                            <i class="fas fa-ellipsis-v"></i>
                            <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <div class="ml-2 icheck-primary d-inline">
                            <input type="checkbox" value="" name="todo6" id="todoCheck6">
                            <label for="todoCheck6"></label>
                        </div>
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-secondary"><i class="far fa-clock"></i> 1 month</small>
                        <div class="tools">
                            <i class="fas fa-edit"></i>
                            <i class="fas fa-trash-o"></i>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
            <div class="clearfix card-footer">
                <button type="button" class="float-right btn btn-primary"><i class="fas fa-plus"></i> Add item</button>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

        <!-- Map card -->

        <div class="card bg-gradient-primary">
            <div class="border-0 card-header">
                <h3 class="card-title">
                    <i class="mr-1 fas fa-map-marker-alt"></i>
                    Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                        <i class="far fa-calendar-alt"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.card-body-->
            <div class="bg-transparent card-footer">
                <div class="row">
                    <div class="text-center col-4">
                        <div id="sparkline-1"></div>
                        <div class="text-white">Visitors</div>
                    </div>
                    <!-- ./col -->
                    <div class="text-center col-4">
                        <div id="sparkline-2"></div>
                        <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="text-center col-4">
                        <div id="sparkline-3"></div>
                        <div class="text-white">Sales</div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.card -->

        <!-- solid sales graph -->
        <div class="card bg-gradient-info">
            <div class="border-0 card-header">
                <h3 class="card-title">
                    <i class="mr-1 fas fa-th"></i>
                    Sales Graph
                </h3>

                <div class="card-tools">
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas class="chart" id="line-chart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
            <div class="bg-transparent card-footer">
                <div class="row">
                    <div class="text-center col-4">
                        <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                            data-fgColor="#39CCCC">

                        <div class="text-white">Mail-Orders</div>
                    </div>
                    <!-- ./col -->
                    <div class="text-center col-4">
                        <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                            data-fgColor="#39CCCC">

                        <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="text-center col-4">
                        <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                            data-fgColor="#39CCCC">

                        <div class="text-white">In-Store</div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->

        <!-- Calendar -->
        <div class="card bg-gradient-success">
            <div class="border-0 card-header">

                <h3 class="card-title">
                    <i class="far fa-calendar-alt"></i>
                    Calendar
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                    <!-- button with a dropdown -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                            data-offset="-52">
                            <i class="fas fa-bars"></i>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a href="#" class="dropdown-item">Add new event</a>
                            <a href="#" class="dropdown-item">Clear events</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">View calendar</a>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <!-- /.card-header -->
            <div class="pt-0 card-body">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>

<?php
$content = ob_get_clean();
include 'layouts.php';
?>

<!-- New Orders -->
<script>
    $(document).ready(function () {
        getNumberOfOrders();


        function getNumberOfOrders() {
            $.ajax({
                url: 'orders/getNumberOfOrders.php',
                type: 'GET',
                success: function (data) {
                    $('#NumberOfOrders').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

        }
        // setInterval(getNumberOfOrders, 5000);

        function playSound(url) {
            var audio = new Audio(url);
            audio.play();
        }

        function checkForNewOrder() {
            $.ajax({
                url: 'orders/check_for_new_Order.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.new_order_flag) { //if new_order_flag=1
                        playSound('assets/mixkit-access-allowed-tone-2869.wav');
                    } else {
                        $("#NumberOfOrders").html(response.nooforders);

                    }

                },
                error: function (xhr, status, error) {
                    console.error('Error:', status, error);

                }
            });
        }

        setInterval(checkForNewOrder, 5000);

    });
</script>

<!-- Total Active Items -->
<script>
    $(document).ready(function () {
        getNumberOfItems();

        function getNumberOfItems() {
            $.ajax({
                url: 'inventory/getNumberOfItems.php', //check the file and return the data to id
                type: 'GET',
                success: function (data) {
                    $('#NumberOfItems').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

        }


    });
</script>

<!-- User Registrations -->
<script>
    $(document).ready(function () {
        getNumberOfUsers();

        function getNumberOfUsers() {
            $.ajax({
                url: 'users/getNumberOfUsers.php',
                type: 'GET',
                success: function (data) {
                    $('#NumberOfUsers').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

        }

    });
</script>

<!--New Appointments -->
<script>
    $(document).ready(function () {
        getNumberOfAppointments();

        function getNumberOfAppointments() {
            $.ajax({
                url: 'appointments/getNumberOfAppointments.php',
                type: 'GET',
                success: function (data) {
                    $('#NumberOfAppointments').html(data);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });

        }

    });
</script>

<!-- bar chart -->
<script>
    $(document).ready(function () {
        var barChartCanvas = $('#barChart').get(0).getContext('2d'); //assign canvas
        var months = <?php echo $months_json; ?>;
        var amounts = <?php echo $amounts_json; ?>;

        var barChartData = {
            labels: months,
            datasets: [
                {
                    label: 'Sales Amount',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: amounts,
                    fill: false  // Ensure the area under the line is not filled
                }
            ]
        };

        var barChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }],
                yAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }]
            }
        };

        // Create the chart
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>

<!-- calendar -->
<script>
    $(document).ready(function () {
        setdate();

        
        $('.table').on('click', 'td[data-action="selectDay"]', function () { //get the data when click the cell 
            var selectedDate = $(this).data('day');
            var newUrl = 'showleave.php?date=' +
                selectedDate; //get selected date and pass it to showleave .php file
            window.location.href = newUrl; //redirect path


        });

        //calendar set date
        function setdate() {
            var customDates = <?php echo json_encode($customDates); ?>;
            //php array convert into json encode using json_encode
            customDates = customDates.map(function (
                date) { //pass dates one by one , employee leave dates through customedates
                var dateParts = date.split('-'); //convert date into javascript readerable format
                return dateParts[1] + '/' + dateParts[2] + '/' + dateParts[0];
            });


            $('.table td[data-action="selectDay"]').each(function () {
                var cellDate = $(this).data('day');
                if (customDates.includes(cellDate)) {
                    // Add a class to highlight the matching date
                    $(this).addClass('highlight');
                }
            });


        }

    });
</script>