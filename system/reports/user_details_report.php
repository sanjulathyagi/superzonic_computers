<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "REPORT";
$alert=false;

                                



?>

<div class="row">
    <div class="col-12">
 
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User details</h3>

              
                
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $db= dbConn ();
                $sql= "SELECT * 
                FROM users u 
                 INNER JOIN employee e 
                    ON e.UserId=u.UserId 
                 LEFT JOIN designations p 
                    ON p.ID=e.DesignationId";

                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                          
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>App. Date</th>
                            <th>Designation</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $status = 1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['AppDate'] ?></td>
                            <td><?= $row['Designation'] ?></td>
                            
                            </td>
                          
                           
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

