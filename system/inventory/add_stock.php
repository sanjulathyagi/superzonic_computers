<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Add";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = array();
    if (isset($_FILES['itemImages'])) {
        $itemImages = $_FILES['itemImages'];
        $uploadResult = uploadFiles($itemImages);
        foreach ($uploadResult as $key => $value) {
            if (@$value['upload']) {
                echo $value['file'];
            } else {
                foreach ($value as $result) {
                    echo $result;
                }
            }
        }
    }
}
function uploadFiles($files) {
    $messages = array();
    foreach ($files['name'] as $key => $filename) {
        $filetmp = $files['tmp_name'][$key];
        $filesize = $files['size'][$key];
        $fileerror = $files['error'][$key];

        $file_ext = explode('.', $filename);
        $file_ext = strtolower(end($file_ext));

        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');

        if (in_array($file_ext, $allowed_ext)) {
            if ($fileerror === 0) {
                if ($filesize <= 2097152) {
                    $file_name = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../uploads/' . $file_name;
                    move_uploaded_file($filetmp, $file_destination);
                    $messages[$key]['upload'] = true;
                    $messages[$key]['file'] = $file_name;
                } else {
                    $messages[$key]['upload'] = false;
                    $messages[$key]['size'] = "The file size is invalid for $filename";
                }
            } else {
                $messages[$key]['upload'] = false;
                $messages[$key]['uploading'] = "Error occurred while uploading $filename";
            }
        } else {
            $messages[$key]['upload'] = false;
            $messages[$key]['type'] = "Invalid file type for $filename";
        }
    }
    return $messages;
}

//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $item_name = dataClean($item_name);
    $colour = dataClean($colour);
    $category_name = dataClean($category_name);
    $unit_price = dataClean($unit_price);
    $item_image= dataClean($item_image);
    $brand = dataClean($brand);
    $qty = dataClean($qty);
    $purchase_date = dataClean($purchase_date);
    $Supplier_id = dataClean($Supplier_id);

    if (empty( $item_name)) {
        $message['item_name'] = "The ItemName should not be blank...!";
    }
    if (empty( $colour)) {
        $message['colour'] = "The colour should not be blank...!";
    }
    if (empty($category_name)) {
        $message['category_name'] = "The CategoryName should not be blank...!";
    } 
    if (empty($unit_price)) {
        $message['unit_price'] = "The Unit_price Date should not be blank...!";
    }
    if (empty($item_image)) {
        $message['item_image'] = "The ItemImage should not be blank...!";
    }
    if (empty($Brand)) {
        $message['brand '] = "The brand should not be blank...!";
    }
    if (empty($qty)) {
        $message['qty'] = "The qty should not be blank...!";
    }
    if (empty($purchase_date)) {
        $message['purchase_date'] = "The purchase_date should not be blank...!";
    }
    if (empty($SupplierName)) {
        $message['SupplierName'] = "The SupplierName should not be blank...!";
    }

    if (empty($message)) {

        $db = dbConn();
        foreach ($item_id as $key => $value){  //pass array values
            $q=$qty[$key];
            $price =$unit_price[$key];
            $sql = "INSERT INTO 'item_stock' ('item_id','qty','unit_price','purchase_date','supplier_id') VALUES ('$value','$q','$price','$purchase_date','$supplier_id')";
            $db->query($sql);

        }

    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/manage.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i> View
            Inventory</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New item</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputSupplierName">SupplierName</label>
                                <select name="supplier_id" id="supplier_id" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,SupplierName FROM supplier";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['id']?>"><?= $row['SupplierName']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputColour">Colour</label>
                                <input type="text" class="form-control" id="colour" name="colour"
                                    placeholder="Enter Colour" value="<?= @$colour ?>">
                                <span class="text-danger"><?= @$message['colour'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputCategory Name">Category Name</label>
                                <select name="item_category_id" id="item_category_id" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,category_name FROM item_category";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['id']?>"><?= $row['category_name']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputUnit_price">Unit Price</label>
                                <input type="text" class="form-control" id="unit_price" name="unit_price"
                                    placeholder="Enter unit price" value="<?= @$unit_price ?>">
                                <span class="text-danger"><?= @$message['unit_price'] ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputBrand ">Brand </label>
                                <input type="text" class="form-control" id="brand" name="brand "
                                    placeholder="Enter brand " value="<?= @$brand  ?>">
                                <span class="text-danger"><?= @$message['brand '] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputQty">Quantity</label>
                                <input type="number" class="form-control" id="qty" name="qty" placeholder="Enter qty"
                                    value="<?= @$qty ?>">
                                <span class="text-danger"><?= @$message['qty'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-stripped" id="items">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="items-row">
                                    <td>
                                        <select name="item_id[]" id="item_id" class="form-control"
                                            onchange="validateData(this)" required>
                                            <option value=""></option>
                                            <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,item_name FROM items";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <option value="<?= $row['id']?>"><?= $row['item_name']?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="qty" name="qty[]" required>

                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="unit_price" name="unit_price[]"
                                            required>
                                    </td>
                                    <td>
                                        <button type="button" class="removeBtn btn btn-danger"><i
                                                class="fas fa-trash-alt"></i></button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="addBtn" class="btn btn-dark  btn-sm">Add Item</button>


                        <!-- <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="itemImages">Select Images (Max 3):</label><br>
                                <input type="file" id="itemImages" name="itemImages[]"><br><br>
                                <input type="file" id="itemImages" name="itemImages[]"><br><br>
                                <input type="file" id="itemImages" name="itemImages[]"><br><br>

                                <input type="submit" value="Upload Images" name="submit">
                                <span class="text-danger"><?= @$message['item_image'] ?></span>
                            </div>
                        </div> -->
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                    <input type="hidden" name="UserId" value="<?= $UserId ?>">
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
<script>
    $(document).ready(function () {
        function addItems() {
            var tableBody = $('#items tbody'); //get table body of table 
            var newRow = tableBody.find('.items-row').first().clone(true); //get copy of row

            newRow.find('input').val(''); //blank the copy row data

            tableBody.append(newRow); //add new row copy of previous copied row without data
        }

        function removeItems(button) { //remove item row
            var row = $(button).closest('tr');
            row.remove();
        }

        function validateDate(selectElement) {
            const selectedValue = $(selectedElement).val(); //get selected value
            if (selectedItems.includes(selectedValue)) { //check select item in the array
                alert('Item already added');
                $(selectedElement).val(''); //reset the select value to empty
            } else {
                selectedItems.push(selectedValue); //add selected value to array
            }

        }

        $('#addBtn').click(addItems); //click the addBtn button ,execute the addItems function 
        $('#items').on('click', '.removeBtn',
            function () { //click the removeBtn button,execute the removeItems function
                removeItems(this);
            });
        $('#items').on('change', '.select',
            function () { //validate items
                validateData(this);
            });

    });
</script>