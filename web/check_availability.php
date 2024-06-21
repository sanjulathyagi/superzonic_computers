<?php
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
                    echo "Book Now";
                }else{
                    echo "<a href='login.php'>Please Login before make booking</a>";
                }
            }
            ?>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                        class="php-email-form" novalidate>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="first_name">Service type</label>
                                <input type="text" name="first_name" class="form-control border border-1 border-dark "
                                    id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                             
                            </div>
                            <div class="form-group col-md-4 ">
                                <label for="last_name">Item Brand</label>
                                <input type="text" class="form-control border border-1 border-dark" name="last_name"
                                    id="last_name" placeholder="Last Name" required>
                             
                            </div>
                            <div class="form-group col-md-4">
                                <label for="first_name">Item Name</label>
                                <input type="text" name="first_name" class="form-control border border-1 border-dark "
                                    id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                               
                            </div>
                            <div class="form-group col-md-4">
                                <label for="first_name">Repair note(About Issue)</label><br>
                                <textarea name="message" id="message" style="width:150%;height:80%"></textarea>
                               
                            </div><br>
                            
                        </div> 
                        <div class="text-center"><button type="submit" class="btn btn-warning btn-sm">Submit</button></div> 
                       
                        
                    </form>
    </div>
</section>

<?php
include 'footer.php';
?>