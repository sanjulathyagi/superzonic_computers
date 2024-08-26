<?php 

include '../config.php';
include 'header.php';
include '../function.php';



$user_id = $_SESSION['USERID'];

$db = dbConn();

$sql = "SELECT CustomerId
 FROM customers
 WHERE UserId = '$user_id'";
 $result = $db->query($sql);


 if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
 $CustomerId=$row['CustomerId'];

 echo "Customer ID: " . $CustomerId;
}
?>
<!-- ======= Services Section ======= -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>My Account Dashboard</h2>
      <ol>
        <li><a href="index.html">customer</a></li>
        <li>My Account</li>
        
       
      </ol>
    </div>
  </div>
</section>

<section>
  <?php
   // Check if the user is logged in
if (!isset($_SESSION['USERID'])) {
  // User is not logged in, display a message or redirect to login page
  echo "<p>You need to be logged in to view your account dashboard.</p>";
  include 'footer.php';
  exit(); // Stop further execution
}
$db = dbConn();
$sql ="SELECT o.*,c.*
FROM orders o 
INNER JOIN customers c ON c.CustomerId=o.customer_id
WHERE c.CustomerId='$CustomerId' ";
    $order_result = $db->query($sql);
    
?>
  <section id="services" class="services">
    <div class="container" data-aos="fade-up">
      <?php
                        
      if($order_row=$order_result->fetch_assoc()) {
                          
        ?>
      <div class="d-flex justify-content-between align-items-center">
        <div class="row">
          <div class="col-lg-4">
            <div class="icon-box" style="width:400px;height:600px !important;">
              <img src="<?=WEB_URL?>assets/male.jpeg" alt="" width="100">
              <h4>Customer Details</h4>
              RegNo :<?= $order_row['RegNo'] ?>
              <br>
              Name:<?=  $order_row['FirstName'] ?>&nbsp;<?=  $order_row['LastName'] ?>
              <br>
              Email:<?=  $order_row['Email'] ?>

              <br>
              Mobile No:<?=  $order_row['MobileNo'] ?>
              <br>
              Gender:<?=  $order_row['Gender'] ?>
              <br>
            </div>
          </div>
          <div class="dashboard-container">
    <div class="dashboard-header">
        <h2>Welcome to Your Dashboard, [Customer Name]</h2>
    </div>

    <div class="dashboard-content">
        <div class="dashboard-section">
            <h3>Account Details</h3>
            <p><strong>Name:</strong> [Customer Name]</p>
            <p><strong>Email:</strong> [Customer Email]</p>
            <p><strong>Phone:</strong> [Customer Phone]</p>
        </div>

        <div class="dashboard-section">
            <h3>Order History</h3>
            <p>You have [X] orders.</p>
            <p><a href="#">View Order History</a></p>
        </div>

        <div class="dashboard-section">
            <h3>Settings</h3>
            <p><a href="#">Edit Profile</a></p>
            <p><a href="#">Change Password</a></p>
        </div>
    </div>
      </div>
      <?php
         }
        
       ?>
    </div>
  </section>

  </main>
  <?php
  include 'footer.php';
  ?>