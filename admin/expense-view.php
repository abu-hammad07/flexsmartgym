<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}








// ======================== Edit fetures code page (add-subscription)[save_subscription]  ========================
if (isset($_GET['view_expense'])) {

    $view_expense = mysqli_real_escape_string($conn, $_GET['view_expense']);

    $sql = "SELECT expense.expense_id, expense.expense_name, expense_category.exp_category_id, expense_category.exp_category_name, expense.expense_amount, expense.expense_image
    FROM expense
    LEFT JOIN expense_category ON expense_category.exp_category_id = expense.expense_category_id
    WHERE expense.expense_id  = '$view_expense'";
    $result = mysqli_query($conn, $sql);

    $check = mysqli_num_rows($result);

    if ($check > 0) {

        $fetch_expense = mysqli_fetch_assoc($result);


        include_once('./inc/header.php');
        include_once('./inc/sidebar.php');
        include_once('./inc/navbar.php');
?>
<style>
    .preview-image {
        max-width: 100%;
        height: 400px;
        margin-top: 0.5rem;
    }
</style>
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Personal Information -->
                <form action="" method="POST" id="add_expense_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">View Expense</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_name" class="form-label">Expense Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" hidden id="expense_id" name="expense_id" value="<?= $fetch_expense['expense_id']; ?>" />
                                        <input class="form-control" type="text" readonly placeholder="Expense Name" id="expense_name" name="expense_name" value="<?= $fetch_expense['expense_name']; ?>" />
                                        <span class="inter error text-danger" id="expense_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_category" class="form-label">Category
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="expense_category" readonly name="expense_category" class="form-control">
                                                <option value="<?= $fetch_expense['exp_category_id']; ?>"><?= $fetch_expense['exp_category_name']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="expense_category_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="expense_amount" class="form-label">Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="expense_amount" readonly name="expense_amount" class="form-control" placeholder="Amount" value="<?= $fetch_expense['expense_amount']; ?>">
                                        <span class="inter error text-danger" id="expense_amount_error"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="expense_image" class="form-label">Expense Image</label>
                                        <img src="../media/images/<?= $fetch_expense['expense_image'] ?>" class="preview-image mt-2" alt="<?= $fetch_expense['expense_name'] ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-12 btm-group">
                            <a type="button" href="expense-details" class="btn btn-danger text-white">Back</a>
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



<script src="../assets/js/custom/addSubscriptionError.js"></script>
<?php
include_once('./inc/footer.php');
?>