<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Items ";
$breadcrumb_item_active = "Manage";
$alert=false;
$limit=10;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    

    if (!empty($id) && isset($status)) {
        $db =dbConn();
        $sql = "UPDATE items SET status='$status' WHERE id='$id'";
        $result1 = $db->query($sql);
         if($result1){
            $alert=true;
         } else{
            $alert =false;
         }  
        }
    }

?>

<div class="row">
    <div class="col-12">
       
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
        <label for="">&nbsp;&nbsp; Select Top</label>
            <select name="limit" id="limit" style="width:50px !important;">
                <option value="">--</option>
                <?php
                        for ($i=1; $i<=20; $i++){
                        ?>
                <option value="<?= $i ?>" <?=$limit==$i?'selected':'' ?>><?= $i ?></option>
                <?php
                        }
                        ?>
            </select>
        <input type="text" class="btn-sm btn light border-dark" name="item_name" placeholder="Enter Item Name" name="Name" placeholder="Enter District Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Item Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if(!empty($item_name)){
                        $where.=" item_name='$item_name' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath 
                FROM items i 
                LEFT  JOIN item_category ic ON ic.id = i.item_category 
                LEFT  JOIN brands b ON b.id = i.brand_id 
                LEFT JOIN models m ON m.id = i.model_id 
                INNER JOIN itemimages im ON im.ItemID = i.id $where GROUP BY i.id  ORDER BY item_name ASC LIMIT $limit ";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Serial Number</th>
                            <th>Item </th>
                        
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['serial_number'] ?></td>
                            <td width="50"><?= $row['item_name'] ?></td>
                            
                            <td><?= $row['category_name'] ?></td>
                            <td><?= $row['brand']?></td>
                            <td><?= $row['model_name']?></td>
                           
                           
                           
                        </tr>

                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

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

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>