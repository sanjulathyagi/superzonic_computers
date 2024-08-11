<?php

include '../config.php';
include 'header.php';
include '../function.php';
?>

<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">

        </div>

    </div>
</section><!-- End Breadcrumbs -->
<!-- ======= Contact Us Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Appoinments</h2>
            <p>Availability</p>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                    <div class="icon-box" style="width:1000 !important;">
                        <img src="<?= WEB_URL ?>assets/img/OIP (1).jpeg" alt="laptop" class="first-img"
                            style="height:200px !important;width:200px !important;">
                        <h4>Power up your cart!</h4>
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
                    echo "Book Now";
                    
                }else{
                    echo "<a href='<?= WEB_URL ?>login.php'>Please Login before make booking</a>";
                        }
                        }


                        ?>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


</section>

<?php
include 'footer.php';
?>