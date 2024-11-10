<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================= Edit Income code page (icnome-edit)[save_salary]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if the necessary POST variables are set
    if (isset($_POST['salary_id'], $_POST['user_id'], $_POST['salary_amount'], $_POST['pay_salary'], $_POST['monthly_date'])) {

        // Escape and retrieve POST data
        $salary_id = mysqli_real_escape_string($conn, $_POST['salary_id']);
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $salary_amount = mysqli_real_escape_string($conn, $_POST['salary_amount']);
        $pay_salary = mysqli_real_escape_string($conn, $_POST['pay_salary']);
        $monthly_date = mysqli_real_escape_string($conn, $_POST['monthly_date']);

        // Ensure numeric conversion of remaining salary and remaining pay salary
        $reamaining_salary = isset($_POST['reamaining_salary']) ? intval($_POST['reamaining_salary']) : 0;
        $remaining_pay_salary = isset($_POST['remaining_pay_salary']) ? intval($_POST['remaining_pay_salary']) : 0;

        // Get username
        $username_select = "SELECT username FROM `users` WHERE `user_id` = '$user_id'";
        $username_result = mysqli_query($conn, $username_select);
        $getUsername = mysqli_fetch_assoc($username_result)['username'];

        // Calculate remaining salary
        $remaining_salary = $reamaining_salary - $remaining_pay_salary;
        if ($remaining_salary < 0) {
            $remaining_salary = 0;
        }

        // Check if remaining fees is less than pay salary
        if ($reamaining_salary < $remaining_pay_salary) {
            $_SESSION['error_update_message_salary'] = "$getUsername '$reamaining_salary' Amount fees must be greater than pay salary '$remaining_pay_salary'";
            header("location: salary");
            exit();
        }


        // create date time & username
        $updated_by = $_SESSION['username'];
        $updated_date = date("Y-m-d");
        $remaining_salary_date = date("Y-m-d");

        // check the unique salary name & month date if month date is same then it will be unique
        $check_salary = "SELECT * FROM `salary` WHERE `users_id` = '$user_id' AND `monthly_date` = '$monthly_date' AND `salary_id` != $salary_id";
        $check_salary_res = mysqli_query($conn, $check_salary);
        if (mysqli_num_rows($check_salary_res) > 0) {
            $_SESSION['error_update_message_salary'] = "$getUsername '$monthly_date' This month fees already exists, please change '$monthly_date'";
            header("location: salary");
            exit();
        }

        // Update data in the salary table
        $update_salary = "UPDATE `salary` 
    SET 
    `users_id`='$user_id',
    `monthly_date`='$monthly_date',
    `pay_salary`= `pay_salary` + $remaining_pay_salary,
    `remaining_salary`='$remaining_salary',
    `remaining_salary_date`= '$remaining_salary_date',
    `updated_by`= '$updated_by',
    `updated_date`= '$updated_date'
    WHERE `salary_id` = $salary_id";

        $update_salary_res = mysqli_query($conn, $update_salary);

        if ($update_salary_res) {
            $_SESSION['update_message_salary'] = "Income Updated Successfully, ($getUsername)";
            header("location: salary");
            exit();
        } else {
            // Handle case where required POST variables are not set
            $_SESSION['error_update_message_salary'] = "Required POST data is missing, ($getUsername)";
            header("location: salary");
            exit();
        }
    }
}







include_once('./inc/header.php');
include_once('./inc/sidebar.php');
include_once('./inc/navbar.php');



// ======================== Edit fetures code page (add-salarytion)[save_salarytion]  ========================

if (isset($_GET['salary_edit_id'])) {

    $edit_salary_id = mysqli_real_escape_string($conn, $_GET['salary_edit_id']);

    $sql = "SELECT users.username, users_detail.Phone, users_detail.salary, 
    salary.salary_id, salary.users_id as user_id, salary.monthly_date, salary.pay_salary, salary.remaining_salary 
    FROM `salary` 
    LEFT JOIN users ON users.user_id = salary.users_id
    LEFT JOIN users_detail on users_detail.users_detail_id = users.users_detail_id
    WHERE `salary_id` = '$edit_salary_id'";
    $result = mysqli_query($conn, $sql);

    $check = mysqli_num_rows($result);

    if ($check > 0) {

        $fetch_salary = mysqli_fetch_assoc($result);
?>

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Personal Information -->
                <form action="" method="POST" id="add_salary_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">Edit Salary</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <input type="text" name="salary_id" hidden class="form-control" value="<?= $fetch_salary['salary_id']; ?>">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="salary_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="salary_name" name="user_id" class="form-control" onchange="salary_amount()">
                                                <option value="<?= $fetch_salary['user_id']; ?>"><?= $fetch_salary['username']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="salary_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="salary_phone" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="salary_phone" name="salary_phone" class="form-control">
                                                <option value="<?= $fetch_salary['Phone']; ?>"><?= $fetch_salary['Phone']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="salary_phone_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Total Amount</label>
                                        <div class="input-group">
                                            <select id="salary_amount" name="salary_amount" class="form-control">
                                                <option value="<?= $fetch_salary['salary']; ?>"><?= $fetch_salary['salary']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="salary_amount_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="pay_salary" class="form-label">Pay Salary
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="pay_salary" name="pay_salary" placeholder="Pay Fees" readonly class="form-control" value="<?= $fetch_salary['pay_salary']; ?>">
                                        <span class="inter error text-danger" id="pay_salary_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="monthly_date" class="form-label">Monthly Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" id="monthly_date" name="monthly_date" class="form-control" value="<?= $fetch_salary['monthly_date']; ?>">
                                        <span class="inter error text-danger" id="monthly_date_error"></span>
                                    </div>
                                    <?php
                                    if ($fetch_salary['remaining_salary'] != 0) {
                                    ?>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="reamaining_salary" class="form-label">Remaining Salary
                                            </label>
                                            <input type="text" name="reamaining_salary" readonly class="form-control" value="<?= $fetch_salary['remaining_salary']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="remaining_pay_salary" class="form-label">Remaining Pay Salary</label>
                                            <input type="text" id="remaining_pay_salary" name="remaining_pay_salary" placeholder="Remaining Pay Salary" class="form-control">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 text-start">
                            <a type="button" href="salary" class="btn btn-danger text-white text-start">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                    <button type="submit" class="btn btn-primary" name="update_salary">Update</button>
                </div>
            </div>
                </form>

            </div>
        </div>
        <!-- / Content -->
<?php
    } else {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> Data not get from database.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
    }
}

?>



<script src="../assets/js/custom/addSalaryError.js"></script>
<?php
include_once('./inc/footer.php');
?>