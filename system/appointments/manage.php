<?php
ob_start();
include_once '../init.php';

$link = "Appointment Management";
$breadcrumb_item = "Appointment";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">
    <a href="<?= SYS_URL ?>appointments/qr_scan.php" class="btn bg-dark"><i class="fas fa-qrcode"></i>&nbsp; QR Scan</a><br><br>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointments Details</h3>

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
                $sql = "SELECT appointments.AppId,customers.FirstName,customers.LastName,customers.Email,customers.MobileNo,appointments.date,
                appointments.start_time,appointments.end_time
                FROM appointments 
                INNER JOIN customers ON appointments.customer_id = customers.CustomerId";
       
                $result=$db->query($sql);

                ?>
                <table  id="appointments" class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>App ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>App. Date</th>
                            <th>Start_time</th>
                            <th>End_time</th>
                            <th>Actions</th>
                            <th></th>
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
                            <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['MobileNo'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['start_time'] ?></td>
                            <td><?= $row['end_time'] ?></td>
                            <td><a href="<?= SYS_URL ?>appointments/issue_jobcard.php?appointment_id=<?= $row['AppId'] ?>" class="btn btn-warning"><i class="fas fa-calendar"></i> Issue Job Card</a></td>

                                             
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

<script>
  $(function () {
    // $("#appointments").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#appointments_wrapper .col-md-6:eq(0)');
    $('#appointments').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
