<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expense_name = mysqli_real_escape_string($conn, $_POST['expense_name']);
    $expense_category = mysqli_real_escape_string($conn, $_POST['expense_category']);
    $expense_amount = mysqli_real_escape_string($conn, $_POST['expense_amount']);

    // Get current date and user info
    $created_date = date('Y-m-d');
    $created_by = $_SESSION['username'];

    // Check for duplicate expense name
    $check_expense_name = "SELECT expense_name FROM `expense` WHERE `expense_name` = '$expense_name'";
    $check_expense_name_res = mysqli_query($conn, $check_expense_name);

    if (mysqli_num_rows($check_expense_name_res) > 0) {
        $_SESSION['error_message_expense'] = "Expense name already exists, please change ($expense_name)";
        header("location: add-expense");
        exit();
    } else {

        // Check if image file is uploaded
        $expense_image = rand(111111111, 999999999) . '_' . $_FILES['expense_image']['name'];
        move_uploaded_file($_FILES['expense_image']['tmp_name'], '../media/images/' . $expense_image);

        // Insert data into expense table
        $insert_expense = "INSERT INTO `expense`(`expense_name`, `expense_category_id`, `expense_amount`, `expense_image`, `created_by`, `created_date`)
        VALUES ('$expense_name', '$expense_category', '$expense_amount', '$expense_image', '$created_by', '$created_date')";

        $insert_expense_res = mysqli_query($conn, $insert_expense);

        if ($insert_expense_res) {
            $_SESSION['success_message_expense'] = "Expense Added Successfully, ($expense_name)";
            header("location: add-expense");
            exit();
        } else {
            $_SESSION['error_message_expense'] = "This ($expense_name) Expense Not Added";
            header("location: add-expense");
            exit();
        }
    }
}




include_once('./inc/header.php');
include_once('./inc/sidebar.php');
include_once('./inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <!-- Personal Information -->
        <form action="" method="POST" id="add_expense_form" enctype="multipart/form-data">
            <div class="col-lg-12">

                <!-- Alert -->
                <?php
                if (isset($_SESSION['success_message_expense'])) {
                    echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_expense'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['success_message_expense']);
                }
                if (isset($_SESSION['error_message_expense'])) {
                    echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_expense'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['error_message_expense']);
                }
                ?>
                <!-- / Alert -->

                <div class="card mb-4">
                    <h4 class="card-header">Add Expense</h4>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="expense_name" class="form-label">Expense Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" placeholder="Expense Name" id="expense_name" name="expense_name" />
                                <span class="inter error text-danger" id="expense_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="expense_category" class="form-label">Category
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <?php
                                    // fatch the data from database for fetures
                                    $sql = "SELECT exp_category_id, exp_category_name FROM expense_category";
                                    $result = mysqli_query($conn, $sql);
                                    ?>
                                    <select id="expense_category" name="expense_category" class="form-control">
                                        <option value="">---------</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['exp_category_id'] . '">' . $row['exp_category_name'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="expense_category_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="expense_amount" class="form-label">Amount
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="expense_amount" name="expense_amount" class="form-control" placeholder="Amount">
                                <span class="inter error text-danger" id="expense_amount_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="expense_image" class="form-label">Image
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="file" id="expense_image" name="expense_image" class="form-control">
                                <span class="inter error text-danger" id="expense_image_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button  -->
            <div class="row mt-3">
                <div class="col-md-6 col-6 text-start">
                    <a type="button" href="expense-details" class="btn btn-danger text-white text-start">Back</a>
                </div>
                <div class="col-md-6 col-6 text-end">
                    <button type="submit" class="btn btn-primary" name="save_expense">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->




<script src="../assets/js/custom/addExpenseError.js"></script>
<?php
include_once('./inc/footer.php');
?>