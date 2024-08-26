<?php
ob_start();
session_start();

include_once '../init.php';
include_once '../../function.php';

$link = "Supplier Management";
$breadcrumb_item = "supplier";
$breadcrumb_item_active = "Price Request";

$alert=false;


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    extract($_GET);
    $db = dbConn();
    $sql = "SELECT s.*
            FROM supplier s
            WHERE s.id = '$id' ";
            

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $id = $row['id'];
    
}
//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $id=dataclean($id);
    $date = dataClean($date);
    $delivery_date = dataClean($delivery_date);

    $message = array();
    if (empty($id)) {
        $message['id'] = "The supplier_id should not be blank...!";
    }
    if (empty($date)) {
        $message['date'] = "The date should not be blank...!";
    }
    if (empty($delivery_date)) {
        $message['delivery_date'] = "The delivery_date should not be blank...!";
    }

    if (empty($message)) {
       
        $db = dbConn(); 
     $sql = "INSERT INTO price_request(supplier_id,request_date,delivery_date) VALUES ('$id','$date','$delivery_date')";
        $db->query($sql);
        $price_request_id = $db->insert_id;

        foreach ($item_id as $key => $value){  //pass array values
        $item_quantity=$quantity[$key];
     $sql = "INSERT INTO price_request_items(price_request_id,item_id,quantity) VALUES ('$price_request_id','$value','$item_quantity')";
        $db->query($sql);
       
      
        }
    }
    header("Location:manage.php");
    }
    
?>
<div class="row">
    <div class="col-12">
        <!-- <a href="<?= SYS_URL ?>inventory/purchase_order.php" class="mb-2 btn bg-warning"><i class="fas fa-arrow-alt-circle-left"></i> View
            </a> -->
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New price Request</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="supplier">Supplier Name</label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,SupplierName FROM supplier";
                                $result = $db->query($sql);
                                ?>
                                <select class="form-control" id="id" name="id">
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$id == $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['SupplierName'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['id'] ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputDate"> Request Date</label>
                                <input type="date" class="form-control" id="date" name="date" placeholder="Enter date"
                                    value="<?= @$date ?>">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputdelivery_date"> Expected Deliver Date</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date"
                                    placeholder="Enter delivery_date" value="<?= @$delivery_date ?>">
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
                                    <input type="number" class="form-control" id="quanity" name="quantity[]" required>

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