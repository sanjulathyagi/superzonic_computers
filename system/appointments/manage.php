<?php
ob_start();
include_once '../init.php';

$link = "Appointment Management";
$breadcrumb_item = "Appointment";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">
        <a href="add.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointment details</h3>

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
                $sql = "SELECT *
                FROM appointments ";
       
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>App ID</th>
                            <th>Customer Id</th>
                            <th>Service Type</th>
                            <th>Item Brand</th>
                            <th>Item</th>
                            <th>Repair Note</th>
                            <th>Date</th>
                            <th>Start_time</th>
                            <th>End_time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['AppId'] ?></td>
                            <td><?= $row['customer_id'] ?></td>
                            <td><?= $row['service_type'] ?></td>
                            <td><?= $row['item_brand'] ?></td>
                            <td><?= $row['item_name'] ?></td>
                            <td><?= $row['repair_note'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['start_time'] ?></td>
                            <td><?= $row['end_time'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?></td>
                                             
                            <td>
                                <div class="dropdown no-arrow mb-1">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-left shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">


                                        <a href="<?= SYS_URL ?>appointments/edit.php?appid=<?= $row['AppId'] ?>"
                                            class="btn btn-warning"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-info"
                                            href="<?= SYS_URL ?>appointments/delete.php?appid=<?= $row['AppId'] ?>"
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

