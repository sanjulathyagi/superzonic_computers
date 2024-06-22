<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  //check the method
    $message = array();  //create array variable
    if (isset($_FILES['itemImages'])) {   //check there are any uploaded images at least one 
        $itemImages = $_FILES['itemImages'];  //try to upload multiple images ,so use []
        $uploadResult = uploadFiles($itemImages);  //call to uploadFiles function
        foreach ($uploadResult as $key => $value) {  //show images
            if (@$value['upload']) {
                echo $value['file'];
            } else {
                foreach ($value as $result) {
                    echo $result;
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload Item Images</title>
    </head>
    <body>
        <h2>Upload Item Images</h2>
        <form action="add.php" method="post" enctype="multipart/form-data" novalidate>
            <label for="itemName">Item Name:</label><br>
            <input type="text" id="itemName" name="itemName" required><br><br>

            <label for="itemDescription">Item Description:</label><br>
            <textarea id="itemDescription" name="itemDescription"></textarea><br><br>

            <label for="itemPrice">Item Price:</label><br>
            <input type="text" id="itemPrice" name="itemPrice" required><br><br>

            <label for="itemImages">Select Images (Max 3):</label><br>
            <input type="file" id="itemImages1" name="itemImages[]" ><br><br>
            <input type="file" id="itemImages2" name="itemImages[]" ><br><br>
            <input type="file" id="itemImages3" name="itemImages[]" ><br><br>

            <input type="submit" value="Upload Images" name="submit">
        </form>
    </body>
</html>