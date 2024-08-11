<?php
ob_start();

include '../config.php';
include '../function.php';
include 'header.php';

?>
<!DOCTYPE html>
<html lang="en">
<body>
<main id="main">
    <section id="contact" class="contact ">

        <?php
        extract($_GET);
        $db=dbConn();
        $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_expiration > NOW()";
        $result = $db->query($sql);

        extract($_POST);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if(empty($password)) {
                $message['password'] = "Password id required";
            }
            if(empty($confirm_password)) {
                $message['confirm_password'] = " Confirm Password id required";
            }

            if(!empty($password)) {
                if(strlen($password) < 0) {
                    $message['password'] = "The Password should be 8 characters or more"; 
                }
            }

            if(!empty($password && $confirm_password)) {
                if($password != $confirm_password) {
                    $message['confirm_password'] = "The Password do not match"; 
                }
            }

            
           
            $new_password = $_POST['new_password'];
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Verify the reset token and check if it's still valid
            $db =dbConn();
            $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_expiration > NOW()";
            $result = $db->query($sql);
    

            if ($result->num_rows > 0) {
            // Update the user's password
            $row = $result->fetch_assoc();
            $userid = $row['userid'];
            $update_sql = "UPDATE users SET password='$hashed_password', reset_token=NULL, reset_expiration=NULL WHERE userid='$userid'";
            if ($db->query($update_sql) === TRUE) {
                echo "Your password has been reset successfully.";
                header("Location:login.php");
             } else {
                echo "Error updating record: " . $db->error;
            }
        } else {
            $message['userid'] ="Invalid or expired token.";
        }

         }
        

        ?>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 justify-content-center">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                        class="php-email-form" novalidate>
                        <div class="mt-3 form-group">
                            <input type="text" name="token" value="<?php echo $token ?>">
                        </div>
                        <div class="mt-3 form-group">
                            <label for="name">New password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                placeholder="password" required>
                            <span class="text-danger"><?= @$message['password'] ?></span>
                        </div>
                        <div class="mt-3 form-group">
                            <label for="name">Confirm password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="confirm_password" required>
                            <span class="text-danger"><?= @$message['confirm_password'] ?></span>
                        </div>
                        <button type="submit">Reset Password</button>
                    </form>
                </div>
            </div>
        </section><!-- End Contact Section -->
    </main>
</body>
</html>
<?php
include 'footer.php';
ob_end_flush();
?>