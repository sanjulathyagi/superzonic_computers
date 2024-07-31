<?php 
include 'header.php';
// session_start(); 
// if(!isset($_SESSION['USERID'])){
//     header("Location:login.php");
// }
include '../function.php';
?>
<main id="main">

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

  <section class="inner-page">
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Do you need our help?</h3>
          <p> Hardware Repairs,  Software Troubleshooting,Data Recovery,  Networking and Connectivity Issues,  <br>Custom
            Builds and Upgrades and Consultation and Advice.</p>
          <form method="post" action="check_availability.php">
            <div class="row g-3">
              <div class="col">
                <input type="date" class="form-control" placeholder="select date" name="date" width="30px">
              </div>
              <div class="col">
                <input type="time" class="form-control" placeholder="select time" name="start_time" width="30px">
              </div>
            </div><br>
            <button type="submit" class="btn btn-warning">Check Availability</button>
            
          </form>
        </div>

      </div>
    </section><!-- End Cta Section -->
    <!-- <div class="container">
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //store data to appointment table
          extract($_POST); //get form data
          $userid=$_SESSION['USERID'];
          $db=dbConn();
          $sql="INSERT INTO appointments(customer_id,date,start_time,end_time) VALUES ('$userid','$date','$time','00.00.00')";
          $db->query($sql);

          unset($_SESSION['action']);  //clear data
          unset($_SESSION['date']);
          unset($_SESSION['time']);

          echo"<div class='alert bg-success'> your booking has been confirmed...!</div>";
        }
         if(isset($_SESSION['action'])){  //check the booking is done or not
          if($_SESSION['action']== 'booking'){
            echo $_SESSION['date'];
            echo $_SESSION['time'];
            ?>
      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> //pass data through hidden field
        <input type="hidden" name="date" value="<?= $_SESSION['date'] ?>" />
        <input type="hidden" name="time" value="<?= $_SESSION['time'] ?>" />
        <button type="submit" class="btn btn-warning">click here to confirm your booking</button>
      </form> -->
      <?php
          }
        }
         
         
         ?>

    </div> -->
  </section>

</main>

<?php
include 'footer.php';
?>