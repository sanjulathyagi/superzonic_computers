<?php
ob_start();
session_start();
include_once '../init.php';
// include '../../function.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory";
$breadcrumb_item_active = "Add";



//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $category_id = dataClean($category_id);
    $brand_id = dataClean($brand_id);
    $purchase_date = dataClean($purchase_date);
    $supplier_id = dataClean($supplier_id);

   
    if (empty($category_id)) {
        $message['category_id'] = "The CategoryName should not be blank...!";
    } 
   
    if (empty($brand_id)) {
        $message['brand_id '] = "The brand should not be blank...!";
    }
  
    if (empty($purchase_date)) {
        $message['purchase_date'] = "The purchase_date should not be blank...!";
    }
    if (empty($supplier_id)) {
        $message['supplier_id'] = "The SupplierName should not be blank...!";
    }

    if (empty($message)) {

        $db = dbConn();
        foreach ($item_id as $key => $value){  //pass array values
            $q=$qty[$key];
            $price =$unit_price[$key];
            $buying_price =$buying_price[$key];
            $sql = "INSERT INTO item_stock (item_id,qty,buying_price,unit_price,category_id,brand_id,purchase_date,supplier_id) VALUES ('$value','$q','$buying_price','$price','$category_id','$brand_id','$purchase_date','$supplier_id')";
            $db->query($sql);

        }

    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/stock_receive.php" class="btn bg-warning btn-sm mb-2"><i class="fas fa-plus-circle"></i> View
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
                                    placeholder="Enter purchase_date"max="<?=date('Y-m-d') ?>" value="<?= @$purchase_date ?>">
                                <span class="text-danger"><?= @$message['purchase_date'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputCategory Name">Category Name</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,category_name FROM item_category";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['id']?>"<?= @$category_id==$row['id']? 'selected':''?>
                                        ><?= $row['category_name']?></option>
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
                                <label for="inputBrand ">Brand </label>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT id,brand FROM brands";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['id']?>"<?= @$brand_id==$row['id']? 'selected':''?>
                                        ><?= $row['brand']?></option>
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
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                             
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
                                    <input type="number" class="form-control" id="qty" name="qty[]" min="1" required>

                                </td>
                                <td>
                                    <input type="text" class="form-control" id="buying_price" name="buying_price[]"
                                        required>
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
            newRow.find('.select2-container').remove();
            newRow.find('select').removeClass('select2-hidden-accessible').removeAttr('data-select2-id tabindex aria-hidden');
            newRow.find('select').select2();

            tableBody.append(newRow); //add new row copy of previous copied row without data
        }

        function removeItems(button) { //remove item row
            var row = $(button).closest('tr');
            row.remove();
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
$('.select2').select2();
    });
</script>