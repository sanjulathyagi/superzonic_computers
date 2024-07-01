<?php
ob_start();
include_once '../init.php';
// include '../../function.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Add";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //check the method
    $message = array();  //create array variable
    if (isset($_FILES['itemImages'])) {   //check there are any uploaded images at least one 
        $itemImages = $_FILES['itemImages'];  //try to upload multiple images ,so use []
        $uploadResult = uploadFiles($itemImages);  //call to uploadFiles function
        foreach ($uploadResult as $key => $value) {  //show images
            if (@$value['upload']) {
                echo $value['file'];
                $sql = "INSERT INTO itemimages ('ItemID','ImagePath') VALUES (,'$item_id','$ImagePath')";
                $db->query($sql);   
            } else {
                foreach ($value as $result) {
                    echo $result;
                }
            }
        }
    }
}


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $item_id = dataClean($item_id);
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
        <a href="<?= SYS_URL ?>inventory/manage.php" class="btn bg-warning btn-sm mb-2"><i class="fas fa-plus-circle"></i> View
            stock</a>
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
                                    <option value="<?= $row['id']?>" <?= @$supplier_id==$row['id']? 'selected':''?>>
                                        <?= $row['SupplierName']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputPurchaseDate">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date"
                                    placeholder="Enter purchase_date" value="<?= @$purchase_date ?>">
                                <span class="text-danger"><?= @$message['purchase_date'] ?></span>
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
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="inputColour">Colour</label>
                                <input type="text" class="form-control" id="colour" name="colour"
                                    placeholder="Enter Colour">
                                <span class="text-danger"><?= @$message['colour'] ?></span>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="inputBrand ">Brand </label>
                                <select name="id" id="id" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,brand FROM brands";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['id']?>"><?= $row['brand']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
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
                                    <select name="item_id[]" id="item_id" class="form-control" required>
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

                </div>
                <button type="button" id="addBtn" class="btn btn-dark  btn-sm">Add Item</button>

                <body>
                    <h4>Upload Item Images</h4>

                    <label for="itemImages">Select Images (Max 3):</label><br>
                    <input type="file" id="itemImages1" name="itemImages[]"><br><br>
                    <input type="file" id="itemImages2" name="itemImages[]"><br><br>
                    <input type="file" id="itemImages3" name="itemImages[]"><br><br>

                    

                </body>


        </div>
        <!-- /.card-body -->

        <div class="card-footer ">
            <input type="hidden" name="UserId" value="<?= $UserId ?>">
            <button type="submit" class="btn btn-warning btn-sm ">Submit</button>
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