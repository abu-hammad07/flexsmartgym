<?php
session_start();
include "includes/config.php";
// logout time in user-details table
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $user_id = $_SESSION['UID'];
    // $logout_time = date('Y-m-d H:i:s');
    $sql = "UPDATE users_detail SET logout_time = NOW() WHERE users_detail_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    }
}

session_unset();
session_destroy();


header("location: login");
exit();
