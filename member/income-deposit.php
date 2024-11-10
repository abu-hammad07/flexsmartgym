<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Member') {
    // Redirect to login page
    header('location: ../login');
}



// ======================= Add Deposit code page (icnome-deposit)[save_income]  ========================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $income_id = mysqli_real_escape_string($conn, $_POST['income_id']);
    $membership_id = mysqli_real_escape_string($conn, $_POST['membership_id']);
    $membership_start_date = mysqli_real_escape_string($conn, $_POST['membership_start_date']);
    $membership_end_date = mysqli_real_escape_string($conn, $_POST['membership_end']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $total_amount = mysqli_real_escape_string($conn, $_POST['total_amount']);
    $pay_fees = mysqli_real_escape_string($conn, $_POST['pay_fees']);

    // Get username
    $username_select = "SELECT username FROM `users` WHERE `user_id` = '$income_id'";
    $username_result = mysqli_query($conn, $username_select);
    $getUsername = mysqli_fetch_assoc($username_result)['username'];

    // Calculate remaining fees
    $remaining_fees = $total_amount - $pay_fees;
    if ($remaining_fees <= -1) {
        $remaining_fees = 0;
    }

    // check the amount_fees if amount_fees is lees than pay_fees then it will return error message redirect to add-income page
    if ($total_amount < $pay_fees) {
        $_SESSION['error_message_income'] = "($total_amount)Amount fees must be greater than pay fees ($pay_fees)";
        header("location: income-deposit");
        exit();
    }

    // check agr end_date current date sy end hu gya hy tp update hu jana chaye 
    // $chech = "SELECT membership_end_date FROM membership_details WHERE user_id = '$income_id' AND membership_end_date = '$membership_end_date'";
    // if ($membership_end_date < date('Y-m-d')) {
    //     $membership_end_date = date('Y-m-d');
    //     // update date
    //     $updated_date = date('Y-m-d');
    //     // update membership_details table
    //     $update_membership_details = "UPDATE membership_details 
    // SET user_id = '$income_id', membership_id = '$membership_id', membership_start_date = '$membership_start_date', membership_end_date = '$membership_end_date',
    // updated_by = '{$_SESSION['username']}', updated_date = '$updated_date'
    // WHERE user_id = '$income_id'";
    //     mysqli_query($conn, $update_membership_details);

    //     if (mysqli_affected_rows($conn) > 0) {
    //         $_SESSION['success_message_income'] = "$user_id updated successfully";
    //         header("location: add-income.php");
    //         exit();
    //     }
    // } else {

    // Check the start_date and end_date is already exists or not
    $check_income_query = "SELECT membership_start_date, membership_end_date 
    FROM membership_details 
    WHERE user_id = '$income_id' AND membership_start_date = '$membership_start_date' AND membership_end_date = '$membership_end_date'";
    $check_income_result = mysqli_query($conn, $check_income_query);
    if (mysqli_num_rows($check_income_result) > 0) {
        $_SESSION['error_message_income'] = "$monthly_date Income for this month already exists. Please choose a different month. ";
        header("location: income-deposit");
        exit();
    }

    // Get the current date
    $created_date = date('Y-m-d');
    // Monthly date
    $monthly_date = date('Y-m-d');

    // Upload image
    $screen_shot = rand(111111111, 999999999) . '_' . $_FILES['screen_shot']['name'];
    move_uploaded_file($_FILES['screen_shot']['tmp_name'], '../media/images/' . $screen_shot);

    // insert query income table
    $income_sql = "INSERT INTO income (`user_id`, pay_fees, pay_fees_date, remaining_fees, payment_method, trx_image, status, created_by, created_date)
    VALUES ($income_id, '$pay_fees', '$monthly_date',  '$remaining_fees', '$payment_method', '$screen_shot', 'Pending', '{$_SESSION['username']}', '$created_date')";

    if (mysqli_query($conn, $income_sql)) {

        // insert query membership_details table
        $membership_details = "INSERT INTO `membership_details`(`user_id`, `membership_id`, `membership_start_date`, `membership_end_date`, `created_by`, `created_date`
    ) VALUES ('$income_id', '$membership_id', '$membership_start_date', '$membership_end_date', '{$_SESSION['username']}', '$created_date')";

        if (mysqli_query($conn, $membership_details)) {

            // update query users_detail table
            $check_users = "SELECT users_detail.users_detail_id FROM users 
            LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
            WHERE users.user_id = $income_id";
            $check_users_result = mysqli_query($conn, $check_users);

            if (mysqli_num_rows($check_users_result) > 0) {
                $row = mysqli_fetch_assoc($check_users_result);

                $users_detail_id = $row['users_detail_id'];

                // update query users_detail table
                $update_users_detail = "UPDATE users_detail SET membership_id = '$membership_id' WHERE users_detail_id = $users_detail_id";
            }
            if (mysqli_query($conn, $update_users_detail)) {

                $_SESSION['success_message_income'] = "Income Deposit Successfully, ($getUsername)";
                header("location: income-deposit");
                exit();
            } else {
                $_SESSION['error_message_income'] = "This ($getUsername) has not been Deposit";
                header("location: income-deposit");
                exit();
            }
        }
    }
}
// }

include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');

?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_message_income'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            ' . $_SESSION['success_message_income'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['success_message_income']);
    }
    if (isset($_SESSION['error_message_income'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $_SESSION['error_message_income'] . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['error_message_income']);
    }
    ?>
    <!-- / Alert -->


    <div class="row">
        <!-- Personal Information -->
        <form action="" method="POST" id="add_income_form" enctype="multipart/form-data">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <h3 class="card-header">Add Deposit</h3>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="income_name" class="form-label">Username
                                    <span class="text-danger">*</span>
                                </label>
                                <?php
                                $select_query = "SELECT user_id, username FROM users WHERE user_id = '" . $_SESSION['UID'] . "'";
                                $select_query_result = mysqli_query($conn, $select_query);
                                $row = mysqli_fetch_assoc($select_query_result);
                                ?>
                                <div class="input-group">
                                    <select id="income_name" name="income_id" class="form-control">
                                        <option value="<?php echo $row['user_id'] ?>"><?= $row['username'] ?></option>
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="income_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership" class="form-label">Membership</label>
                                <div class="input-group">
                                    <select id="membership" name="membership_id" class="form-control">
                                        <option value="">---------</option>
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="membership_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="country" class="form-label">Amount</label>
                                <div class="input-group">
                                    <select id="amount" name="total_amount" class="form-control">
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
                                <input type="date" id="monthly_date" name="membership_start_date" class="form-control" placeholder="<?= date('Y-m-d'); ?>">
                                <span class="inter error text-danger" id="monthly_date_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership_end" class="form-label">Membership End Date
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="membership_end" name="membership_end" class="form-control">
                                    <option value="">Please select a membership start date.</option>
                                </select>
                                <!-- <input type="date" id="membership_end" name="membership_end" class="form-control"> -->
                                <span class="inter error text-danger" id="membership_end_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="payment_method" class="form-label">Payment Method
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select id="payment_method" name="payment_method" class="form-control" onchange="toggleFields()">
                                        <option value="">---------</option>
                                        <option value="Bank Account">Bank Account</option>
                                        <option value="Easypaisa">Easypaisa</option>
                                        <option value="Jazzcash">Jazzcash</option>
                                        <option value="Sadapay">Sadapay</option>
                                        <option value="Nayapay">Nayapay</option>
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
                                <input type="text" id="pay_fees" name="pay_fees" placeholder="3000" class="form-control" onchange="pay_fees()">
                                <span class="inter error text-danger" id="pay_fees_error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button  -->
            <div class="row mt-3">
                <div class="col-12 btm-group">
                    <button type="submit" class="btn btn-primary" name="save_income">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->


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
                    if (type === "membership_Data") {
                        $('#membership').append(data);
                    } else if (type === "amount_Data") {
                        $('#amount').html(data);
                    } else if (type === "membership_validation_days") {
                        $('#membership_validation_days').html(data);
                    }
                }
            });
        }

        loadData("membership_Data");

        $("#membership").on("change", function() {
            var membership = $("#membership").val();
            if (membership != "") {
                loadData("amount_Data", membership);
            } else {
                $('#amount').html("");
            }
        });
        $("#membership").on("change", function() {
            var membership = $("#membership").val();
            if (membership != "") {
                loadData("membership_validation_days", membership);
            } else {
                $('#membership_validation_days').html("");
            }
        });

        $("#monthly_date").on("change", function() {
            var days = parseInt($("#membership_validation_days").val());
            var startDate = new Date($("#monthly_date").val());

            if (!isNaN(days) && !isNaN(startDate.getTime())) {
                var futureDate = new Date(startDate);
                futureDate.setDate(startDate.getDate() + days);

                var formattedDate = futureDate.getFullYear() + '/' + ('0' + (futureDate.getMonth() + 1)).slice(-2) + '/' + ('0' + futureDate.getDate()).slice(-2);
                $('#membership_end').html("<option value='" + formattedDate + "'>" + formattedDate + "</option>");
            } else {
                $('#membership_end').html("<option value=''>Please enter valid days and starting date.</option>");
            }
        });





    });
</script>