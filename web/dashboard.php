<?php 
include 'header.php';
include '../function.php';
session_start(); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}
?>
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Dashboard</h2>
      <ol>
        <li><a href="index.html">Customer</a></li>
        <li>dashboard</li>
      </ol>
    </div>

  </div>
</section>
<section class="inner-page">
  <div class="container">
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
    <!-- pass data through hidden field -->
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="date" value="<?= $_SESSION['date'] ?>" />
      <input type="hidden" name="time" value="<?= $_SESSION['time'] ?>" />
      <button type="submit" class="btn btn-warning">click here to confirm your booking</button>
    </form>
    <?php
          }
        }
         
         
         ?>
  </div>

</section><!-- End Breadcrumbs -->



</main>
<?php
  include 'footer.php';
  ?>

</html>