<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================= Add Income code page (add-icnome)[save_income]  ========================

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $pay_salary = mysqli_real_escape_string($conn, $_POST['pay_salary']);
    $monthly_date = mysqli_real_escape_string($conn, $_POST['monthly_date']);
    $salary_amount = mysqli_real_escape_string($conn, $_POST['salary_amount']);

    // Get username
    $username_select = "SELECT username FROM `users` WHERE `user_id` = '$users_id'";
    $username_result = mysqli_query($conn, $username_select);
    $getUsername = mysqli_fetch_assoc($username_result)['username'];

    // Calculate remaining fees
    $remaining_salary = $salary_amount - $pay_salary;
    if ($remaining_salary < 0) {
        $remaining_salary = 0;
    }

    // Check if pay amount is greater than salary amount
    if ($pay_salary > $salary_amount) {
        $_SESSION['error_message_salary'] = "'$salary_amount' Pay amount cannot be greater than salary amount '$pay_salary' ($getUsername).";
        header("location: add-salary.php");
        exit();
    }

    // Check for existing income for the same month
    $check_income_query = "SELECT * FROM `salary` WHERE `users_id` = '$users_id' AND `monthly_date` = '$monthly_date'";
    $check_income_result = mysqli_query($conn, $check_income_query);
    if (mysqli_num_rows($check_income_result) > 0) {
        $_SESSION['error_message_salary'] = "Salary for this month already exists, ($getUsername) Please choose $monthly_date.";
        header("location: add-salary.php");
        exit();
    }

    // created_date
    $created_date = date('Y-m-d');

    // Attempt insert query execution
    $sql = "INSERT INTO `salary` (
        `users_id`, `monthly_date`, `pay_salary`, `remaining_salary`, `created_by`, `created_date`)
    VALUES ('$users_id', '$monthly_date', '$pay_salary', '$remaining_salary', '{$_SESSION['username']}', $created_date)";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success_message_salary'] = "Income Added Successfully, ($getUsername) Pay $pay_salary for $monthly_date.";
        header("location: add-salary.php");
        exit();
    } else {
        $_SESSION['error_message_salary'] = "ERROR: Could not able to execute, ($getUsername) $sql. " . mysqli_error($conn);
    }

    // Close conn
    // mysqli_close($conn);
}


include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');








?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_salary'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['success_message_salary'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['success_message_salary']);
    }
    if (isset($_SESSION['error_message_salary'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $_SESSION['error_message_salary'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['error_message_salary']);
    }
    ?>
    <!-- / Alert -->



    <div class="row">
        <!-- Personal Information -->
        <form action="" method="POST" id="add_salary_form" enctype="multipart/form-data">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <h4 class="card-header">Add Salary</h4>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="salary_name" class="form-label">Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select id="salary_name" name="users_id" class="form-control" onchange="salary_amount()">
                                        <option value="">---------</option>
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="salary_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="salary_phone" class="form-label">Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select id="salary_phone" class="form-control">
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="salary_phone_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="country" class="form-label">Amount</label>
                                <div class="input-group">
                                    <select id="salary_amount" name="salary_amount" class="form-control">
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="salary_amount_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="pay_salary" class="form-label">Pay Salary
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="pay_salary" name="pay_salary" placeholder="Pay Fees" class="form-control">
                                <span class="inter error text-danger" id="pay_salary_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="monthly_date" class="form-label">Monthly Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="monthly_date" name="monthly_date" class="form-control" value="<?php echo date('Y-m'); ?>">
                                <span class="inter error text-danger" id="monthly_date_error"></span>
                            </div>
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
                    <button type="submit" class="btn btn-primary" name="save_salary">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->


<script src="../assets/js/custom/addSalaryError.js"></script>
<?php
include_once('./inc/footer.php');
?>

<script>
    $(document).ready(function() {
        function loadData(type, id) {
            $.ajax({
                url: 'ajex.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function(data) {
                    if (type === "salary_name_Data") {
                        $('#salary_name').append(data);
                    } else if (type === "salary_phone_Data") {
                        $('#salary_phone').html(data);
                    } else if (type === "salary_amount_Data") {
                        $('#salary_amount').html(data);
                    }
                }
            });
        }

        loadData("salary_name_Data");

        $("#salary_name").on("change", function() {
            var incomeData = $("#salary_name").val();
            if (incomeData != "") {
                loadData("salary_phone_Data", incomeData);
            } else {
                $('#salary_phone').html("");
            }
        });

        $("#salary_name").on("change", function() {
            var incomeData = $("#salary_name").val();
            if (incomeData != "") {
                loadData("salary_amount_Data", incomeData);
            } else {
                $('#salary_amount').html("");
            }
        });


    });
</script>