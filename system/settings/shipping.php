<?php
ob_start();
include_once '../init.php';

$link = "Settings";
$breadcrumb_item = "Shipping";
$breadcrumb_item_active = "Manage";
?>


<div class="row">
    <div class="col-lg-12">


        <div class="row justify-content-center ">
            <div class="col-lg-12 align-items-stretch" data-aos="fade-up" data-aos-delay="200">

                <!-- <?php
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                    extract($_GET);
                    $db = dbConn();
                    $sql = "SELECT *
                            FROM contact ";
             
                    $result = $db->query($sql);
                    $row = $result->fetch_assoc();
                
                    $address = $row['address'];
                    $telephone = $row['telephone'];
                    $mobile = $row['mobile'];
                    $email = $row['email '];
                    $note = $row['note'];
                   
                }
                
                  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    $address = dataClean($address);
                    $telephone = dataClean($telephone);
                    $mobile = dataClean($mobile);
                    $email = dataClean($email);
                    $note = dataClean($note);

                    $message = array();
            

                    if (empty($message)) {
              
                        $db = dbConn();
                        $sql = "UPDATE contact  SET address='$address',Email='$Email',telephone='$telephone',mobile='$mobile',
                        note='$note',telephone='$telephone' WHERE ContactId='$ContactId'";
                        $db->query($sql);
                
                        header("Location:manage.php");
                    }
                }
                  ?> -->
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                    class="php-email-form" novalidate>
                    <div class="card border-dark">
                        <div class="card-header bg-dark text-white">
                            <h5 class="card-title mb-0">Shipping Fee</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="input-distance">Distance (in kilometers):</label>
                                <input type="number" id="input-distance" name="distance" class="form-control"
                                    placeholder="Enter distance">
                            </div>
                            <div class="form-group">
                                <label for="input-price">Price:</label>
                                <input type="text" id="input-price" name="price" class="form-control"
                                    placeholder="Calculated price" readonly>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-dark text-center">
                            <button type="submit" class="btn btn-warning">Calculate Shipping Fee</button>
                        </div>
                    </div>
                </form>




            </div>
            </div>
        </div>
        <!-- /.card -->
    </div>


    <?php
$content= ob_get_clean();
include '../layouts.php';
?>