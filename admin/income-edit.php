<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================= Edit Income code page (icnome-edit)[save_income]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // income_id
    // user_id
    // payment_method
    // screen_shot
    // pay_fees
    // remaining_fees
    // pay_remaining_fees
    // remaining_fees_date

    $income_id = mysqli_real_escape_string($conn, $_POST['income_id']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $pay_fees = mysqli_real_escape_string($conn, $_POST['pay_fees']);
    $remaining_fees = mysqli_real_escape_string($conn, $_POST['remaining_fees']);
    $pay_remaining_fees = mysqli_real_escape_string($conn, $_POST['pay_remaining_fees']);

    $username_select = "SELECT username FROM `users` WHERE `user_id` = '$user_id'";
    $username_result = mysqli_query($conn, $username_select);
    $getUsername = mysqli_fetch_assoc($username_result)['username'];


    // remaining fees if remaining fees is -1 then it will be 0
    $remanning_fees2 = $remaining_fees - $pay_remaining_fees;
    if ($remanning_fees2 <= "-1") {
        $remanning_fees2 = 0;
    }

    // check the amount_fees if amount_fees is lees than pay_fees then it will return error message redirect to add-income page
    if ($remaining_fees < $pay_remaining_fees) {
        $_SESSION['error_update_Income'] = "$remaining_fees Amount fees must be greater than pay fees ($pay_remaining_fees)";
        header("location: income-details");
        exit();
    }

    // create date time & username
    $updated_by = $_SESSION['username'];
    $updated_date = date("Y-m-d");
    $remaining_fees_date = date("Y-m-d");

    // check the unique income name & month date if month date is same then it will be unique
    // $check_income = "SELECT * FROM income WHERE user_id = '$user_id' AND monthly_date = '$monthly_date' AND income_id != $income_id";
    // $check_income_res = mysqli_query($conn, $check_income);
    // if (mysqli_num_rows($check_income_res) > 0) {
    //     $_SESSION['error_update_Income'] = "$monthly_date this month fees already exists, please change $monthly_date";
    //     header("location: income-details");
    //     exit();
    // }

    // Check if an image was uploaded
    $screen_shot = '';
    if (!empty($_FILES['screen_shot']['name'])) {
        $screen_shot = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['screen_shot']['name']);
        move_uploaded_file($_FILES['screen_shot']['tmp_name'], '../media/images/' . $screen_shot);
    }

    // Update data into interested table
    $update_income = "UPDATE `income` 
    SET 
        `user_id`='$user_id',
        `pay_fees`='$pay_fees' + $pay_remaining_fees,
        `remaining_fees`='$remanning_fees2',
        `remaining_fees_date`='$remaining_fees_date',
        `updated_by`='$updated_by',
        `updated_date`='$updated_date'";


    if (!empty($screen_shot)) {
        $update_income .= ", `screen_shot` = '$screen_shot'";
    }

    $update_income .= " WHERE `income_id` = $income_id";

    $update_income_res = mysqli_query($conn, $update_income);

    if ($update_income_res) {
        $_SESSION['success_update_Income'] = "Income Updated Successfully, ($getUsername)";
        header("location: income-details");
        exit();
    } else {
        $_SESSION['error_update_Income'] = "This Income Not Updated, ($getUsername)";
        header("location: income-details");
        exit();
    }
}






include_once ('./inc/header.php');
include_once ('./inc/sidebar.php');
include_once ('./inc/navbar.php');



// ======================== Edit fetures code page (add-expensetion)[save_expensetion]  ========================

if (isset($_GET['income_edit_id'])) {

    $edit_expense_id = mysqli_real_escape_string($conn, $_GET['income_edit_id']);

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
                            <h3 class="card-header">Edit Income</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <input type="text" name="income_id" value="<?= $fetch_expense['income_id']; ?>" hidden>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="income_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="income_name" name="user_id" class="form-control" onchange="amount()">
                                                <option value="<?= $fetch_expense['user_id']; ?>">
                                                    <?= $fetch_expense['username']; ?></option>
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
                                                <option value="<?= $fetch_expense['Phone']; ?>"><?= $fetch_expense['Phone']; ?>
                                                </option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="income_phone_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership" class="form-label">Membership</label>
                                        <div class="input-group">
                                            <select id="membership" name="membership_id" class="form-control">
                                                <option value="<?= $fetch_expense['membership_id']; ?>">
                                                    <?= $fetch_expense['membership_name']; ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="membership_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Amount</label>
                                        <div class="input-group">
                                            <select id="amount" name="total_amount" class="form-control">
                                                <option value="<?= $fetch_expense['membership_amount']; ?>">
                                                    <?= $fetch_expense['membership_amount']; ?></option>
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
                                        <input type="date" readonly id="monthly_date" name="membership_start_date"
                                            class="form-control" placeholder="<?= date('Y-m-d'); ?>"
                                            value="<?= $fetch_expense['membership_start_date']; ?>">
                                        <span class="inter error text-danger" id="monthly_date_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_end" class="form-label">Membership End Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="membership_end" name="membership_end" class="form-control">
                                            <option value="<?= $fetch_expense['membership_end_date']; ?>">
                                                <?= $fetch_expense['membership_end_date']; ?></option>
                                        </select>
                                        <!-- <input type="date" id="membership_end" name="membership_end" class="form-control"> -->
                                        <span class="inter error text-danger" id="membership_end_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="payment_method" class="form-label">Payment Method
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="payment_method" name="payment_method" class="form-control"
                                                onchange="toggleFields()">
                                                <option value="<?= $fetch_expense['payment_method']; ?>">
                                                    <?= $fetch_expense['payment_method']; ?></option>
                                                <option value="Cash" <?php if ($fetch_expense['payment_method'] == 'Cash')
                                                    echo 'selected'; ?>>Cash Amount</option>
                                                <option value="Bank Account" <?php if ($fetch_expense['payment_method'] == 'Bank Account')
                                                    echo 'selected'; ?>>Bank Account</option>
                                                <option value="Easypaisa" <?php if ($fetch_expense['payment_method'] == 'Easypaisa')
                                                    echo 'selected'; ?>>
                                                    Easypaisa</option>
                                                <option value="Jazzcash" <?php if ($fetch_expense['payment_method'] == 'Jazzcash')
                                                    echo 'selected'; ?>>Jazzcash</option>
                                                <option value="Sadapay" <?php if ($fetch_expense['payment_method'] == 'Sadapay')
                                                    echo 'selected'; ?>>Sadapay</option>
                                                <option value="Nayapay" <?php if ($fetch_expense['payment_method'] == 'Nayapay')
                                                    echo 'selected'; ?>>Nayapay</option>
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
                                        <input type="text" id="pay_fees" readonly name="pay_fees" placeholder="3000"
                                            class="form-control" value="<?= $fetch_expense['pay_fees']; ?>">
                                        <span class="inter error text-danger" id="pay_fees_error"></span>
                                    </div>
                                    <?php
                                    if ($fetch_expense['remaining_fees'] != 0) {
                                        ?>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="remaining_fees" class="form-label">Remaining Fees
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="remaining_fees" readonly name="remaining_fees" placeholder="3000"
                                                class="form-control" value="<?= $fetch_expense['remaining_fees']; ?>">
                                            <span class="inter error text-danger" id="remaining_fees_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="pay_remaining_fees" class="form-label">Pay Remaining Fees
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="pay_remaining_fees" name="pay_remaining_fees" placeholder="3000"
                                                class="form-control">
                                            <span class="inter error text-danger" id="pay_remaining_fees_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="remaining_fees_date" class="form-label">Remaining Fees Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="remaining_fees_date" name="remaining_fees_date"
                                                placeholder="3000" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                            <span class="inter error text-danger" id="remaining_fees_date_error"></span>
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
                        </div>
                    </div>
                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 text-start">
                            <a type="button" href="income-details" class="btn btn-danger text-white">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                            <button type="submit" class="btn btn-primary" name="save_expense">Update</button>
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
include_once ('./inc/footer.php');
?>