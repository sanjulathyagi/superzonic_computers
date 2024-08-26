<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "Report";
$limit=10;

?>

<div class="row">
    <div class="col-12">
      
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <!-- select top items -->
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
            
            <input type="text" class="btn-sm btn light border-dark" name="FirstName"  placeholder="Enter Customer Name" name="Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer details</h3>


            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">

                <?php
                
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if(!empty($FirstName)){
                        $where.=" FirstName='$FirstName' AND";
                    }
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }
                $db= dbConn ();
                $sql = "SELECT c.*, d.Name 
                FROM customers c
                INNER JOIN districts d ON d.Id = c.DistrictId $where ORDER BY Email ASC LIMIT $limit";
        

                $result=$db->query($sql);

                ?>


                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>TelNo</th>
                            <th>MobileNo</th>
                            <th>District</th>
                            <th>Reg.no</th>
                        

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

                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['AddressLine1'] ?>,<?= $row['AddressLine2'] ?>,<?= $row['AddressLine3'] ?></td>
                            <td><?= $row['TelNo'] ?></td>
                            <td><?= $row['MobileNo'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['RegNo'] ?></td>
                           
                           
                           
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
$content= ob_get_clean();
include '../layouts.php';
?>

