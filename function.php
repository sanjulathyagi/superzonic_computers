<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//create Database Connection------------
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "superzonic";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}

//end database connection-----------
//data clean---------------

function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//end data clean

function uploadFiles($files) {   //get uploaded images
    $messages = array();
  
    if (!empty($files['name'])){
    foreach ($files['name'] as $key => $filename) {   //one by one iterate  uploaded files
    $filetmp = $files['tmp_name'][$key];
     $filesize = $files['size'][$key];
      $fileerror = $files['error'][$key];  //if result is 0 mean ,file not damaged

        $file_ext = explode('.', $filename);
        $file_ext = strtolower(end($file_ext)); //get last element of the array

        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');

        if (in_array($file_ext, $allowed_ext)) {  //check the uploaded extensions exist in array
            if ($fileerror === 0) {
                if ($filesize <= 4097152) {
                    $file_name = uniqid('', true) . '.' . $file_ext;  //create seperate file id
                    $file_destination = '../../uploads/' . $file_name;
                    move_uploaded_file($filetmp, $file_destination);  //file pass to server location
                    $messages[$key]['upload'] = true;
                    $messages[$key]['file'] = $file_name;  //insert to database
                } else {
                    $messages[$key]['upload'] = false;
                    $messages[$key]['size'] = "The file size is invalid for $filename";
                }
            } else {
                $messages[$key]['upload'] = false;
                $messages[$key]['uploading'] = "Error occurred while uploading $filename";  //having a error in file
            }
        } else {
            $messages[$key]['upload'] = false;
            $messages[$key]['type'] = "Invalid file type for $filename";
        }
    }
}
    return $messages;
}

//user privilege manage
function checkRole($role=null){
    
    $user_id=$_SESSION['USERID'];  //login user id
    $db = dbConn();
    $sql ="SELECT * FROM users u WHERE u.UserId= '$user_id' AND u.user_role='$role' ";
    $result = $db->query($sql);

    if($result->num_rows <=0) {
        header("Location:../unauthorized.php");
        return false;
    } else {
        return true;
    }

}

function checkprivilege($module_id=null) {
    $user_id = $_SESSION['USERID'];  //login user id
    $db = dbConn();
    $sql = "SELECT * FROM user_modules um WHERE um.UserId='$user_id' AND um.ModuleId='$module_id' ";
    $result = $db->query($sql);
    $row=$result->fetch_assoc();
    if ($result->num_rows <= 0) {
        return false;
    } else {
        return $row;
    }
}

function validateMobileNumber($mobile_no) {
    // Remove leading and trailing whitespace
    $mobile_no = trim($mobile_no);

    // Check if the number starts with +947 followed by 9 digits
    if (substr($mobile_no, 0, 3) !== '+94' && strlen($mobile_no) !== 12 && ctype_digit(substr($mobile_no, 3))) {
        return "Invalid mobile number";
    }else{
        return true;
    }
}

function validateTelePhoneNumber($telno) {
    // Remove leading and trailing whitespace
    $telno = trim($telno);

    
    if (strlen($telno) !== 10) {
        return "Invalid telno number.";
    } 
}
?>


