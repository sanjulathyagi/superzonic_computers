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
    $currentPassword = $db->real_escape_string($_POST['currentPassword']);
    $newPassword = $db->real_escape_string($_POST['newPassword']);
    $confirmPassword = $db->real_escape_string($_POST['confirmPassword']);

    // Fetch the current password from the database
    $sql = "SELECT Password FROM users WHERE UserId = '$user_id'";
    $result = $db->query($sql);
    $user = $result->fetch_assoc();

    // Verify current password
    if (password_verify($currentPassword, $user['Password'])) {
        if ($newPassword === $confirmPassword) {
            // Update the password
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET Password = '$hashedPassword' WHERE UserId = '$user_id'";

            if ($db->query($sql)) {
                $_SESSION['success'] = "Password changed successfully.";
            } else {
                $_SESSION['error'] = "Failed to change password.";
            }
        } else {
            $_SESSION['error'] = "New passwords do not match.";
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
    }

    header("Location: account.php");
    exit();
}
?>
<?php include 'footer.php';
ob_end_flush();
?>