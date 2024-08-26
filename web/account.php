<?php 

include '../config.php';
include 'header.php';
include '../function.php';

// Check if the user is logged in
if (!isset($_SESSION['USERID'])) {
  echo "<p>You need to be logged in to view your account dashboard.</p>";
  include 'footer.php';
  exit(); 
}

$user_id = $_SESSION['USERID'];
$db = dbConn();

// Get Customer ID
$sql = "SELECT CustomerId FROM customers WHERE UserId = '$user_id'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $CustomerId = $row['CustomerId'];
}
// Get Order Count
$sql_count = "SELECT COUNT(*) AS order_count FROM orders WHERE customer_id = '$CustomerId'";
$count_result = $db->query($sql_count);
$count_row = $count_result->fetch_assoc();
$order_count = $count_row['order_count'];

// Get Order and Customer Details
$sql = "SELECT o.*, c.* FROM orders o INNER JOIN customers c ON c.CustomerId = o.customer_id WHERE c.CustomerId = '$CustomerId'";
$order_result = $db->query($sql);

?>
<!-- ======= Breadcrumbs ======= -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>My Account Dashboard</h2>
      <ol>
        <li><a href="index.html">Home</a></li>
        <li>My Account</li>
      </ol>
    </div>
  </div>
</section>

<!-- ======= Dashboard Section ======= -->
<section class="dashboard">
  <div class="container">
    <div class="row">
      <!-- Customer Details Section -->
      <div class="col-lg-3">
        <div class="card mb-4">
          <div class="card-body">
            <?php if ($order_row = $order_result->fetch_assoc()) { ?>
            <img src="<?=WEB_URL?>assets/male.jpeg" alt="Profile Picture" width="100" class="mb-3">
            <h4>Customer Details</h4>
            <p><strong>RegNo:</strong> <?= $order_row['RegNo'] ?></p>
            <p><strong>Name:</strong> <?= $order_row['FirstName'] ?> <?= $order_row['LastName'] ?></p>
            <p><strong>Email:</strong> <?= $order_row['Email'] ?></p>
            <p><strong>Mobile No:</strong> <?= $order_row['MobileNo'] ?></p>
            <p><strong>Gender:</strong> <?= $order_row['Gender'] ?></p>

            <h4>Order History</h4>
            <p>You have <b> <?= $order_count ?></b> orders.</p>


            <h4>Settings</h4>
            <p><a href="javascript:void(0);" onclick="toggleEditForm()">Edit Profile</a></p>
            <p><a href="#" onclick="toggleChangePasswordForm()">Change Password</a></p>
            <?php } else { ?>
            <p>No customer details found.</p>
            <?php } ?>
          </div>
        </div>
      </div>

      <!-- Main Content Section (col-lg-9) -->
      <div class="col-lg-9">
        <div class="container">
          <!-- Order Information Table (Visible by Default) -->
          <div id="orderInformation" style="display: block;">
            <h4>Order Information</h4>

            <?php
            $db = dbConn();
                $sql = "SELECT o.*,c.FirstName,c.LastName 
                FROM orders o 
                INNER JOIN customers c 
                    ON c.CustomerId=o.customer_id 
                    WHERE c.CustomerId='$CustomerId'";

                $result = $db->query($sql);
                ?>
            <!-- Add your order information table here -->
            <table class="table table-hover text-nowrap" id="myTable">
              <thead>
                <tr>
                  <th>Order Id</th>
                  <th>Order Date</th>
                  <th>Customer</th>
                  <th>Order Number</th>
                  <th>Amount(Rs.)</th>
                  <th>Status</th>
                  <th>Actions</th>


                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php

                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              // Store the order number in session
                            $_SESSION['order_number'] = $row['order_number'];
                                ?>
                <tr>
                  <td><?= $row['id'] ?></td>
                  <td><?= $row['order_date'] ?></td>
                  <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                  <td><?= $row['order_number'] ?></td>
                  <td><?= $row['total_amount'] ?></td>
                  <td>
                    <?php 
                                if ($row['order_status'] == 0) {
                                    echo '<span class="badge badge-warning btn btn-warning btn-sm">Pending</span>';
                                } elseif($row['order_status'] == 1) {
                                    echo '<span class="badge badge-info btn btn-info btn-sm">Issued</span>';
                                    
                                } elseif($row['order_status'] == 2) {
                                        echo '<span class="badge badge-secondary btn btn-secondary btn-sm">Shipping</span>';
                                    
                                } elseif($row['order_status'] == 3) {
                                        echo '<span class="badge badge-success btn btn-uccess btn-sm">Delivered</span>';
                                } elseif($row['order_status'] == 4) {
                                    echo '<span class="badge badge-danger btn btn-danger btn-sm">Canceled</span>';
                                }
                                ?>
                  </td>

                  <td><a href="<?= WEB_URL ?>/Payment.php?order_number=<?= urlencode($_SESSION['order_number']) ?>"
                      class="btn btn-secondary btn-sm" style="width: 90px;"><i
                        class="fas fa-arrow-alt-circle-right"></i> Payment</a>
                  </td>


                </tr>

                <?php
                            }
                        }
                        ?>
              </tbody>
            </table>
          </div>

          <!-- Edit Profile Form (Hidden by Default) -->
          <div id="editProfileForm" style="display:none;">
            <div class="card mb-4">
              <div class="card-header">
                <h4 class="card-title">Edit Profile</h4>
              </div>
              <div class="card-body">
                <form action="update_profile.php" method="post">
                  <div class="form-group">
                    <label for="inputFirstName">First Name</label>
                    <input type="text" class="form-control" id="inputFirstName" name="first_name"
                      value="<?= $order_row['FirstName'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputLastName">Last Name</label>
                    <input type="text" class="form-control" id="inputLastName" name="last_name"
                      value="<?= $order_row['LastName'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" class="form-control" id="inputEmail" name="email"
                      value="<?= $order_row['Email'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="inputMobileNo">Mobile No</label>
                    <input type="text" class="form-control" id="inputMobileNo" name="mobile_no"
                      value="<?= $order_row['MobileNo'] ?>">
                  </div>
                  <button type="submit" class="btn btn-warning btn-sm">Update Profile</button>
                </form>
              </div>
            </div>
          </div>
          <!-- Change Password Form -->
          <div id="changePasswordForm" style="display: none;">
            <form action="update_password.php" method="post">
              <h4>Change Password</h4>
              <div class="form-group">
                <label for="currentPassword">Current Password:</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword">
              </div>
              <div class="form-group">
                <label for="newPassword">New Password:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword">
              </div>
              <div class="form-group">
                <label for="confirmPassword">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
              </div>
              <button type="submit" class="btn btn-warning btn-sm">Change Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>

<script>
  // JavaScript to toggle the visibility of the edit profile form
  function toggleEditForm() {
    var form = document.getElementById('editProfileForm');
    if (form.style.display === "none") {
      form.style.display = "block";
    } else {
      form.style.display = "none";
    }
  }

  function toggleChangePasswordForm() {
    var form = document.getElementById('changePasswordForm');
    if (form.style.display === "none") {
      form.style.display = "block";
    } else {
      form.style.display = "none";
    }
  }
</script>

<?php include 'footer.php'; ?>