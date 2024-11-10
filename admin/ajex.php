<?php
include "../includes/config.php";
session_start();

// Initialize variables
$incomeData = '';
$attendenceData = '';
$salaryData = '';



if (isset($_POST['type'])) {
    if ($_POST['type'] == "income_name_Data") {
        $sql = "SELECT users.user_id, users.username FROM users 
        LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
        LEFT JOIN role ON role.role_id = users.role_id
        WHERE role.name = 'Member'";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $incomeData = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $incomeData .= "<option value='{$row['user_id']}'>{$row['username']}</option>";
        }
    } elseif ($_POST['type'] == "income_phone_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT users_detail.Phone FROM users
            LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
            WHERE users.user_id = '$batchId'");
            $incomeData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $incomeData .= "<option value='{$row['Phone']}'>{$row['Phone']}</option>";
            }
        } else {
            $incomeData = 'ID not provided for batch Data';
        }
    } 
    // elseif ($_POST['type'] == "subscription_Data") {
    //     if (isset($_POST['id'])) {
    //         $batchId = $_POST['id'];
    //         $query = mysqli_query($conn, "SELECT membership.membership_name FROM users 
    //         LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    //         LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    //         WHERE users.user_id = '$batchId' ");
    //         $incomeData = '';
    //         while ($row = mysqli_fetch_assoc($query)) {
    //             $incomeData .= "<option value='{$row['membership_name']}'>{$row['membership_name']}</option>";
    //         }
    //     } else {
    //         $incomeData = 'ID not provided for batch Data';
    //     }
    // } 
    elseif ($_POST['type'] == "membership_Data") {
            $sql = "SELECT membership_name, membership_id FROM membership WHERE membership_status = 'Active'";
            $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
            $incomeData = '---';
            while ($row = mysqli_fetch_assoc($query)) {
                $incomeData .= "<option value='{$row['membership_id']}'>{$row['membership_name']}</option>";
            }
    } 
    // elseif ($_POST['type'] == "amount_Data") {
    //     if (isset($_POST['id'])) {
    //         $batchId = $_POST['id'];
    //         $query = mysqli_query($conn, "SELECT membership.membership_amount FROM users
    //         LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    //         LEFT JOIN membership ON membership.membership_id = users_detail.membership_id 
    //         WHERE users.user_id = '$batchId'");
    //         $incomeData = '';
    //         while ($row = mysqli_fetch_assoc($query)) {
    //             $incomeData .= "<option value='{$row['membership_amount']}'>{$row['membership_amount']}</option>";
    //         }
    //     } else {
    //         $incomeData = 'ID not provided for batch Data';
    //     }
    // }
    elseif ($_POST['type'] == "amount_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT membership_id,membership_amount FROM membership
            WHERE membership_id=$batchId");
            $incomeData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $incomeData .= "<option value='{$row['membership_amount']}'>{$row['membership_amount']}</option>";
            }
        } else {
            $incomeData = 'ID not provided for batch Data';
        }
    }
    elseif ($_POST['type'] == "membership_validation_days") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT membership_id, validation_days FROM membership
            WHERE membership_id=$batchId");
            $incomeData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $incomeData .= "<option value='{$row['validation_days']}'>{$row['validation_days']}</option>";
            }
        } else {
            $incomeData = 'ID not provided for batch Data';
        }
    }
} else {
    $incomeData = 'Type parameter not set';
}

echo $incomeData;


// attendence.php
if (isset($_POST['type'])) {
    if ($_POST['type'] == "attend_name_Data") {
        $sql = "SELECT users.user_id, users.username, role.name FROM `users` 
        LEFT JOIN `users_detail` ON `users`.`users_detail_id` = `users_detail`.`users_detail_id` 
        LEFT JOIN role ON role.role_id = users.role_id
        WHERE role.name != 'Admin';";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $attendenceData = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $attendenceData .= "<option value='{$row['user_id']}'>{$row['username']}</option>";
        }
    } elseif ($_POST['type'] == "attend_phone_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT users_detail.phone FROM `users` 
            LEFT JOIN `users_detail` ON `users`.`users_detail_id` = `users_detail`.`users_detail_id` 
            WHERE `user_id` = '$batchId' ");
            $attendenceData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $attendenceData .= "<option value='{$row['phone']}'>{$row['phone']}</option>";
            }
        } else {
            $attendenceData = 'ID not provided for batch Data';
        }
    } elseif ($_POST['type'] == "attend_role_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT role.name FROM `users` LEFT JOIN `role` ON `users`.`role_id` = `role`.`role_id` 
            WHERE `user_id` = '$batchId' ");
            $attendenceData = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $attendenceData .= "<option value='{$row['name']}'>{$row['name']}</option>";
            }
        } else {
            $attendenceData = 'ID not provided for batch Data';
        }
    }
} else {
    $attendenceData = 'Type parameter not set';
}

echo $attendenceData;



// salary.php
if (isset($_POST['type'])) {
    if ($_POST['type'] == "salary_name_Data") {
        $sql = "SELECT users.user_id, users.username FROM users 
        LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
        LEFT JOIN role ON role.role_id = users.role_id
        WHERE role.name != 'Admin' AND role.name != 'Member'";
        $query = mysqli_query($conn, $sql) or die('Query unsuccessful: ' . mysqli_error($conn));
        $sutudent = '---';
        while ($row = mysqli_fetch_assoc($query)) {
            $sutudent .= "<option value='{$row['user_id']}'>{$row['username']}</option>";
        }
    } elseif ($_POST['type'] == "salary_phone_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT users_detail.Phone FROM users 
            LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
            LEFT JOIN role ON role.role_id = users.role_id
            WHERE users.user_id = '$batchId'");
            $sutudent = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $sutudent .= "<option value='{$row['Phone']}'>{$row['Phone']}</option>";
            }
        } else {
            $sutudent = 'ID not provided for batch Data';
        }
    } elseif ($_POST['type'] == "salary_amount_Data") {
        if (isset($_POST['id'])) {
            $batchId = $_POST['id'];
            $query = mysqli_query($conn, "SELECT users_detail.salary FROM users 
            LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
            LEFT JOIN role ON role.role_id = users.role_id
            WHERE users.user_id = '$batchId'");
            $sutudent = '';
            while ($row = mysqli_fetch_assoc($query)) {
                $sutudent .= "<option value='{$row['salary']}'>{$row['salary']}</option>";
            }
        } else {
            $sutudent = 'ID not provided for batch Data';
        }
    }
} else {
    $sutudent = 'Type parameter not set';
}

echo $sutudent;
