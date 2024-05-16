<?php
// session_start();
// if(!isset($_session['USERID'])){
//   header("Location:login.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuperZonic | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.css">
    

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= SYS_URL ?>assets/dist/img/logo design.jpeg" alt="AdminLTELogo"
                height="60" width="60">
        </div>
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #b99a45">
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?= SYS_URL ?>logout.php" role="button">
                        Logout
                    </a>
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= SYS_URL ?>assets/dist/img/logo design.jpeg" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Superzonic</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= SYS_URL ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <!-- <div class="info">
                        <a href="#" class="d-block"><?= $_SESSION['FIRSTNAME']." ".$_SESSION['LASTNAME'] ?></a>
                    </div> -->
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>dashboard.php">
                                <i class="fas fa-chart-bar" aria-hidden="true"></i>
                                <span class="hide-menu">Dashboard</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>users/manage.php">
                                <i class="fas fa-user" aria-hidden="true"></i>
                                <span class="hide-menu">User management</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#item-menu" data-toggle="collapse" aria-expanded="true"
                                class="dropdown-toggle">
                                <i class="fas fa-laptop"></i>&nbsp;&nbsp;Inventory management</a>
                            <ul class="collapse list-unstyled" id="item-menu">
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= SYS_URL ?>inventory/items.php">
                                        <i class="ml-4 fas fa-keyboard"></i>
                                        <span class="hide-menu">&nbsp;Items</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= SYS_URL ?>inventory/stock_receive.php">
                                        <i class="ml-4 fas fa-cubes"></i><span class="hide-menu">&nbsp;Stock
                                            Receive</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= SYS_URL ?>inventory/stock_return.php">
                                        <i class="ml-4 fas fa-undo"></i><span class="hide-menu">&nbsp;Stock
                                            Return</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#item-menu" data-toggle="collapse" aria-expanded="true"
                                class="dropdown-toggle">
                                <i class="fas fa-cart-arrow-down"></i>&nbsp;&nbsp;Order Management</a>
                            <ul class="collapse list-unstyled" id="item-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>orders/manage.php">
                                        <i class="ml-4 fas fa-headset"></i>
                                        <span class="hide-menu">&nbsp;Orders</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="<?= SYS_URL ?>orders/quotation.php">
                                        <i class="ml-4 fas fa-paste"></i><span class="hide-menu">&nbsp;Quotations</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#item-menu" data-toggle="collapse" aria-expanded="true"
                                class="dropdown-toggle">
                                <i class="fas fa-people-carry"></i>&nbsp;&nbsp;Supplier Management</a>
                            <ul class="collapse list-unstyled" id="item-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>suppliers/manage.php">
                                        <i class="ml-4 fas fa-user-plus"></i>
                                        <span class="hide-menu">&nbsp;Suppliers</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>suppliers/invoice.php">
                                        <i class="ml-4 fas fa-file-invoice"></i>
                                        <span class="hide-menu">&nbsp;Invoices</span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>customers/manage.php">
                                <i class="fas fa-user-friends" aria-hidden="true"></i>
                                <span class="hide-menu">Customer Management</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>appointments/manage.php">
                                <i class="fas fa-tools" aria-hidden="true"></i>
                                <span class="hide-menu">Appointment Management</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>faq/manage.php">
                                <i class="fas fa-server" aria-hidden="true"></i>
                                <span class="hide-menu">FAQ</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="<?= SYS_URL ?>services/manage.php">
                                <i class="fas fa-truck" aria-hidden="true"></i>
                                <span class="hide-menu">Services</span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#item-menu" data-toggle="collapse" aria-expanded="true"
                                class="dropdown-toggle">
                                <i class="fas fa-cog"></i>&nbsp;&nbsp;Settings</a>
                            <ul class="collapse list-unstyled" id="item-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>settings/social.php">
                                        <i class="ml-4 fas fa-users"></i>
                                        <span class="hide-menu">&nbsp;Social</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>settings/contact.php">
                                        <i class="ml-4 fas fa-phone"></i>
                                        <span class="hide-menu">&nbsp;Contact</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>settings/open_time.php">
                                        <i class="ml-4 fas fa-clock"></i>
                                        <span class="hide-menu">&nbsp;Open Time</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= SYS_URL ?>settings/shipping.php">
                                        <i class="ml-4 fas fa-shipping-fast"></i>
                                        <span class="hide-menu">&nbsp;Shipping</span>
                                    </a>
                                </li>

                            </ul>
                        </li>





                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= @$link ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><?=@$breadcrumb_item ?></a></li>
                                <li class="breadcrumb-item active"><?=@$breadcrumb_item_active ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    <?php echo $content ?>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; @2024 <a href="https://adminlte.io">SuperZonic</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">

            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= SYS_URL ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= SYS_URL ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= SYS_URL ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= SYS_URL ?>assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= SYS_URL ?>assets/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= SYS_URL ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= SYS_URL ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= SYS_URL ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= SYS_URL ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?= SYS_URL ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= SYS_URL ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= SYS_URL ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= SYS_URL ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= SYS_URL ?>assets/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= SYS_URL ?>assets/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= SYS_URL ?>assets/dist/js/pages/dashboard.js"></script>

    <script src="<?= SYS_URL ?>assets/js/sweetalert.min.js"></script>

</body>

</html>