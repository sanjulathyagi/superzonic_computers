<?php
ob_start();
include_once '../init.php';
$link = "Dashboard";
$breadcrumb_item = "Reports";
$breadcrumb_item_active = "Chart";
?>   


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Pie Chart</h3>

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
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

               

            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<?php
$db = dbConn();
$sql = "SELECT YEAR(o.order_date)AS orderyear,MONTHNAME(o.order_date)AS Month, SUM(oi.unit_price*oi.qty) as TOTALAMOUNT FROM orders o 
                INNER JOIN order_items oi ON oi.order_id=o.id 
                WHERE o.order_date
                GROUP BY Month;";
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
            type: 'pie',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>