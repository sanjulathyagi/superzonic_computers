<?php
ob_start();
session_start();
require_once('../../TCPDF/tcpdf.php');

class MYPDF extends TCPDF {

    public function Header(){
        $image_file = 'logo design.jpeg';
        $this->Image($image_file, 10, 10, 30, '', 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('helvetica','B',20);
        $this->Cell(0,15, 'Payment Receipt', 0, false, 'c', 0, '', 0, false, 'M', 'M');
        

    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica','I',8);
        $this->cell(0,10,'Page'. $this->getAliasNumPage() . '/' . $this->getAliasNbPages(),0, false, 'C',0,'',0,false,'T','M',);

    }
}

include_once '../init.php';
$db= dbConn();
if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];

$sql="SELECT 
            o.order_number,
            c.FirstName AS customer_name,
            o.order_date,
            oi.qty,
            oi.unit_price,
            SUM(oi.qty * oi.unit_price) AS total_amount
        FROM 
            orders o
        JOIN 
            order_items oi ON o.id = oi.order_id
         JOIN 
            payments p ON p.order_number = o.order_number    
        JOIN 
            customers c ON o.customer_id = c.CustomerId
        WHERE p.id= '$payment_id'
        GROUP BY 
            o.order_number, c.FirstName, o.order_date
        ORDER BY 
            o.order_date DESC";
            
$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Order Number</th>
                <th>Customer Name</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>";

    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['order_number']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['order_date']}</td>
                <td>{$row['total_amount']}</td>
                <td><a href='order_details.php?order_number={$row['order_number']}'>View Details</a></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No orders found.";
}
}


// Set absolute path to save the PDF file
$save_path = __DIR__ . '/../../docs/payment_receipt.pdf'; // Replace with your desired absolute server path

$custom_layout = array(170, 150);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION,  PDF_UNIT, $custom_layout, true, 'UTF-8',false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Company Name');
$pdf->SetTitle('Payment Receipt');
$pdf->SetSubject('Receipt');

$pdf->SetHeaderFont(Array(PDF_FONT_NAME_MAIN,'',PDF_FONT_SIZE_MAIN));
$pdf->SetFooterFont(Array(PDF_FONT_NAME_DATA,'',PDF_FONT_SIZE_DATA));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT,PDF_MARGIN_TOP,PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setAutoPageBreak(True,PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->AddPage();

$pdf->SetFont('helvetica','',12);

$pdf->Cell(0,20,'Payment Receipt',0,1 ,'C');
$pdf->Ln(10);

$pdf->Cell(50,10,'Receipt No:',0,0);
$pdf->Cell(0,10,$row['id'],0,1);

$pdf->Cell(50,10,'customer_name:',0,0);
$pdf->Cell(0,10,$row['customer_name'],0,1);

$pdf->Cell(50,10,'order_date:',0,0);
$pdf->Cell(0,10,$row['order_date'],0,1);

$pdf->Cell(50,10,'order_number:',0,0);
$pdf->Cell(0,10,$row['order_number'],0,1);


$pdf->Cell(50,10,'total_amount:',0,0);
$pdf->Cell(0,10,'Rs.' . number_format($row['total_amount'],2),0,1);

$pdf->Ln(20);

$pdf->Cell(0,10,'Thank you for your Payment!',0,1,'C');

ob_end_clean();

 // Output the PDF to a file on the server
 $pdf->Output($save_path, 'D');
    
 // Optionally, you can echo a message or redirect to another page
 echo "Payment receipt saved: <a href='../../docs/payment_receipt.pdf'>Download</a>";
 ?>

