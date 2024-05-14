<?php
ob_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">
        <a href="add.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn ();
                $sql = "SELECT c.*, d.Name 
                FROM customers c
                INNER JOIN districts d ON d.Id = c.DistrictId";
        
               

                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Add.Line1</th>
                            <th>Add.Line2</th>
                            <th>city</th>
                            <th>TelNo</th>
                            <th>MobileNo</th>
                            <th>District</th>
                            <th>Reg.no</th>
                            <th>Actions</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['CustomerId'] ?></td>
                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['AddressLine1'] ?></td>
                            <td><?= $row['AddressLine2'] ?></td>
                            <td><?= $row['AddressLine3'] ?></td>
                            <td><?= $row['TelNo'] ?></td>
                            <td><?= $row['MobileNo'] ?></td>
                            <td><?= $row['Name'] ?></td>
                            <td><?= $row['RegNo'] ?></td>                     
                            <td>
                                <div class="dropdown no-arrow mb-1">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">


                                        <a href="<?= SYS_URL ?>customers/edit.php?customerid=<?= $row['CustomerId'] ?>"
                                            class="btn btn-warning"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-info"
                                            href="<?= SYS_URL ?>customers/delete.php?customerid=<?= $row['CustomerId'] ?>"
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

