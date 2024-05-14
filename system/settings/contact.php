<?php
ob_start();
include_once '../init.php';

$link = "Settings";
$breadcrumb_item = "Contact";
$breadcrumb_item_active = "Manage";
?>

<div class="row justify-content-center ">
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">

                        <div class="row justify-content-center ">
                            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up"
                                data-aos-delay="200">
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
                                        <h3 class="card-title">Contact Details</h3>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="address"> Address &nbsp;(<i
                                                            class="fa fa-address-card" aria-hidden="true"></i>)</label>
                                                    <input type="text" id="address" name="address"
                                                        class="form-control form-control-alternative"
                                                        placeholder="Address" value="<?= @$address ?>">
                                                    <span class="text-danger"><?= @$message['address'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="telephone"> Telephone
                                                        &nbsp;(<i class="fa fa-phone" aria-hidden="true"></i>)</label>
                                                    <input type="text" id="telephone" name="telephone"
                                                        class="form-control form-control-alternative"
                                                        placeholder="telephone" value="<?= @$telephone ?>">
                                                    <span class="text-danger"><?= @$message['telephone'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="mobile"> Mobile &nbsp;(<i
                                                            class="fa fa-mobile" aria-hidden="true"></i>)</label>
                                                    <input type="text" id="mobile" name="mobile"
                                                        class="form-control form-control-alternative"
                                                        placeholder="mobile" value="<?= @$mobile ?>">
                                                    <span class="text-danger"><?= @$message['mobile'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="email"> Email &nbsp;(<i
                                                            class="fa fa-envelope" aria-hidden="true"></i>)</label>
                                                    <input type="text" id="email" name="email"
                                                        class="form-control form-control-alternative"
                                                        placeholder="email" value="<?= @$email ?>">
                                                    <span class="text-danger"><?= @$message['email'] ?></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-control-label" for="email">Special Note:</label>
                                                    <textarea class="form-control form-control-alternative" type="text"
                                                        name="note" id="description" class="form-control" cols="30"
                                                        rows="10"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="text-center ">
                                                        <input type="hidden" name="status">
                                                        <button type="submit" class="btn btn-warning">Update</button>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </form>
                            </div>


                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content= ob_get_clean();
include '../layouts.php';
?>