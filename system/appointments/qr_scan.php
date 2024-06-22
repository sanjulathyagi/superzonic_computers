<?php
ob_start();
include_once '../init.php';

$link = "Appointments Management";
$breadcrumb_item = "Appointments";
$breadcrumb_item_active = "Scan QR";

        extract($_GET);
        if(!empty($appointmentid)){
         $db= dbConn ();
                $sql = "SELECT appointments.AppId,customers.FirstName,customers.LastName,customers.Email,customers.MobileNo,appointments.date,
                appointments.start_time,appointments.end_time
                FROM appointments 
                INNER JOIN customers ON appointments.customer_id = customers.CustomerId where AppId='$appointmentid'";
       
                $result=$db->query($sql);
            }
?>
<!-- link the qr scanner library -->
<script src="../../qr_scanner/instascan.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-4">
        <!-- play the camera to scan the qr code -->
        <video id="scan_job" height="200" width="285" class="border border-1 border-black"></video>
        <br>
        <button type="button" class="btn btn-dark" onclick="scanjob()">Start Scan</button>
        <button type="button" class="btn btn-warning" onclick="stopscan()">Stop Scan</button>



    </div>
    <div class="col-md-8">
        <?php
        if ($result) {
            $row = $result->fetch_assoc();
           ?>
        <table class="table table-striped text-nowrap">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>App. Date</th>
                    <th>Start_time</th>
                    <th>End_time</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $row['FirstName'] ?> <?= $row['LastName'] ?></td>
                    <td><?= $row['Email'] ?></td>
                    <td><?= $row['MobileNo'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['start_time'] ?></td>
                    <td><?= $row['end_time'] ?></td>
                </tr>
            </tbody>

        </table>
        <?php
        }
        ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    //startscan job
    function scanjob() {
        let scanner = new Instascan.Scanner({
            video: document.getElementById(
                'scan_job') //pass video tag with id(scan_job) to scanner variable,create object 'scanner'
        });
        scanner.addListener('scan', function (content) { //scan and check there is a qr pattern and get content 
            findAppointment(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) { //decide what camera should use to scan 
            if (cameras.length > 0) {
                scanner.start(cameras[0]); //0 mean first camera 
            } else {
                console.error('No cameras found.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    }

    //stop scan job
    function stopscan() {
        const video = document.querySelector('video'); //get video tags 
        const mediaStream = video.srcObject;
        const tracks = mediaStream.getTracks(); //get camera tracks
        tracks[0].stop(); //stop first camera
        tracks.forEach(track => track.stop()) //stop all cameras if exist
    }

    function findAppointment(appointmentid) { //pass scan data content ,redirect the id to same file
        window.location.href = "http://localhost/SIRMS/system/appointments/qr_scan.php?appointmentid=" + appointmentid
    }
</script>