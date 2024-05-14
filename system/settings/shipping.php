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
                    <div class="card-header bg-dark">
                        <h3 class="card-title">Shipping fee</h3>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name"> Price</label>
                                    <input type="text" id="input-name" name="price"
                                        class="form-control form-control-alternative" placeholder="Price" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class=" text-center">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
          


        </div>
    </div>
    <!-- /.card -->
</div>


<?php
$content= ob_get_clean();
include '../layouts.php';
?>