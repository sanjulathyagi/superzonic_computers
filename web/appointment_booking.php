<?php 

include '../config.php';
include 'header.php';
include '../function.php';


if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}
checkRole('F');

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
          $db=dbConn();
          $userid=$_SESSION['USERID'];
          $sql = "SELECT CustomerId FROM customers WHERE UserId='$userid'";
          $result = $db->query($sql);
          $row = $result->fetch_assoc();
          $customerid = $row['CustomerId'];
          $app_date = date('Y-m-d');
          $appointment_number = 'App' . date('Y') . date('m') . date('d') . $customerid;
          
          $sql="INSERT INTO appointments(customer_id,item_name,item_brand,service_type,app_id,date,start_time,end_time) VALUES ('$userid','$item_name','$item_brand','$service_type','$appointment_number','$date','$time','00.00.00')";
          $db->query($sql);
          $msg="<h1>SUCCESS</h1>";
          $msg.="<h2>Congratulations</h2>";
          $msg.="<p>Your appointment has been successfully placed</p>";
          $msg="<a href='http://localhost/SIRMS/verify.php'>Click here to verify your account</a>";
          sendEmail($email,$first_name,"Account Verification",$msg);
                        
          header("Location:register_success.php");

          unset($_SESSION['action']);  //clear data
          unset($_SESSION['date']);
          unset($_SESSION['time']);

          echo"<div class='alert bg-success'> your booking has been confirmed...!</div>";
          $_SESSION['appointment_number']=$appointment_number;
        }
        
         if(isset($_SESSION['action'])){  //check the booking is done or not
          if($_SESSION['action']== 'booking'){
             $_SESSION['date'];
             $_SESSION['time'];
            ?>



    <!-- pass data through hidden field -->
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="hidden" name="date" value="<?= $_SESSION['date'] ?>" />
      <input type="hidden" name="time" value="<?= $_SESSION['time'] ?>" />
      <h2><b>Time Slot : <?= $_SESSION['date'] ?> - <?= $_SESSION['time'] ?> </b></h2><br>
      <div class="row justify-content-center">
        <div class="col-lg-3">
          <?php
          $db= dbConn ();
          $sql= "SELECT * FROM items";
          $result=$db->query($sql);
          ?>
          <label for="item_name">Item Name</label>
          <select name="item_name" id="item_name" class="border form-select border-1 border-dark">
            <option value="">--</option>
            <?php
          while ($row= $result->fetch_assoc()){
                                  
         ?>
            <option value="<?= $row['id'] ?>"><?= $row['item_name'] ?></option>
            <?php
         }
         ?>
          </select>
        </div>
        <div class="col-lg-3">
          <?php
          $db= dbConn ();
          $sql= "SELECT * FROM brands";
          $result=$db->query($sql);
          ?>
          <label for="item_name">Item Brand</label>
          <select name="brand" id="brand" class="border form-select border-1 border-dark">
            <option value="">--</option>
            <?php
          while ($row= $result->fetch_assoc()){
                                  
         ?>
            <option value="<?= $row['id'] ?>"><?= $row['brand'] ?></option>
            <?php
         }
         ?>
          </select>
        </div>
        <div class="col-lg-3">

          <?php
          $db= dbConn ();
          $sql= "SELECT * FROM services";
          $result=$db->query($sql);
          ?>
          <label for="item_name">Service Type</label>
          <select name="service_name" id="service_name" class="border form-select border-1 border-dark">
            <option value="">--</option>
            <?php
          while ($row= $result->fetch_assoc()){
                                  
         ?>
            <option value="<?= $row['id'] ?>"><?= $row['service_name'] ?></option>
            <?php
         }
         ?>
          </select>
        </div><br>

        <div class="col-lg-3 ">
          <button type="submit" class="text-center btn btn-warning btn-sm">click here to confirm your booking</button>
        </div>
    </form>

    <?php
          }
        }
        if (isset($_SESSION['cart'])) {
          ?>
    <a href="checkout.php">Checkout</a>
    <?php
            }
            ?>
    <script>
      Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your appointment has been successfully placed",
        showConfirmButton: false,
        timer: 1500
      });
    </script>

  </div>

</section>
<!-- End Breadcrumbs -->

<?php
  include 'footer.php';
  ?>