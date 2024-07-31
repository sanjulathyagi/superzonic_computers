<?php 

session_start(); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}
include '../function.php';

checkRole("F");
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
  </section>

</main>
<section class="inner-page">
      <div class="container-fluid ">
        <div class="p-5 bg-light rounded">
          <div class="row g-4">
            <div class="col-4">
              <div class="card">
                <img src="assets/img/image11.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card">
                <img src="assets/img/download image/1.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card">
                <img src="assets/img/download image/2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card">
                <img src="assets/img/download image/3.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card">
                <img src="assets/img/download image/4.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
            <div class="col-4">
              <div class="card">
                <img src="assets/img/download image/5.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                    card's content.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php
include 'footer.php';
?>