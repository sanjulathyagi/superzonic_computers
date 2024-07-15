<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Items";
$breadcrumb_item_active = "View Items";

extract($_GET); 


$db = dbConn();
$sql = "SELECT i.*,s.*,ic.*,b.* ,it.*,m.*
    FROM items i
    INNER JOIN item_stock it
        ON (i.id = it.item_id)
    INNER JOIN item_category ic
        ON (ic.id = i.item_category)
    INNER JOIN brands b
        ON (b.id = i.brand_id)
    INNER JOIN models m
        ON (m.id = i.model_id)
    INNER JOIN supplier s
        ON (s.id= it.supplier_id) WHERE i.id='$id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><b>Item Details</b></h3>


            </div> <br>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <div class="row">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h3>Item Details</h3>
                                <div class="row">
                                    <div class="col-md-9">
                                        <h6><b>Serail Number :</b></h6>
                                        <?= $row['serial_number'] ?><br><br>
                                        <h6><b>Item Name:</b></h6>
                                        <?= $row['item_name'] ?><br><br>
                                        <h6><b>Brand:</b></h6>
                                        <?= $row['brand'] ?><br><br>
                                        <h6><b>Model:</b></h6>
                                        <?= $row['model_name'] ?><br><br>
                                        <h6><b>Qty:</b></h6>
                                        <?= $row['qty'] ?><br><br>

                                    </div>

                                    <div class="col-md-3">
                                        <h6><b>Colour:</b></h6>
                                        <?= $row['colour'] ?><br><br>
                                        <h6><b>Category:</b></h6>
                                        <?= $row['category_name'] ?><br><br>
                                        <h6><b>Purchase Date:</b></h6>
                                        <?= $row['purchase_date'] ?><br><br>
                                        <h6><b>Unit_price:</b></h6>
                                        <?= $row['unit_price'] ?><br><br>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Supplier Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6><b>Supplier Name:</b></h6>
                                        <?= $row['SupplierName'] ?><br><br>
                                        <h6><b>Email:</b></h6>
                                        <?= $row['Email'] ?><br><br>
                                    </div>

                                    <div class="col-md-6">
                                        <h6><b>Tel No:</b></h6>
                                        <?= $row['TelNo'] ?><br><br>
                                        <h6><b>Address:</b></h6>
                                        <?= $row['Addressline1'] ?>,<br><?= $row['Addressline2'] ?>,<br><?= $row['Addressline3'] ?><br><br>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>