<?php

//Create Database Conection-------------------
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

//End Database Conection-----------------------
//Data Clean------------------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End Data Clean



function uploadFiles($files) {   //get uploaded images
    $messages = array();
    foreach ($files['name'] as $key => $filename) {   //one by one iterate  uploaded files
        $filetmp = $files['tmp_name'][$key];
        $filesize = $files['size'][$key];
        $fileerror = $files['error'][$key];  //if result is 0 mean ,file not damaged

        $file_ext = explode('.', $filename);
        $file_ext = strtolower(end($file_ext));

        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');

        if (in_array($file_ext, $allowed_ext)) {  //check the uploaded extensions exist in array
            if ($fileerror === 0) {
                if ($filesize <= 2097152) {
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
                $messages[$key]['uploading'] = "Error occurred while uploading $filename";
            }
        } else {
            $messages[$key]['upload'] = false;
            $messages[$key]['type'] = "Invalid file type for $filename";
        }
    }
    return $messages;
}
?>


