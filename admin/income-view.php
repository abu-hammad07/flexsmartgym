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



// ======================== Edit fetures code page (add-expensetion)[save_expensetion]  ========================

if (isset($_GET['income_view_id'])) {

    $edit_expense_id = mysqli_real_escape_string($conn, $_GET['income_view_id']);

    $sql = "SELECT income_id, users.user_id, users.username, users_detail.Phone, 
    membership.membership_id, membership.membership_name, membership.membership_amount, 
    income.pay_fees, income.remaining_fees, income.pay_fees_date, income.payment_method,
    membership_details.membership_start_date, membership_details.membership_end_date
    FROM `income`
    LEFT JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    LEFT JOIN membership_details ON membership_details.user_id = users.user_id
    WHERE income_id = '$edit_expense_id'";
    $result = mysqli_query($conn, $sql);

    $check = mysqli_num_rows($result);

    if ($check > 0) {

        $fetch_expense = mysqli_fetch_assoc($result);
?>

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Personal Information -->
                <form action="" method="POST" id="add_income_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">View Income</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="income_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="income_name" name="income_id" class="form-control" onchange="amount()">
                                                <option value="<?= $fetch_expense['user_id']; ?>"><?= $fetch_expense['username']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="income_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="income_phone" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="income_phone" class="form-control">
                                                <option value="<?= $fetch_expense['Phone']; ?>"><?= $fetch_expense['Phone']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="income_phone_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership" class="form-label">Membership</label>
                                        <div class="input-group">
                                            <select id="membership" name="membership_id" class="form-control">
                                                <option value="<?= $fetch_expense['membership_id']; ?>"><?= $fetch_expense['membership_name']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="membership_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Amount</label>
                                        <div class="input-group">
                                            <select id="amount" name="total_amount" class="form-control">
                                                <option value="<?= $fetch_expense['membership_amount']; ?>"><?= $fetch_expense['membership_amount']; ?></option>
                                            </select>
                                            <select id="membership_validation_days" class="form-control" style="display: none;">
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="amount_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="monthly_date" class="form-label">Membership Start Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" readonly id="monthly_date" name="membership_start_date" class="form-control" placeholder="<?= date('Y-m-d'); ?>" value="<?= $fetch_expense['membership_start_date']; ?>">
                                        <span class="inter error text-danger" id="monthly_date_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_end" class="form-label">Membership End Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="membership_end" name="membership_end" class="form-control">
                                            <option value="<?= $fetch_expense['membership_end_date']; ?>"><?= $fetch_expense['membership_end_date']; ?></option>
                                        </select>
                                        <span class="inter error text-danger" id="membership_end_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="payment_method" name="payment_method" class="form-control">
                                                <option value="<?= $fetch_expense['payment_method']; ?>"><?= $fetch_expense['payment_method']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="payment_method_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3" id="screen_shot_div" style="display: none;">
                                        <label for="screen_shot" class="form-label">ScreenShot
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" id="screen_shot" name="screen_shot" class="form-control">
                                        <span class="inter error text-danger" id="screen_shot_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="pay_fees" class="form-label">Pay Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" readonly id="pay_fees" name="pay_fees" placeholder="3000" class="form-control" value="<?= $fetch_expense['pay_fees']; ?>">
                                        <span class="inter error text-danger" id="pay_fees_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-12 btm-group">
                            <a type="button" href="income-details" class="btn btn-danger text-white">Back</a>
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



<script>
    function toggleFields() {
        var paymentMethod = document.getElementById("payment_method").value;
        var screenShot = document.getElementById("screen_shot_div");

        if (paymentMethod === "Bank Account" || paymentMethod === "Easypaisa" || paymentMethod === "Jazzcash" || paymentMethod === "Sadapay" || paymentMethod === "Nayapay") {
            screenShot.style.display = "block";
        } else {
            screenShot.style.display = "none";
        }


    }
</script>
<script src="../assets/js/custom/addIncomeError.js"></script>
<?php
include_once('./inc/footer.php');
?>