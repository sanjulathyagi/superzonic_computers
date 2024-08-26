<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Manage";
$alert=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    

    if (!empty($id) && isset($Status)) {
        $db =dbConn();
        $sql = "UPDATE supplier SET Status='$Status' WHERE id='$id'";
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
            <input type="date" class="btn-sm btn bg-secondary" name="from_date">
            <input type="date" class="btn-sm btn bg-secondary" name="to_date">
            <input type="text" class="btn-sm btn light border-dark" name="SupplierName"
                placeholder="Enter Supplier Name">
            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Supplier details</h3>


            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= "RegisterDate BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    if(!empty($SupplierName)){
                        $where.="SupplierName='$SupplierName' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT s.*
                FROM supplier s
                $where";
    
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier Name</th>
                            <th>Email</th>
                            <th>Add.Line1</th>
                            <th>Add.Line2</th>
                            <th>city</th>
                            <th>TelNo</th>
                            <th>Register Date</th>


                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['SupplierName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Addressline1'] ?></td>
                            <td><?= $row['Addressline2'] ?></td>
                            <td><?= $row['Addressline3'] ?></td>
                            <td><?= $row['TelNo'] ?></td>
                            <td><?= $row['RegisterDate'] ?></td>
                            
                            </td>
                           
                           
                           
                        </tr>

                        <?php
                              }  }
                        
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
$content= ob_get_clean();
include '../layouts.php';
?>
