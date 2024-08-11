<?php 

include '../config.php';
include 'header.php';
include '../function.php';
extract($_GET); 

?>
<!-- ======= Services Section ======= -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>My Account Dashboard</h2>
      <ol>
        <li><a href="index.html">customer</a></li>
        <li>Dashboard</li>
      </ol>
    </div>
  </div>
</section>
<section>
  <?php
$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName 
FROM orders o 
INNER JOIN customers c 
    ON c.CustomerId=o.customer_id";

$result = $db->query($sql);
$row = $result->fetch_assoc();
?>


  <section id="services" class="services">
    <div class="container" data-aos="fade-up">
      <div class="d-flex justify-content-between align-items-center">
        <div class="row">
          <div class="col-lg-4">
            <div class="icon-box" style="width:400px;height:600px !important;">
              <img src="<?=WEB_URL?>assets/male.jpeg" alt="" width="100">
              <h4>Customer Details</h4>
              <?= $row['RegNo'] ?>
              <br>
              <?=  $row['FirstName'] ?>&nbsp;<?=  $row['LastName'] ?>
              <br>
              <?=  $row['Email'] ?>
              <br>
              <br>
              <?=  $row['MobileNo'] ?>
              <br>
              <?=  $row['Gender'] ?>
              <br>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="icon-box" style="width:400px;height:600px  !important;">
            <h4>Billing Details</h4>
            <?= $row['billing_name'] ?>
            <br>
            <?= $row['billing_address'] ?>
            <br>
            <?= $row['billing_phone'] ?>
            <br>
            <h4>Delivery Details</h4>
            <?= $row['delivery_name'] ?>
            <br>
            <?= $row['delivery_address'] ?>
            <br>
            <?= $row['delivery_phone'] ?>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="icon-box" style="width:400px;height:600px  !important;">
            <h4>Order Details</h4>
            <?= $row['billing_name'] ?>
            <br>
            <?= $row['billing_address'] ?>
            <br>
            <?= $row['billing_phone'] ?>
            <br>
            <h4>Appointment Details</h4>
            <?= $row['delivery_name'] ?>
            <br>
            <?= $row['delivery_address'] ?>
            <br>
            <?= $row['delivery_phone'] ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  </main>
  <?php
  include 'footer.php';
  ?>