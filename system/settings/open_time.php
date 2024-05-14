<?php
ob_start();
include_once '../init.php';

$link = "Settings";
$breadcrumb_item = "Contact";
$breadcrumb_item_active = "Manage";
?>





<div class="row">
    <div class="col-12">

        <div class="row justify-content-center ">
            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
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
                        <h3 class="card-title">Opening Time Details</h3>
                    </div>

                    <div class="container-fluid">
                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Monday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close">
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Tuesday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Wednesday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Thursday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Friday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Saturday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <label class="form-control-label" for="input-name">Sunday</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="">Open Time & Close
                                        Time</span>
                                </div>
                                <div class="input-group-text">
                                    <input type="checkbox" id="" onclick="" class="daysCheckbox">
                                </div>
                                <input type="time" class="form-control dayselect" id="" placeholder="Open Time" required
                                    name="open" value="">
                                <input type="time" class="form-control dayselect" id="" placeholder="Close Time"
                                    required name="close" value="">
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="form-control-label" for="input-name"> Special Note
                                </label>
                                <input type="text" id="input-name" name="note" class="form-control dayselect"
                                    placeholder="Enter Special Note " value="">

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
    </div>
    <!-- /.card -->
</div>




<?php
$content= ob_get_clean();
include '../layouts.php';
?>