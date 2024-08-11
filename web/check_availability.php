<?php
session_start();
include '../config.php';
include 'header.php';
include '../function.php';
?>

<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Appointments</h2>
            <ol>
                <li><a href="index.html">customer</a></li>
                <li>Appointments</li>
            </ol>
        </div>

    </div>
</section><!-- End Breadcrumbs -->
<!-- ======= Contact Us Section ======= -->
<section id="contact" class="contact">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
            <h2>Appoinments</h2>
            <p>Availability</p>
        </div>
        <?php
            extract($_POST);
            $db = dbConn();

            $time_duration = '01:00:00';

            $sql = "SELECT *
            FROM appointments
            WHERE DATE = '$date'
            AND ((start_time >= '$start_time' AND start_time < ADDTIME('$start_time', '$time_duration')) 
            OR (end_time > '$start_time' AND end_time <= ADDTIME('$start_time', '$time_duration')) 
            OR (start_time <= '$start_time' AND end_time >= ADDTIME('$start_time', '$time_duration')));";

            $result = $db->query($sql);

            if ($result->num_rows > 0) {
                echo "<h2 class='text-warning'>Slot is not available for $date at $start_time. Technician might be occupied with another customer for repair.</h2>";
            } else {
                echo "<h2 class='text-success'>Slot is available for $date at $start_time.</h2>";
                $_SESSION['action']='booking';  //check action 
                $_SESSION['date']=$date;
                $_SESSION['time']=$start_time;
                if(isset($_SESSION['USERID'])){
                    echo "<a href='<?= WEB_URL ?>dashboard.php'>Book Now</a>";
                    
                }else{
                    echo "<a href='<?= WEB_URL ?>login.php'>Please Login before make booking</a>";
                }
            }

            
            ?>
</section>

<?php
include 'footer.php';
?>