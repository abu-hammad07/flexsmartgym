<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');






// ======================== Update Admin User Details page (admin-edit)[update_admin]  ========================
if (isset($_POST['update_admin'])) {
    // Check if all required fields are set
    $required_fields = ['admin_id', 'full_name', 'phone_no', 'address', 'gender', 'age', 'city', 'country', 'username', 'email'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $_SESSION['error_update_admin'] = "Please fill in all required fields";
            header('Location: admin-details');
            exit();
        }
    }

    // Sanitize input data
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the admin_id is a valid integer
    if (!ctype_digit($admin_id)) {
        $_SESSION['error_update_admin'] = "Invalid admin ID";
        header('Location: admin-details');
        exit();
    }

    // updated date
    $updated_date = date("Y-m-d");
    // updated by
    $updated_by = $_SESSION['username'];

    // Check unique username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$admin_id'";
    $check_username_res = mysqli_query($conn, $check_username);
    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_update_admin'] = "No update because username already exists";
        header('Location: admin-details');
        exit();
    }

    // Check unique email
    $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$admin_id'";
    $check_email_res = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($check_email_res) > 0) {
        $_SESSION['error_update_admin'] = "No update because email already exists";
        header('Location: admin-details');
        exit();
    }

    // Check if an image was uploaded
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
    }

    // Update users table
    $update_user_query = "UPDATE `users`
        SET
            `username` = '$username',
            `email` = '$email',
            `updated_date` = '$updated_date',
            `updated_by` = '$updated_by'
        WHERE `user_id` = $admin_id";
    $update_user_res = mysqli_query($conn, $update_user_query);

    if ($update_user_res) {
        // Update user_details table
        $update_details_query = "UPDATE `user_details`
            SET 
                `full_name` = '$full_name', 
                `phone` = '$phone_no', 
                `address` = '$address', 
                `gender` = '$gender', 
                `age` = '$age', 
                `city` = '$city', 
                `country` = '$country',
                `updated_date` = '$updated_date',
                `updated_by` = '$updated_by'";
        // Append image update if an image was uploaded
        if (!empty($image)) {
            $update_details_query .= ", `image` = '$image'";
        }
        $update_details_query .= " WHERE `user_id` = $admin_id";

        // Perform the update query
        $update_details_res = mysqli_query($conn, $update_details_query);

        if ($update_details_res) {
            // Redirect to admin details page on success
            $_SESSION['success_update_admin'] = "Admin User Successfully Updated";
            header('Location: admin-details');
            exit();
        } else {
            $_SESSION['error_update_admin'] = "Failed to update admin user details";
            header('Location: admin-details');
            exit();
        }
    } else {
        $_SESSION['error_update_admin'] = "Failed to update admin user";
        header('Location: admin-details');
        exit();
    }
}







// ======================== Update Member User Details page (member-edit)[update_member]  ========================
if (isset($_POST['update_member'])) {

    // Sanitize input data
    $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $subscription = mysqli_real_escape_string($conn, $_POST['subscription']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $admission_fees = mysqli_real_escape_string($conn, $_POST['admission_fees']);
    $monthly_fees = mysqli_real_escape_string($conn, $_POST['monthly_fees']);
    $joinning_date = mysqli_real_escape_string($conn, $_POST['joinning_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if the admin_id is a valid integer
    if (!ctype_digit($admin_id)) {
        $_SESSION['error_update_member'] = "Invalid admin ID";
        header('Location: members-details.php');
        exit();
    }

    // updated date
    $updated_date = date("Y-m-d");
    // updated by
    $updated_by = $_SESSION['username'];

    // Check unique username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$admin_id'";
    $check_username_res = mysqli_query($conn, $check_username);
    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_update_member'] = "No update because username already exists";
        header('Location: members-details.php');
        exit();
    }

    // Check unique email
    $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$admin_id'";
    $check_email_res = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($check_email_res) > 0) {
        $_SESSION['error_update_member'] = "No update because email already exists";
        header('Location: members-details.php');
        exit();
    }

    // Check if an image was uploaded
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
    }

    // Update users table
    $update_user_query = "UPDATE `users`
        SET
            `username` = '$username',
            `email` = '$email',
            `updated_date` = '$updated_date',
            `updated_by` = '$updated_by'
        WHERE `user_id` = $admin_id";
    $update_user_res = mysqli_query($conn, $update_user_query);

    if ($update_user_res) {
        // Update user_details table
        $update_details_query = "UPDATE `user_details`
            SET 
                `full_name` = '$full_name', 
                `phone` = '$phone_no', 
                `address` = '$address', 
                `gender` = '$gender', 
                `age` = '$age', 
                `city` = '$city', 
                `country` = '$country',
                `subscription` = '$subscription',
                `amount` = '$amount',
                `admission_fees` = '$admission_fees',
                `monthly_fees` = '$monthly_fees',
                `joinning_date` = '$joinning_date',
                `end_date` = '$end_date',
                `updated_date` = '$updated_date',
                `updated_by` = '$updated_by'";
        // Append image update if an image was uploaded
        if (!empty($image)) {
            $update_details_query .= ", `image` = '$image'";
        }
        $update_details_query .= " WHERE `user_id` = $admin_id";

        // Perform the update query
        $update_details_res = mysqli_query($conn, $update_details_query);

        if ($update_details_res) {
            // Redirect to admin details page on success
            $_SESSION['update_message_member'] = "Member Successfully Updated";
            header('Location: members-details.php');
            exit();
        } else {
            $_SESSION['error_update_member'] = "Failed to update member details";
            header('Location: members-details.php');
            exit();
        }
    } else {
        $_SESSION['error_update_member'] = "Failed to update member";
        header('Location: members-details.php');
        exit();
    }
}









// ======================== Update Staff User Details page (staff-edit)[update_staff]  ========================
if (isset($_POST['update_staff'])) {

    // Sanitize input data
    $staff_id = mysqli_real_escape_string($conn, $_POST['staff_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $joinning_date = mysqli_real_escape_string($conn, $_POST['joinning_date']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $start_timing = mysqli_real_escape_string($conn, $_POST['start_timing']);
    $end_timing = mysqli_real_escape_string($conn, $_POST['end_timing']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the staff_id is a valid integer
    if (!ctype_digit($staff_id)) {
        $_SESSION['error_update_staff'] = "Invalid admin ID";
        header('Location: staff-details.php');
        exit();
    }

    // updated date
    $updated_date = date("Y-m-d");
    // updated by
    $updated_by = $_SESSION['username'];

    // Check unique username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$staff_id'";
    $check_username_res = mysqli_query($conn, $check_username);
    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_update_staff'] = "No update because username already exists";
        header('Location: staff-details.php');
        exit();
    }

    // Check unique email
    $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$staff_id'";
    $check_email_res = mysqli_query($conn, $check_email);
    if (mysqli_num_rows($check_email_res) > 0) {
        $_SESSION['error_update_staff'] = "No update because email already exists";
        header('Location: staff-details.php');
        exit();
    }

    // Check if an image was uploaded
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
    }

    // Update users table
    $update_user_query = "UPDATE `users`
        SET
            `username` = '$username',
            `email` = '$email',
            `updated_date` = '$updated_date',
            `updated_by` = '$updated_by'
        WHERE `user_id` = $staff_id";
    $update_user_res = mysqli_query($conn, $update_user_query);

    if ($update_user_res) {
        // Update user_details table
        $update_details_query = "UPDATE `user_details`
            SET 
                `full_name` = '$full_name', 
                `phone` = '$phone_no', 
                `address` = '$address', 
                `gender` = '$gender', 
                `age` = '$age', 
                `city` = '$city', 
                `country` = '$country',
                `joinning_date` = '$joinning_date',
                `start_timing` = '$start_timing',
                `end_timing` = '$end_timing',
                `salary` = '$salary',
                `updated_date` = '$updated_date',
                `updated_by` = '$updated_by'";
        // Append image update if an image was uploaded
        if (!empty($image)) {
            $update_details_query .= ", `image` = '$image'";
        }
        $update_details_query .= " WHERE `user_id` = $staff_id";

        // Perform the update query
        $update_details_res = mysqli_query($conn, $update_details_query);

        if ($update_details_res) {
            // Redirect to admin details page on success
            $_SESSION['success_update_staff'] = $full_name . " Successfully Updated";
            header('Location: staff-details.php');
            exit();
        } else {
            $_SESSION['error_update_staff'] = "Failed to update member details";
            header('Location: staff-details.php');
            exit();
        }
    } else {
        $_SESSION['error_update_staff'] = "Failed to update member";
        header('Location: staff-details.php');
        exit();
    }
}






// ======================================== Add fetures code page (add-expense)[save_expense]  =======================

// if (isset($_POST['save_expense'])) {

//     $expense_name = mysqli_real_escape_string($conn, $_POST['expense_name']);
//     $expense_category = mysqli_real_escape_string($conn, $_POST['expense_category']);
//     $expense_amount = mysqli_real_escape_string($conn, $_POST['expense_amount']);


//     // Get the current date and time
//     $created_date = date('Y-m-d');

//     // Get the user's ID
//     $created_by = $_SESSION['username'];

//     // Insert data into interested table
//     $insert_expense = "INSERT INTO `expense`(`expense_name`, `category_id`, `expense_amount`, `created_by`, `created_date`)
//     VALUES ('$expense_name', '$expense_category', '$expense_amount', '$created_by', '$created_date')";

//     $insert_expense_res = mysqli_query($conn, $insert_expense);
//     if ($insert_expense_res) {
//         $_SESSION['success_message_expense'] = "Expense Added Successfully";
//         header('location: add-expense');
//         exit();
//     } else {
//         $_SESSION['error_message_expense'] = "Expense Not Added";
//         header('location: add-expense');
//         exit();
//     }
// }









// ======================== Delete category code page (category)[delete_category_id]  ========================
if (isset($_GET['delete_category_id'])) {
    $category_id = mysqli_real_escape_string($conn, $_GET['delete_category_id']);

    // check if category is use in expense
    $check_category = "SELECT expense_category_id  FROM `expense` WHERE `expense_category_id` = '$category_id'";
    $check_category_res = mysqli_query($conn, $check_category);
    if (mysqli_num_rows($check_category_res) > 0) {
        $_SESSION['error_message_category'] = "Category not deleted, it is used in expense";
        header("location: category");
        exit();
    }

    $delete_category = "DELETE FROM `expense_category` WHERE `exp_category_id` = '$category_id'";

    $delete_category_res = mysqli_query($conn, $delete_category);
    if ($delete_category_res) {
        $_SESSION['success_message_category'] = "Category Deleted Successfully";
        header("location: category");
        exit();
    } else {
        $_SESSION['error_message_category'] = "Category Not Deleted";
        header("location: category");
        exit();
    }
}











// ======================== Add fetures code page (fetures)[fetures_save]  ========================
if (isset($_POST['fetures_save'])) {
    $feture_name = mysqli_real_escape_string($conn, $_POST['fetures']);

    // Get the current date and time
    $created_date = date('Y-m-d');
    // Get the user's ID
    $created_by = $_SESSION['username'];
    // Get the user's ID
    $uid = $_SESSION['UID'];

    // unique feture name
    $check_feture = "SELECT * FROM `fetures` WHERE `feture_name` = '$feture_name'";
    $check_feture_res = mysqli_query($conn, $check_feture);
    if (mysqli_num_rows($check_feture_res) > 0) {
        $_SESSION['error_message_fetures'] = "Feture already exists";
        header("location: fetures");
        exit();
    }

    // Insert data into interested table
    $insert_feture = "INSERT INTO `fetures`(`feture_name`, `created_by`, `created_date`) 
    VALUES ('$feture_name', '$created_by', '$created_date')";

    $insert_feture_res = mysqli_query($conn, $insert_feture);
    if ($insert_feture_res) {
        // redirect("fetures", "feture Added Successfully'. $feture_name");
        header('location: fetures');
        $_SESSION['success_message_fetures'] = "Feture Added Successfully";
        exit();
    } else {
        header('location: fetures');
        $_SESSION['error_message_fetures'] = "Feture Added Successfully";
        exit();
    }
}

// ======================== Update fetures code page (fetures)[fetures_save]  ========================
if (isset($_POST['update_fetures'])) {

    $get_feture_id = mysqli_real_escape_string($conn, $_POST['get_feture_id']);
    $update_fetures = mysqli_real_escape_string($conn, $_POST['fetures']);

    // Get the current date and time
    $updated_date = date('Y-m-d');
    // Get the user's ID
    $updated_by = $_SESSION['username'];
    // Get the user's ID
    $uid = $_SESSION['UID'];

    // unique feture name
    $check_feture = "SELECT * FROM `fetures` WHERE `feture_name` = '$update_fetures' AND `id` != '$get_feture_id'";
    $check_feture_res = mysqli_query($conn, $check_feture);
    if (mysqli_num_rows($check_feture_res) > 0) {
        $_SESSION['error_message_fetures'] = "Feture already exists";
        header("location: fetures");
        exit();
    }

    // Insert data into interested table
    $insert_feture = "UPDATE `fetures` SET 
    `feture_name`='$update_fetures',
    `updated_by`='$updated_by',
    `updated_date`='$updated_date' 
    WHERE `id` = '$get_feture_id'";

    $insert_feture_res = mysqli_query($conn, $insert_feture);
    if ($insert_feture_res) {
        // redirect("fetures", "feture Added Successfully'. $feture_name");
        header('location: fetures');
        $_SESSION['success_message_fetures'] = "Feture Updated Successfully";
        exit();
    } else {
        header('location: fetures');
        $_SESSION['error_message_fetures'] = "Feture Not Updated";
        exit();
    }
}



// ======================= Delete Feture code page (feture)[delete_feture_id]  ========================
if (isset($_GET['delete_feture_id'])) {
    $feture_id = mysqli_real_escape_string($conn, $_GET['delete_feture_id']);

    $delete_feture = "DELETE FROM `fetures` WHERE `id` = '$feture_id'";

    $delete_feture_res = mysqli_query($conn, $delete_feture);

    if ($delete_feture_res) {
        $_SESSION['success_message_fetures'] = "Subscription Deleted Successfully";
        header("location: fetures");
        exit();
    } else {
        $_SESSION['error_message_fetures'] = "This Subscription Not Deleted";
        header("location: fetures");
        exit();
    }
}












if (isset($_POST['save_income'])) {

    // Escape user inputs to prevent SQL injection
    $income_name = mysqli_real_escape_string($conn, $_POST['income_name']);
    $income_phone = mysqli_real_escape_string($conn, $_POST['income_phone']);
    $subscription = mysqli_real_escape_string($conn, $_POST['subscription']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $fees_date = mysqli_real_escape_string($conn, $_POST['fees_date']);
    $monthly_date = mysqli_real_escape_string($conn, $_POST['monthly_date']);
    $pay_fees = mysqli_real_escape_string($conn, $_POST['pay_fees']);

    // Calculate remaining fees
    $remaining_fees = $amount - $pay_fees;
    if ($remaining_fees < 0) {
        $remaining_fees = 0;
    }

    // Check if amount fees is greater than pay fees
    if ($amount <= $pay_fees) {
        $_SESSION['error_message_income'] = "Amount fees must be greater than pay fees";
        header("location: add-income.php");
        exit();
    }

    // Check for existing income for the same month
    $check_income_query = "SELECT * FROM `income` WHERE `name` = '$income_name' AND `monthly_date` = '$monthly_date'";
    $check_income_result = mysqli_query($conn, $check_income_query);
    if (mysqli_num_rows($check_income_result) > 0) {
        $_SESSION['error_message_income'] = "Income for this month already exists. Please choose a different month.";
        header("location: add-income.php");
        exit();
    }

    // Insert data into the database
    $insert_income_query = "INSERT INTO `income` (`name`, `phone_no`, `subscription`, `amount`, `fees_date`, `monthly_date`, `pay_fees`, `remaining_fees`, `created_by`, `created_date`)
                            VALUES ('$income_name', '$income_phone', '$subscription', '$amount', '$fees_date', '$monthly_date', '$pay_fees', '$remaining_fees', '{$_SESSION['username']}', NOW())";
    $insert_income_result = mysqli_query($conn, $insert_income_query);

    if ($insert_income_result) {
        $_SESSION['success_message_income'] = "Income Added Successfully";
        header("location: add-income.php");
        exit();
    } else {
        $_SESSION['error_message_income'] = "Failed to add income. Please try again.";
        header("location: add-income.php");
        exit();
    }
} else {
    // Redirect if accessed directly
    $_SESSION['error_message_income'] = "Invalid request";
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Escape user inputs to prevent SQL injection
    $income_name = mysqli_real_escape_string($conn, $_POST['income_name']);
    $income_phone = mysqli_real_escape_string($conn, $_POST['income_phone']);
    $subscription = mysqli_real_escape_string($conn, $_POST['subscription']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $admission_fees = mysqli_real_escape_string($conn, $_POST['admission_fees']);
    $fees_date = mysqli_real_escape_string($conn, $_POST['fees_date']);
    $monthly_date = mysqli_real_escape_string($conn, $_POST['monthly_date']);
    $pay_fees = mysqli_real_escape_string($conn, $_POST['pay_fees']);

    // Calculate remaining fees
    $remaining_fees = $amount - $pay_fees;
    if ($remaining_fees < 0) {
        $remaining_fees = 0;
    }

    // Check if amount fees is greater than pay fees
    if ($amount <= $pay_fees) {
        $_SESSION['error_message_income'] = "Amount fees must be greater than pay fees";
        header("location: add-income.php");
        exit();
    }

    // Check for existing income for the same month
    $check_income_query = "SELECT * FROM `income` WHERE `name` = '$income_name' AND `monthly_date` = '$monthly_date'";
    $check_income_result = mysqli_query($conn, $check_income_query);
    if (mysqli_num_rows($check_income_result) > 0) {
        $_SESSION['error_message_income'] = "Income for this month already exists. Please choose a different month.";
        header("location: add-income.php");
        exit();
    }

    // Insert data into the database
    $insert_income_query = "INSERT INTO `income` (`name`, `phone_no`, `subscription`, `amount`, `fees_date`, `monthly_date`, `pay_fees`, `remaining_fees`, `created_by`, `created_date`)
                            VALUES ('$income_name', '$income_phone', '$subscription', '$amount', '$fees_date', '$monthly_date', '$pay_fees', '$remaining_fees', '{$_SESSION['username']}', NOW())";
    $insert_income_result = mysqli_query($conn, $insert_income_query);

    if ($insert_income_result) {
        $_SESSION['success_message_income'] = "Income Added Successfully";
        header("location: add-income.php");
        exit();
    } else {
        $_SESSION['error_message_income'] = "Failed to add income. Please try again.";
        header("location: add-income.php");
        exit();
    }
} else {
    // Redirect if accessed directly
    $_SESSION['error_message_income'] = "Invalid request";
}
