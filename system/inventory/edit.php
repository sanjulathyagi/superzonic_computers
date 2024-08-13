<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Items";
$breadcrumb_item_active = "Update";


if ($_SERVER['REQUEST_METHOD'] == 'GET') { //to get previous data from item file
    extract($_GET);
     $db =dbConn();
     $sql = "SELECT i.*
            FROM items i
            WHERE i.id = $id";
     $result = $db->query($sql);
     $row = $result->fetch_assoc();

    
    $item_name = $row['item_name'];
    $item_category =$row['item_category'];
    $brand_id = $row['brand_id'];
    $model_id = $row['model_id'];

    $sql ="SELECT * FROM itemImages WHERE itemID ='$id'";
    $result = $db->query($sql);
    $existingimages =[];
    while($row = $result->fetch_assoc()){
        $existingimages[] = $row['ImagePath'];
    }
}



    
if(isset($_FILES['itemImages'])) {  //check any uploaded images 
    $itemImages = $_FILES['itemImages'];  //assign these images
    $uploadResult = uploadFiles($itemImages); //call to function
    foreach($uploadResult as $key => $value){
        if (@$value['upload']) {
            $ImagePath=$value['file'];
            $sql ="INSERT INTO itemImages(itemID,ImagePath) VALUES('$itemID','$ImagePath')";
            $db->query($sql);
        } else{
            foreach ($value as $result) {
            //     echo $result;
             }
        }
    }
}

//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $id= dataclean($id);
    $item_category= dataclean($item_category);
    $brand_id = dataClean($brand_id);
    $model_id = dataClean($model_id);
   
  

    $message = array();

    if (empty( $item_id)) {
        $message['item_id'] = "The ItemName should not be blank...!";
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
        $sql = "UPDATE  items i SET item_name='$item_name',brand_id='$brand_id',model_id='$model_id',item_category='$item_category'
        where i.id =$id";
        $db->query($sql);
        

        header("Location:items.php");
    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>inventory/items.php" class="mb-2 btn bg-warning"><i class="fas fa-plus-circle"></i> View
            Items</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Update Item</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="item_name">Item Name</label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,item_name FROM items";
                                $result = $db->query($sql);
                                ?>
                                <select class="form-control" id="id" name="id">
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$id == $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['item_name'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['id'] ?></span>
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


        <div>
            <h4>Upload Item Images</h4>
            <label for="itemImages">Select Images (Max 3):</label><br>
            <input type="file" id="itemImages1" name="itemImages[]" class="btn btn-light btn-sm "><br><br>
            <input type="file" id="itemImages2" name="itemImages[]" class="btn btn-light btn-sm"><br><br>
            <input type="file" id="itemImages3" name="itemImages[]" class="btn btn-light btn-sm"><br><br>
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer ">
        <input type="hidden" name="" value="<?=$ImagePath?>">
         <input type="hidden" name="id" value="<?= $id?>">
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