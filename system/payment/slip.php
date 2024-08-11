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

$payment_id=1;
$sql="SELECT * FROM payments WHERE id= $payment_id";
$result = $db->query($sql);

$payment = $result->fetch_assoc();

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
$pdf->Cell(0,10,$payment['id'],0,1);

$pdf->Cell(50,10,'Date:',0,0);
$pdf->Cell(0,10,$payment['date'],0,1);

$pdf->Cell(50,10,'Customer Name:',0,0);
$pdf->Cell(0,10,$payment['customer_name'],0,1);

$pdf->Cell(50,10,'Amount:',0,0);
$pdf->Cell(0,10,'Rs.' . number_format($payment['amount'],2),0,1);

$pdf->Cell(50,10,'Payment Method:',0,0);
$pdf->Cell(0,10, $payment['payment_method'],0, 1);

$pdf->Ln(20);

$pdf->Cell(0,10,'Thank you for your Payment!',0,1,'C');

ob_end_clean();

 // Output the PDF to a file on the server
 $pdf->Output($save_path, 'F');
    
 // Optionally, you can echo a message or redirect to another page
 echo "Payment receipt saved: <a href='../../docs/payment_receipt.pdf'>Download</a>";
 ?>

