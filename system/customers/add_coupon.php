<?php
ob_start();
session_start();

include_once '../init.php';
include_once '../../function.php';

$link = "Customer Management";
$breadcrumb_item = "Coupon";
$breadcrumb_item_active = "Add";

$alert=false;

//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $discount = dataClean($discount);
    $start_date= dataclean($start_date);
    $valid_period = dataClean($valid_period);
    $used_count = dataClean($used_count);

  

    $message = array();

    if (empty( $discount)) {
        $message['discount'] = "The discount should not be blank...!";
    }
    if (empty($start_date)) {
        $message['start_date'] = "The start_date should not be blank...!";
    }
    if (empty($valid_period)) {
        $message['valid_period'] = "The valid_period should not be blank...!";
    }
    if (empty($used_count)) {
        $message['used_count'] = "The used_count should not be blank...!";
    }

    
   
   
    if (empty($message)) {
       
        $db = dbConn(); 
        $sql = "INSERT INTO coupons(discount,start_date,valid_period,used_count) VALUES ('$discount','$start_date','$valid_period','$used_count')";
        $db->query($sql);
        $coupon_id = $db->insert_id;
        $alert=true;
        $coupon_code = date('Y').date('m').date('d').$coupon_id;
        $_SESSION['coupon_code']=$coupon_code;
        $sql = "UPDATE `coupons` SET `coupon_code`='$coupon_code' WHERE coupon_id='$coupon_id'";
        $db->query($sql);
        
        
        
        header("Location:coupon.php");

        }
    }
    


?>
<?php
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "coupon code has been generated<br> coupon code is <?= $_SESSION['coupon_code'] ?> ",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>customers/coupon.php" class="mb-2 btn bg-warning"><i class="fas fa-plus-circle"></i> View
            coupons</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New coupon</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputdiscount">Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount"
                                    placeholder="Enter discount" value="<?= @$discount ?>">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputstartdate">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    placeholder="Enter start_date" value="<?= @$start_date ?>">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputvalidperiod">Valid Period</label>
                                <input type="number" class="form-control" id="valid_period" name="valid_period"
                                    placeholder="Enter valid_period" value="<?= @$valid_period ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group ">
                            <label for="inputusedcount">Used Count</label>
                            <input type="number" class="form-control" id="used_count" name="used_count"
                                placeholder="Enter used count" value="<?= @$used_count ?>">
                        </div>

                    </div>
                </div>

        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer ">

        <button type="submit" class="btn btn-warning ">Submit</button>
    </div>
    </form>


</div>
<!-- /.card -->
</div>
</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>