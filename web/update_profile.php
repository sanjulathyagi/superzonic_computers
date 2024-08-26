<?php 
ob_start();
include '../config.php';
include 'header.php';
include '../function.php';


if (!isset($_SESSION['USERID'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['USERID'];
$db = dbConn();

// Fetch the customer ID
$sql = "SELECT CustomerId FROM customers WHERE UserId = '$user_id'";
$result = $db->query($sql);
$customer = $result->fetch_assoc();
$CustomerId = $customer['CustomerId'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $FirstName = $db->real_escape_string($_POST['first_name']);
    $LastName = $db->real_escape_string($_POST['last_name']);
    $Email = $db->real_escape_string($_POST['email']);
    $MobileNo = $db->real_escape_string($_POST['mobile_no']);
    // Add more fields as needed

    $sql = "UPDATE customers SET 
                FirstName = '$FirstName', 
                LastName = '$LastName', 
                Email = '$Email', 
                MobileNo = '$MobileNo'
            WHERE CustomerId = '$CustomerId'";

    if ($db->query($sql)) {
        $_SESSION['success'] = "Profile updated successfully.";
    } else {
        $_SESSION['error'] = "Failed to update profile.";
    }

    header("Location: account.php");
    exit();
}
?>
<?php include 'footer.php'; 
ob_end_flush();
?>