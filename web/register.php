<?php
ob_start();
// session_start();
include 'header.php';
include '../function.php';
include '../mail.php';
?>

<main id="main">
    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact" style="border:solid">
        <div class="container " data-aos="fade-up">

            <div class="text-center section-title">
                <h2>Customer</h2>
                <p>Register</p>
            </div>
            <div class="row justify-content-center ">
                <div class="mt-5 col-lg-7 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                    <?php
                    //check request method ,form data to check submit 
                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    $first_name = dataClean($first_name);
                    $last_name = dataClean($last_name);
                    $address_line1 = dataClean($address_line1);
                    $address_line2 = dataClean($address_line2);
                    $address_line3 = dataClean($address_line3);

                    $message = array();
                    //Required validation-----------------------------------------------
                    if (empty($first_name)) {
                        $message['first_name'] = "The first name should not be blank...!";
                    }
                    if (empty($last_name)) {
                        $message['last_name'] = "The last name should not be blank...!";
                    }
                    if (!isset($gender)) {
                        $message['gender'] = "Gender is required";
                    }
                    if (!isset($mobile_no)) {
                        $message['mobile_no'] = "mobile_no is required";
                    }
                    if (empty($user_name)) {
                        $message['user_name'] = "User Name is required";
                    }
                    if (empty($password)) {
                        $message['password'] = "Password is required";
                    }
                    if (empty($confirm_password)) {
                        $message['confirm_password'] = "confirm Password is required";
                    }


                    //Advance validation------------------------------------------------
                    if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
                        $message['first_name'] = "Only letters and white space allowed";
                    }
                    if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
                        $message['last_name'] = "Only letters and white space allowed";
                    }

                    //email validation and check exist or not
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $message['email'] = "Invalid Email Address...!";
                    } else {
                        $db = dbConn();
                        $sql = "SELECT * FROM customers WHERE Email='$email'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $message['email'] = "This Email address already exist...!";
                        }
                    }
                    //check exist username 
                    if(!empty($user_name)){
                        $db = dbConn();
                        $sql = "SELECT * FROM users WHERE UserName='$user_name'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            $message['user_name'] = "This User Name already exist...!";
                        }
                    }

                    //check length of the password
                    if(!empty($password)){
                        if(strlen($password)<8){
                            $message['password']="The password should be 8 characters or more";
                        }
                    }

                    if (empty($message)) {
                        //Use bcrypt hasing algorithem
                        $pw= password_hash($password,PASSWORD_DEFAULT);
                        $db = dbConn();
                        $sql = "INSERT INTO users('UserName','Password','FirstName','LastName','UserType','status') VALUES ('$user_name','$pw','$first_name','$last_name','customer','1')";
                        $db->query($sql);

                        $user_id = $db->insert_id;
                        
                        $reg_number=date('Y').date('m').date('d').$user_id;
                        $_SESSION['RNO']=$reg_number;
                        $sql = "INSERT INTO customers('FirstName', 'LastName', 'Email', 'AddressLine1', 'AddressLine2', 'AddressLine3', 'TelNo', 'MobileNo', 'Gender', 'DistrictId','RegNo','UserId') VALUES ('$first_name','$last_name','$email','$address_line1','$address_line2','$address_line3','$telno','$mobile_no','$gender','$district','$reg_number','$user_id')";
                        $db->query($sql);
                        $msg="<h1>SUCCESS</h1>";
                        $msg.="<h2>Congratulations</h2>";
                        $msg.="<p>Your account has been successfully created</p>";
                        $msg="<a href='http://localhost/SIRMS/verify.php'>Click here to verify your account</a>";
                        sendEmail($email,$first_name,"Account Verification",$msg);
                        
                        header("Location:register_success.php");
                        
                    }
                }
                  ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                        class="border php-email-form border-1" novalidate>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="border form-control border-1 border-dark "
                                    id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                            </div>
                            <div class="mt-3 form-group col-md-6 mt-md-0">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="border form-control border-1 border-dark" name="last_name"
                                    id="last_name" value="<?= @$last_name ?>"  placeholder="Last Name" required>
                                <span class="text-danger"><?= @$message['last_name'] ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="text" class="border form-control border-1 border-dark" name="email"
                                    id="email" value="<?= @$email ?>" placeholder="Email" required>
                                <span class="text-danger"><?= @$message['email'] ?></span>
                            </div>
                            <div class="mt-3 form-group col-md-6 mt-md-0">
                                <label for="telno">Tel. No.(Home)</label>
                                <input type="text" class="border form-control border-1 border-dark" name="telno"
                                    id="telno" placeholder="Tel. No." value="<?= @$telno ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 ">
                                <label for="address_line1">Address Line 1</label>
                                <input type="text" class="border form-control border-1 border-dark" name="address_line1"
                                    id="address_line1" value="<?= @$address_line1 ?>" placeholder="Address Line 1" required>
                            </div>
                            <div class="mt-3 form-group col-md-6 mt-md-0">
                                <label for="mobile_no">Mobile No.</label>
                                <input type="text" class="border form-control border-1 border-dark" name="mobile_no"
                                    id="mobile_no" value="<?= @$last_name ?>" placeholder="Mobile No" required>
                                    <span class="text-danger"><?= @$message['mobile_no'] ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="address_line2">Address Line 2</label>
                                <input type="text" class="border form-control border-1 border-dark" name="address_line2"
                                    id="address_line2" placeholder="Address Line 2" value="<?= @$address_line2 ?>" required>
                            </div>
                            <div class="mt-3 form-group col-md-6 mt-md-0">
                                <label for="address_line3">City</label>
                                <input type="text" class="border form-control border-1 border-dark" name="address_line3"
                                    id="address_line3" value="<?= @$address_line3 ?>" placeholder="city" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row ">
                                <div class="form-group ">
                                    <label>Select Gender</label>
                                    <div class="form-check">
                                        <input class="border form-check-input border-1 border-dark"
                                            style="border-radius: 50px !important;width:15px;height:15px" type="radio"
                                            name="gender" id="male" value="male">
                                        <label class="form-check-label" for="male">
                                            Male
                                        </label>
                                    </div>

                                </div>
                                <div class="form-group ">
                                    <div class="form-check">
                                        <input class="border form-check-input border-1 border-dark"
                                            style="border-radius: 20px !important;width:15px;height:15px" type="radio"
                                            name="gender" id="female" value="female">
                                        <label class="form-check-label" for="female">
                                            Female
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-4 text-danger"><?= @$message['gender'] ?></div>
                            </div>
                            <div class="mt-3 form-group">
                                <?php
                              $db= dbConn ();
                              $sql= "SELECT * FROM districts";
                              $result=$db->query($sql);
                              ?>
                                <label for="district">District</label>
                                <select name="district" id="district"
                                    class="mb-3 border form-select form-select-lg border-1 border-dark"
                                    aria-label="Large select example">
                                    <option value="">--</option>
                                    <?php
                                 while ($row= $result->fetch_assoc()){
                                  
                                 ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                 }
                                
                                ?>
                                </select>
                                <div class="mt-3 form-group ">
                                    <label for="user_name">User Name</label>
                                    <input type="text" class="border form-control border-1 border-dark" name="user_name"
                                        id="user_name" placeholder="Username" required>
                                    <span class="text-danger"><?= @$message['user_name'] ?></span>
                                </div>
                                <div class="mt-3 form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="border form-control border-1 border-dark"
                                        name="password" id="password" placeholder="Password" required>
                                    <span class="text-danger"><?= @$message['password'] ?></span>
                                </div>
                                <div class="mt-3 form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="confirm_password" class="border form-control border-1 border-dark"
                                        name="confirm_password" id="confirm_password" placeholder="confirm_password" required>
                                    <span class="text-danger"><?= @$message['confirm_password'] ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section><!-- End Contact Section -->
</main>

<?php
include 'footer.php';
ob_end_flush();
?>