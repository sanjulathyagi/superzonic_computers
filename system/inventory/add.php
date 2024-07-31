<?php
ob_start();
session_start();

include_once '../init.php';
include_once '../../function.php';

$link = "Inventory Management";
$breadcrumb_item = "Items";
$breadcrumb_item_active = "Add";

$alert=false;

//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $item_name = dataClean($item_name);
    $colour = dataClean($colour);
    $item_category= dataclean($item_category);
    $brand_id = dataClean($brand_id);
    $model_id = dataClean($model_id);
    $item_image ='';
    
  

    $message = array();

    if (empty( $item_name)) {
        $message['item_name'] = "The ItemName should not be blank...!";
    }
    if (empty( $colour)) {
        $message['colour'] = "The colour should not be blank...!";
    }
    if (empty($brand_id)) {
        $message['brand_id'] = "The brand should not be blank...!";
    }
    if (empty($model_id)) {
        $message['model_id'] = "The model should not be blank...!";
    }
    if (empty($item_category)) {
        $message['item_category'] = "The category should not be blank...!";
    }

   
   
    if (empty($message)) {
       
        $db = dbConn(); 
        $sql = "INSERT INTO items(item_name,colour,model_id,brand_id,item_category) VALUES ('$item_name','$colour','$brand_id','$model_id','$item_category')";
        $db->query($sql);
        $itemID = $db->insert_id;
        $alert=true;
        $serial_number = $item_category. $brand_id. $model_id. date('Y').date('m').date('d').$itemID;
        $_SESSION['serial_number']=$serial_number;
        $sql = "UPDATE `items` SET `serial_number`='$serial_number' WHERE id='$itemID'";
        $db->query($sql);
        
        if(isset($_FILES['itemImages'])) {  //check any uploaded images 
            $itemImages = $_FILES['itemImages'];  //assign these images
            $uploadResult = uploadFiles($itemImages); //call to function
            foreach($uploadResult as $key => $value){
                if (@$value['upload']) {
                    $ImagePath=$value['file'];
                    echo $sql ="INSERT INTO itemImages(itemID,ImagePath) VALUES('$itemID','$ImagePath')";
                    $db->query($sql);
                } else{
                    foreach ($value as $result) {
                    //     echo $result;
                     }
                }
            }
        }
        
      

        }
    }
    


?>
<?php
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "New item  has been added<br> serial Number is <?= $_SESSION['serial_number'] ?> ",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/items.php" class="mb-2 btn bg-warning"><i class="fas fa-plus-circle"></i> View
            Items</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New Item</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputItemName">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                placeholder="Enter item_name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputColour">Colour</label>
                                <input type="text" class="form-control" id="colour" name="colour"
                                    placeholder="Enter Colour" value="<?= @$colour ?>">
                                <span class="text-danger"><?= @$message['colour'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputCategoryName">Category Name</label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,category_name FROM item_category";
                                $result = $db->query($sql);
                                ?>
                                <select name="item_category" id="item_category" class="form-control" required>
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>"
                                        <?= @$item_category== $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['category_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['item_category'] ?></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputBrand ">Brand </label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,brand FROM brands";
                                $result = $db->query($sql);
                                ?>
                                <select name="brand_id" id="brand_id" class="form-control" required>
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$brand_id== $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['brand'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['brand_id'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputModel ">Model </label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,model_name FROM models";
                                $result = $db->query($sql);
                                ?>
                                <select name="model_id" id="model_id" class="form-control" required>
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$model_id== $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['model_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['model_id'] ?></span>
                            </div>
                        </div>

                    </div>
                </div>

        </div>
        <label for="itemImages">Select Images(Max 3)</label><br>
        <input type="file" id="itemImages1" name="itemImages[]"><br><br>
        <input type="file" id="itemImages2" name="itemImages[]"><br><br>
        <input type="file" id="itemImages3" name="itemImages[]"><br><br>



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