<?php 
include 'header.php';
session_start(); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}
include '../function.php';
?>
<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Dashboard</h2>
        <ol>
          <li><a href="index.html">customer</a></li>
          <li>dashboard</li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <section class="inner-page">
    <div class="container">
      <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          extract($_POST);
          $userid=$_SESSION['USERID'];
          $db=dbConn();
          $sql="INSERT INTO appointments(customer_id,date,start_time,end_time) VALUES ('$userid','$date','$time','00.00.00')";
          $db->query($sql);

          unset($_SESSION['action']);
          unset($_SESSION['date']);
          unset($_SESSION['time']);

          echo"<div class='alert bg-success'> your booking has been confirmed...!</div>";
        }
         if(isset($_SESSION['action'])){
          if($_SESSION['action']== 'booking'){
            echo $_SESSION['date'];
            echo $_SESSION['time'];
            ?>
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
  </section>

</main>

<?php
include 'footer.php';
?>