<?php
ob_start();
session_start();

include_once '../init.php';
include_once '../../function.php';

$link = "Inventory Management";
$breadcrumb_item = "Items";
$breadcrumb_item_active = "Add purchase order";

$alert=false;

//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $supplier = dataClean($supplier);
    $item_id= dataclean($item_id);
    $unit_price = dataClean($unit_price);
    $quantity = dataClean($quantity);
    $date = dataClean($date);
    
  

    $message = array();

    if (empty( $supplier)) {
        $message['supplier'] = "The supplier should not be blank...!";
    }
    if (empty($item_id)) {
        $message['item_id'] = "The item_name should not be blank...!";
    }
    if (empty($unit_price)) {
        $message['unit_price'] = "The unit_price should not be blank...!";
    }
    if (empty($quantity)) {
        $message['quantity'] = "The quantity should not be blank...!";
    }
    if (empty($date)) {
        $message['date'] = "The date should not be blank...!";
    }


   
   
    if (empty($message)) {
       
        $db = dbConn(); 
        $sql = "INSERT INTO purchase_order(supplier,item_name,unit_price,quantity,date) VALUES ('$supplier_id','$item_name','$unit_price','$qty','$date')";
        $db->query($sql);
       
        
        header("Location:purchase_order.php");

        }
    }
    

?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/purchase_order.php" class="mb-2 btn bg-warning"><i
                class="fas fa-plus-circle"></i> View
            Items</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New purchase order</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="SupplierName">Supplier Name</label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,SupplierName FROM supplier";
                                $result = $db->query($sql);
                                ?>
                                <select class="form-control" id="supplier" name="supplier">
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$supplier == $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['SupplierName'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['supplier'] ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputDate">Date</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="Enter date"
                                    value="<?= @$date ?>">
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
<script>
    $(document).ready(function () {
        function addItems() {
            var tableBody = $('#items tbody'); //get table body of table 
            var newRow = tableBody.find('.items-row').first().clone(true); //get copy of row

            newRow.find('input').val(''); //blank the copy row data
            newRow.find('.select2-container').remove();
            newRow.find('select').removeClass('select2-hidden-accessible').removeAttr(
                'data-select2-id tabindex aria-hidden');
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