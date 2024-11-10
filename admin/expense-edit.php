<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}




// ======================== Add fetures code page (add-expensetion)[save_expensetion]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user inputs
    $expense_id = mysqli_real_escape_string($conn, $_POST['expense_id']);
    $expense_name = mysqli_real_escape_string($conn, $_POST['expense_name']);
    $expense_category = mysqli_real_escape_string($conn, $_POST['expense_category']);
    $expense_amount = mysqli_real_escape_string($conn, $_POST['expense_amount']);

    // Get current date and user info
    $updated_date = date('Y-m-d');
    $updated_by = $_SESSION['username'];

    // Check for duplicate expense name
    $check_expense_name = "SELECT * FROM `expense` WHERE `expense_name` = '$expense_name' AND `expense_name` != '$expense_name'";
    $check_expense_name_res = mysqli_query($conn, $check_expense_name);

    if (mysqli_num_rows($check_expense_name_res) > 0) {
        $_SESSION['error_update_expense'] = "Expense name already exists, please change ($expense_name)";
        header("location: expense-details");
        exit();
    } else {

        // Check if an image was uploaded
        $image = '';
        if (!empty($_FILES['image']['name'])) {
            $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
        }

        // Update data in expense table
        $update_expense = "UPDATE `expense` SET 
        `expense_name`='$expense_name', `expense_amount`='$expense_amount', `expense_category_id`='$expense_category',  
        `updated_by`='$updated_by', `updated_date`='$updated_date'";


        if (!empty($image)) {
            $update_expense .= ", `expense_image` = '$image'";
        }

        $update_expense .= " WHERE `expense_id` = '$expense_id'";

        $update_expense_res = mysqli_query($conn, $update_expense);

        if ($update_expense_res) {
            $_SESSION['success_update_expense'] = "Expense Updated Successfully, ($expense_name)";
            header("location: expense-details");
            exit();
        } else {
            $_SESSION['error_update_expense'] = "This ($expense_name) Expense Not Updated";
            header("location: expense-details");
            exit();
        }
    }
}






include_once ('./inc/header.php');
include_once ('./inc/sidebar.php');
include_once ('./inc/navbar.php');



// ======================== Edit fetures code page (add-expensetion)[save_expensetion]  ========================

if (isset($_GET['edit_expense_id'])) {

    $edit_expense_id = mysqli_real_escape_string($conn, $_GET['edit_expense_id']);

    $sql = "SELECT expense.expense_id, expense.expense_name, expense_category.exp_category_id, expense_category.exp_category_name, expense.expense_amount
    FROM expense
    LEFT JOIN expense_category ON expense_category.exp_category_id = expense.expense_category_id
    WHERE expense.expense_id = '$edit_expense_id'";
    $result = mysqli_query($conn, $sql);

    $check = mysqli_num_rows($result);

    if ($check > 0) {

        $fetch_expense = mysqli_fetch_assoc($result);
        ?>

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Personal Information -->
                <form action="" method="POST" id="add_expense_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">Edit Expense</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_name" class="form-label">Expense Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" hidden id="expense_id" name="expense_id"
                                            value="<?= $fetch_expense['expense_id']; ?>" />
                                        <input class="form-control" type="text" placeholder="Expense Name" id="expense_name"
                                            name="expense_name" value="<?= $fetch_expense['expense_name']; ?>" />
                                        <span class="inter error text-danger" id="expense_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_category" class="form-label">Category
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <?php
                                            // fatch the data from database for fetures
                                            $sql = "SELECT exp_category_id, exp_category_name FROM expense_category 
                                            WHERE exp_category_id != {$fetch_expense['exp_category_id']}";
                                            $result = mysqli_query($conn, $sql);
                                            ?>
                                            <select id="expense_category" name="expense_category" class="form-control">
                                                <option value="<?= $fetch_expense['exp_category_id']; ?>">
                                                    <?= $fetch_expense['exp_category_name']; ?></option>
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
                                        <input type="text" id="expense_amount" name="expense_amount" class="form-control"
                                            placeholder="Amount" value="<?= $fetch_expense['expense_amount']; ?>">
                                        <span class="inter error text-danger" id="expense_amount_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_image" class="form-label">Image
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" id="expense_image" name="image" class="form-control">
                                        <span class="inter error text-danger" id="expense_image_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-12 btm-group">
                        </div>
                    </div>
                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 text-start">
                            <a type="button" href="expense-details" class="btn btn-danger text-white">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                            <button type="submit" class="btn btn-primary" name="update_expense">Update</button>
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



<script src="../assets/js/custom/addexpensetionError.js"></script>
<?php
include_once ('./inc/footer.php');
?>