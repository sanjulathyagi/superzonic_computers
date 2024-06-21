</head>
<body>
    <h1>Barcode Display</h1>
    <div>
        <?php
        // Require the Composer autoloader
        require '../../barcode/autoload.php';

        // Import the BarcodeGeneratorPNG class
        use Picqer\Barcode\BarcodeGeneratorPNG;

        // Instantiate the BarcodeGeneratorPNG class
        $generator = new BarcodeGeneratorPNG();

        // Set the barcode text
        $barcodeText = 123;  //should be number format

        // Generate the barcode image
        //$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_CODE_128);
	//$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_CODE_39);
	$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_EAN_13);  //barcode generate types
	//$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_UPC_A);
	//$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_UPC_E);
	//$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_MSI);
	//$barcodeImage = $generator->getBarcode($barcodeText, $generator::TYPE_CODABAR);
	
        // Output the image
        echo '<img width="200" height="100" src="data:image/png;base64,' . base64_encode($barcodeImage) . '" alt="Barcode">';
        ?>
    </div>
    <div>
        <p>Barcode Text: <?php echo $barcodeText; ?></p>
    </div>
</body>