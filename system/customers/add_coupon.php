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
    $discount_criteria_id = dataClean($discount_criteria_id);
    $start_date= dataclean($start_date);
    $valid_period = dataClean($valid_period);
    $used_count = dataClean($used_count);

  

    $message = array();

    if (empty( $discount_criteria_id)) {
        $message['discount_criteria_id'] = "The discount should not be blank...!";
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
        $sql = "INSERT INTO coupons(customer_id,discount_criteria_id,start_date,valid_period,used_count) VALUES ('$customer_id','$discount_criteria_id','$start_date','$valid_period','$used_count')";
        $db->query($sql);
        $coupon_id = $db->insert_id;
        $alert=true;
        $coupon_code = date('Ymd').$coupon_id;
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
    <div class="col-7">
        <a href="<?= SYS_URL ?>customers/coupon.php" class="mb-2 btn bg-warning btn-sm"><i
                class="fas fa-plus-circle"></i> View
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
                                <label for="inputcustomer">Customer</label>
                                <input type="text" class="form-control" id="customer_id" name="customer_id"
                                    placeholder="Enter customer" value="<?= @$customer_id ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                        <div class="form-group">
                                <label for="DesignationId">Discount(%)</label>
                                <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM discount_criteria";
                        $result = $db->query($sql);
                        ?>
                                <select class="form-control" id="discount_criteria_id" name="discount_criteria_id">
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$discount_criteria_id==$row['id']?'selected':'' ?>>
                                        <?= $row['discount_percentage'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['discount_criteria_id'] ?></span>
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
        <div class="card-footer ">

            <button type="submit" class="btn btn-warning btn-sm">Submit</button>
        </div>
        </form>
    </div>
    <?php
    //check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $amount = dataClean($amount);
    $discount = dataClean($discount);

    
    $message = array();
    if (empty($amount)) {
        $message['amount'] = "The amount should not be blank...!";
    }
    if (empty($discount)) {
        $message['discount'] = "The discount should not be blank...!";
    }
    
    //check username exist
    if (!empty($amount)) {
        $db = dbConn();
        $sql = "SELECT * FROM discount_criteria WHERE min_amount='$amount'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['amount'] = "This amount already exist...!";
        }
    }

  
    if (empty($message)) {
       
        $db = dbConn();
        $sql = "INSERT INTO discount_criteria (min_amount,discount_percentage) VALUES ('$amount','$discount')";
        $db->query($sql);
        

       
    }
 
}
    ?>
    <div class="col-5">
        <a href="<?= SYS_URL ?>customers/coupon.php" class="mb-2 btn  btn-sm">
        </a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add Discount Criteria</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputDesignation">Min Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount"
                                    placeholder="Enter amount" value="<?= @$amount ?>">
                                <span class="text-danger"><?= @$message['amount'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputdiscount">Discount(%)</label>
                                <input type="text" class="form-control" id="discount" name="discount"
                                    placeholder="Enter discount" value="<?= @$discount ?>">
                                <span class="text-danger"><?= @$message['discount'] ?></span>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Submit </button>
                </div>
            </form>

            <div class="card-body table-responsive p-0">
                <?php
                
                    $db = dbConn();
                    $sql = "SELECT * 
                    FROM discount_criteria";

                    $result = $db->query($sql);
                    ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Min Amount(Rs.)</th>
                            <th>Discount Percentage(%)</th>

                    </thead>
                    <tbody>

                        <?php
                      
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['min_amount'] ?></td>
                            <td><?= $row['discount_percentage'] ?></td>
                            </td>



                        </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>



        </div>

    </div>


</div>





<?php
$content = ob_get_clean();
include '../layouts.php';
?>