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
                <p>New Orders</p>
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

        <!--/.direct-chat -->

        <!-- TO DO List -->

        <!-- /.card -->
    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

        <!-- Map card -->


        <!-- /.card -->

        <!-- solid sales graph -->

        <!-- /.card -->

        <!-- Calendar -->

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