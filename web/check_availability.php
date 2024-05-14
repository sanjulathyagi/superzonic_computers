<?php
include 'header.php';
include '../function.php';
?>
<main id="main">
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
                $_SESSION['action']='booking';
                $_SESSION['date']=$date;
                $_SESSION['time']=$start_time;
                if(isset($_SESSION['USERID'])){
                    echo "Book Now";
                }else{
                    echo "<a href='login.php'>Please Login before make booking</a>";
                }
            }
            ?>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>