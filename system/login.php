<?php

session_start();
include '../function.php'; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperZonic | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            
            <img src="assets/dist/img/logo design.jpeg" class="img-fluid" width="150" alt=""/><br>
            <!-- <h1 class="text-white">Superzonic<br><small>computers</small></h1> -->
        </div>
        <!-- <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //check request method

                extract($_POST);  //extract data 

                $username = dataClean($username);

                $message = array();

                if (empty($username)) {
                    $message['username'] = "User Name should not be empty...!";
                }
                if (empty($password)) {
                    $message['password'] = "Password should not be empty...!";
                }

                if (empty($message)) {
                    $db = dbConn();
                    $sql = "SELECT u.* ,d.Designation,d.Id
                    FROM users u
                    INNER JOIN employee e ON e.UserId=u.UserId 
                    INNER JOIN designations d ON d.Id=e.DesignationId 
                    WHERE u.UserName='$username'";
                    $result = $db->query($sql);

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();

                        if (password_verify($password, $row['Password'])) {
                           $_SESSION['USERID'] = $row['UserId'];
                            $_SESSION['FIRSTNAME'] = $row['FirstName'];
                            $_SESSION['LASTNAME'] = $row['LastName'];
                            $_SESSION['DESIGNATION'] = $row['Designation'];
                            header("Location:dashboard.php");
                        } else {
                            $message['password'] = "Invalid User Name or Password...!";
                        }
                    } else {
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?> -->
        <!-- /.login-logo -->
        <div class="card border border-warning login-background">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> -->
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn bg-dark btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="text-danger"><?= @$message['username'] ?></div>
                <div class="text-danger"><?= @$message['password'] ?></div>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>

</html>
<?php
ob_end_flush();
