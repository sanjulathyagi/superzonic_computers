<?php

include '../config.php';
include 'header.php';
include '../function.php';


if($_SERVER['REQUEST_METHOD']=='POST') {
    $order_number =dataclean($_POST['order_number']);
    $message = array();  //create array variable

    if (isset($_FILES['payment_slip'])) {   //check there are any uploaded images at least one 
        $paymentSlip = $_FILES['payment_slip'];  //try to upload multiple images ,so use []
        $uploadResult = paymentSlipFiles($paymentSlip);  //call to uploadFiles function

        foreach ($uploadResult as $key => $value) {  //show images
            if (@$value['upload']) {
                echo $value['file'];
                $sql = "INSERT INTO payment_slips (order_number,file_path,uploaded_at) VALUES ('$order_number','$FilePath',NOW())";
                $db->query($sql);   
            } else {
                foreach ($value as $result) {
                    echo $result;
                }
            }
        }
    }
}
// pdf vaidation
function paymentSlipFiles($files) {   //get uploaded images
    $messages = array();
  
    if (!empty($message)){
        $pdf = $_FILES['paymentSlip'];
        if(!empty($pdf)) {  
    $filename = $pdf['name'];
     $filetmp = $pdf['tmp_name'];
     $filesize = $pdf['size'];
      $fileerror = $pdf['error'];  

        $file_ext = explode('.', $filename); //string convert to array
        $file_ext = strtolower(end($file_ext)); //get last element of the array

        $allowed_ext = array('pdf'); //allowed pdf

        if (in_array($file_ext, $allowed_ext)) {  //check the uploaded extensions exist in array
            if ($fileerror === 0) {
                if ($filesize <= 4097152) { 
                    $pdf = uniqid('', true) . '.' . $file_ext;  //create seperate file id
                    $file_destination = '../../uploads/payments/' . $pdf;
                    move_uploaded_file($filetmp, $file_destination);  //file pass to server location
                    
                } else {
                    $messages['paymentSlip'] = "The file size is invalid , should be less than 20MB";
                    
                }
            } else {
                $messages['paymentSlip'] = "The file has error";  //having a error in file
            }
        } else {
            $messages['paymentSlip'] = "Invalid file type";
        }
    }
}
    
}
?>

<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">

                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="row">
        <div class="col-lg-5">
            <section id="services" class="services">
                <div class="container" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="row">
                            <div class="align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                                <div class="icon-box" style="width:600;height:400 !important;">
                                    <!-- Your Order Number is <?=$_SESSION['order_number'] ?> -->
                                    <a href="<?=WEB_URL ?>track.php" class="checkout-btn bg-dark btn-sm">Track your
                                        Order</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </section>
        </div>
        <div class="col-lg-7">
            <section id="contact" class="contact">
                <div class="container" data-aos="fade-up">

                    <div class="row justify-content-center">
                        <div class="col-lg-7 border border-3  border-success" data-aos="fade-up" data-aos-delay="200">
                            <h1 class="text-center">Congratulations</h1>

                            <h3 class="text-center">Your payment has been successfully saved </b> </h1>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

</main>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your payment successfully has been placed",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
include 'footer.php';
?>