<?php
session_start();
include 'header.php';
include '../function.php';
?>

<main id="main">
   <!-- ======= Contact Section ======= -->
   <section id="contact" class="contact " style="background: rgb(195,167,34);
background: linear-gradient(0deg, rgba(195,167,34,1) 0%, rgba(17,15,6,1) 100%);">
      <div class="container " data-aos="fade-up">

        <div class="section-title ">
          <h2>Login</h2>
          <p class="text-center text-white">Login</p>
        </div>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                extract($_POST);

                $username = dataClean($username);

                $message = array();

                if (empty($username)) {
                    $message['username'] = "User Name should not be empty...!";
                }
                if (empty($password)) {
                    $message['password'] = "Password should not be empty...!";
                }
                
                if(empty($message)){
                    $db = dbConn();
                    $sql="SELECT * FROM users u INNER JOIN customers c ON c.UserId=u.UserId WHERE u.UserName='$username'";
                    $result=$db->query($sql);                    
                    
                    if($result->num_rows==1){
                       $row=$result->fetch_assoc();
                       
                       if(password_verify($password, $row['Password'])){
                           $_SESSION['USERID']=$row['UserId'];
                           $_SESSION['FIRSTNAME']=$row['FirstName'];
                           header("Location:item.php");
                       }else{
                           $message['password'] = "Invalid User Name or Password...!";
                       }
                       
                       
                    }else{
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?>
        <div class="row justify-content-center">

          <div class= " col-lg-8 mt-5 mt-lg-0 justify-content-center ">

            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form " novalidate>

                
              <div class="form-group mt-3">
                <label for="name" >User Name</label>
                <input type="text" class="form-control" name="username" id="Username" placeholder="Enter your User Name" required>
                <span class="text-danger"><?= @$message['username'] ?></span>
              </div>
              <div class="form-group mt-3">
                <label for="name" >password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                <span class="text-danger"><?= @$message['password'] ?></span>
              </div>
              
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Login</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

 
</main>

<?php
include 'footer.php';
?>  	