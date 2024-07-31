<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">
    <a href="<?= SYS_URL ?>suppliers/add.php" class="btn bg-warning btn-sm mb-2"><i class="fas fa-plus-circle"></i>
            Add New Supplier</a>
        <a href="<?= SYS_URL ?>suppliers/add_report.php" class="btn bg-dark btn-sm mb-2"><i class="fas fa-th-list"></i>
            Supplier Details Report</a>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="text" class="btn-sm btn light border-dark" name="supplier_name"
                placeholder="Enter Supplier Name">
            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Supplier details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " s.RegDate BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    if(!empty($SupplierName)){
                        $where.=" s.SupplierName='$SupplierName' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT s.*
                FROM supplier s
                $where;";
    
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
                            <th>Status</th>
                            <th>Actions</th>

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
                            <td><?= ($row['Status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?></td>                    
                            <td>
                                <div class="dropdown no-arrow mb-1">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>suppliers/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>suppliers/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>

                                    </div>
                                </div>
                            </td>

                        </tr>

                        <?php
                            }
                            }?>
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

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>

