<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Purchase Orders";
$breadcrumb_item_active = "Success";
$alert='True';

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $purchase_order_id = $_GET['purchase_order_id'];
    $invoice_number = 'INV-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
    $invoice_date = date('Y-m-d');

    $db = dbConn();

    // Fetch purchase order details
    $sql = "SELECT po.id AS purchase_order_id, po.total_amount, s.Email, s.SupplierName, po.supplier_id
            FROM purchase_order po
            JOIN supplier s ON po.supplier_id = s.id
            WHERE po.id = '$purchase_order_id'";
    $result = $db->query($sql);
    $order = $result->fetch_assoc();

    // Insert invoice details
    $sql = "INSERT INTO invoices (purchase_order_id, invoice_number, invoice_date, total_amount, supplier_id)
            VALUES ('$purchase_order_id', '$invoice_number', '$invoice_date', '{$order['total_amount']}', '{$order['supplier_id']}')";
    $db->query($sql);
    $invoice_id = $db->insert_id;  // Get the last inserted invoice ID

    // Fetch purchase order items
    $sql = "SELECT poi.item_id, i.item_name, poi.quantity, poi.unit_price
            FROM purchase_order_items poi
            JOIN items i ON poi.item_id = i.id
            WHERE poi.purchase_order_id = '$purchase_order_id'";
    $items = $db->query($sql);

    // Insert invoice items
    while ($item = $items->fetch_assoc()) {
        $item_id = $item['item_id'];
        $item_name = $item['item_name'];
        $quantity = $item['quantity'];
        $unit_price = $item['unit_price'];
        $total_price = $quantity * $unit_price;

        $sql = "INSERT INTO invoice_items (invoice_id, item_id, item_name, quantity, unit_price, total_price)
                VALUES ('$invoice_id', '$item_id', '$item_name', '$quantity', '$unit_price', '$total_price')";
        $db->query($sql);
    }
}
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Purchase Order Created</h3>
            </div>
            <div class="card-body">
                <p>Your purchase order has been successfully created and sent to the supplier.</p>

            </div>
            
        </div>
    </div>
</div>
<?php
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-middle",
        icon: "success",
        title: "Purchase Order Created sent to the supplier",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>

