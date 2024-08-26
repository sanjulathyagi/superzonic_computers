<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Payment Management";
$breadcrumb_item = "Invoice";
$breadcrumb_item_active = "view";
extract($_GET);

$db = dbConn();

// Fetch invoice details with items
$invoice_id = $_GET['id'];
$sql = "SELECT i.*, s.*, ii.*
        FROM invoices i 
        LEFT JOIN supplier s ON s.id = i.supplier_id
        LEFT JOIN invoice_items ii ON ii.invoice_id = i.id
        WHERE i.id = '$invoice_id'";
$result = $db->query($sql);

// Fetch all data into an array
$invoiceData = [];
while ($row = $result->fetch_assoc()) {
    $invoiceData[] = $row;
}

// Extract the first record to get general invoice information
$invoice = $invoiceData[0];

?>
<div class="row">
    <div class="col-12">
        <div class="invoice p-3 mb-3" id="contentToPrint">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h4>
                        Invoice #<?= $invoice['invoice_number'] ?>
                        <small class="float-right">Date:
                            <?= date('d/m/Y', strtotime($invoice['invoice_date'])) ?></small>
                    </h4>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <!-- From -->
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>SuperZonic Computers</strong><br>
                        NO. 50/1 <br>
                        NIDHAS MAWATHA<br>
                        KEGALLE<br>
                         +94 771153923<br>
                         superzonic@gmail.com<br>
                    </address>
                </div>
                <!-- To -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong><?= $invoice['SupplierName'] ?></strong><br>
                        <?= $invoice['Addressline1'] ?><br>
                        <?= $invoice['Addressline2'] ?><br>
                        <?= $invoice['Addressline3'] ?><br>
                        Phone: <?= $invoice['TelNo'] ?><br>
                        Email: <?= $invoice['Email'] ?>
                    </address>
                </div>
                <!-- Invoice details -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #<?= $invoice['invoice_number'] ?></b><br>
                    <b>Order ID:</b> <?= $invoice['purchase_order_id'] ?><br>

                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoiceData as $item) { ?>
                                <tr>
                                    <td><?= $item['item_name'] ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= $item['unit_price'] ?></td>
                                    <td><?= number_format($item['total_price'], 2) ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">
                        <!-- Add any notes or additional information here -->
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <!-- <tr>
                        <th style="width:50%">Total:</th>
                        <td>Rs.<?= number_format($item['$quantity * $unit_price, 2']) ?></td>
                      </tr> -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <button type="button" onclick="printContent()" class="btn btn-default"><i
                                class="fas fa-print"></i> Print</button>
                        <button type="button" class="btn btn-warning float-right"><i class="far fa-credit-card"></i>
                            Submit Job Card</button>
                        <button type="button" class="btn btn-dark float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
$content = ob_get_clean();
include '../layouts.php';
?>
    <script>
        //print content
        function printContent() {
            var content = document.getElementById("contentToPrint").innerHTML; //get page area
            var originalBody = document.body
            .innerHTML; //get the div content copy to temperaly variable called originalbody
            document.body.innerHTML = content; //actual body replaced to this content
            window.print(); //print div content
            document.body.innerHTML = originalBody;
        }
    </script>