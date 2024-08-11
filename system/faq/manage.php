<?php
ob_start();
session_start();
include_once '../init.php';

$link = "FAQ Management";
$breadcrumb_item = "FAQ";
$breadcrumb_item_active = "Manage";
$alert=false;
?>

<div class="row">
    <div class="col-12">
        <a href="add.php" class="mb-2 btn btn-warning btn-sm"><i class="fas fa-plus-circle"></i>New FAQ</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">FAQ details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="float-right form-control" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $db= dbConn ();
                $sql = "SELECT *
                FROM faq
                INNER JOIN users u
                ON faq.userid=u.UserId";
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>User Id</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td ><?= $row['question'] ?></td>
                            <td><?= $row['answer'] ?></td>
                            <td><?= $row['UserName'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?></td>
                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>faq/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>faq/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['status']==1)?'selected': '' ?>>Active</option>
                                        <option value="0" <?= ($row['status']==0) ? 'selected' : '' ?>>Deactive</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                </form>
                                <?php
                                
                                
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    
                                
                                    if (!empty($id) && isset($status)) {
                                        $db =dbConn();
                                        $sql = "UPDATE faq SET status='$status' WHERE id='$id'";
                                        $result1 = $db->query($sql);
                                         if($result1){
                                            $alert=true;
                                         } else{
                                            $alert =false;
                                         }  
                                        }
                                    }
                                }
                                
                                ?>


                            </td>
                        </tr>

                        <?php
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
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-middle",
        icon: "success",
        title: "status has been updated  ",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<?php
$content= ob_get_clean();
include '../layouts.php';
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>

