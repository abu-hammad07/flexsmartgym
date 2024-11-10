<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

include_once('./inc/header.php');
include_once('./inc/sidebar.php');
include_once('./inc/navbar.php');



// ======================== Edit fetures code page (add-salarytion)[save_salarytion]  ========================

if (isset($_GET['salary_view_id'])) {

    $edit_salary_id = mysqli_real_escape_string($conn, $_GET['salary_view_id']);

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
                            <h3 class="card-header">View Salary</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="salary_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="salary_name" name="salary_name" class="form-control" onchange="salary_amount()">
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
                                        <label for="country" class="form-label">Amount</label>
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
                                        <input type="text" readonly id="pay_salary" name="pay_salary" placeholder="Pay Fees" class="form-control" onchange="pay_salary()" value="<?= $fetch_salary['pay_salary']; ?>">
                                        <span class="inter error text-danger" id="pay_salary_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="monthly_date" class="form-label">Monthly Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" readonly id="monthly_date" name="monthly_date" class="form-control" value="<?= $fetch_salary['monthly_date']; ?>">
                                        <span class="inter error text-danger" id="monthly_date_error"></span>
                                    </div>
                                    <?php
                                    if ($fetch_salary['remaining_salary'] > 0) {
                                    ?>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="remaining_salary" class="form-label">Remaining Salary
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="remaining_salary" name="remaining_salary" class="form-control" value="<?= $fetch_salary['remaining_salary']; ?>">
                                            <span class="inter error text-danger" id="remaining_salary_error"></span>
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
                        <div class="col-12 btm-group">
                            <a href="salary" class="btn btn-danger">Close</a>
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