<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================== Add fetures code page (add-subscription)[save_subscription]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escape user inputs
    $membership_name = mysqli_real_escape_string($conn, $_POST['membership_name']);
    $membership_amount = mysqli_real_escape_string($conn, $_POST['membership_amount']);
    $validation_days = mysqli_real_escape_string($conn, $_POST['validation_days']);
    $membership_status = mysqli_real_escape_string($conn, $_POST['membership_status']);
    $membership_description = mysqli_real_escape_string($conn, $_POST['membership_description']);

    // Get current date and user info
    $created_date = date('Y-m-d');
    $created_by = $_SESSION['username'];

    // Check for duplicate subscription name
    $check_membership_name = "SELECT * FROM `membership` WHERE `membership_name` = '$membership_name'";
    $check_membership_name_res = mysqli_query($conn, $check_membership_name);

    if (mysqli_num_rows($check_membership_name_res) > 0) {
        $_SESSION['error_message_subscrip'] = "Membership name already exists, please change $membership_name";
        header("location: add-membership");
        exit();
    } else {

        // Insert data into subscription table
        $insert_subscription = "INSERT INTO `membership`(
        `membership_name`, `membership_amount`, `validation_days`, `membership_status`, `membership_description`, `created_by`, `created_date`) 
        VALUES ('$membership_name', '$membership_amount', '$validation_days', '$membership_status', '$membership_description', '$created_by', '$created_date')";

        $insert_subscription_res = mysqli_query($conn, $insert_subscription);
        if ($insert_subscription_res) {
            // If loop completes without errors, redirect with success message
            $_SESSION['success_message_subscrip'] = "Membership Added Successfully, ($membership_name)";
            header("location: add-membership");
            exit();
        } else {
            $_SESSION['error_message_subscrip'] = "Error: " . mysqli_error($conn);
            header("location: add-membership");
            exit();
        }
    }
}


include_once ('./inc/header.php');
include_once ('./inc/sidebar.php');
include_once ('./inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">



        <!-- Personal Information -->
        <form action="" method="POST" id="add_subscrip_form" enctype="multipart/form-data">
            <div class="col-lg-12">
                <!-- Alert -->
                <?php
                if (isset($_SESSION['success_message_subscrip'])) {
                    echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_subscrip'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['success_message_subscrip']);
                }
                if (isset($_SESSION['error_message_subscrip'])) {
                    echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_subscrip'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['error_message_subscrip']);
                }
                ?>
                <div class="card mb-4">
                    <h4 class="card-header">Add Membership</h4>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership_name" class="form-label">Membership Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" placeholder="Membership Name"
                                    id="membership_name" name="membership_name" />
                                <span class="inter error text-danger" id="membership_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership_amount" class="form-label">Membership Amount
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" placeholder="Membership Amount"
                                    id="membership_amount" name="membership_amount" />
                                <span class="inter error text-danger" id="membership_amount_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="validation_days" class="form-label">Validation days
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" placeholder="Validation days"
                                    id="validation_days" name="validation_days" />
                                <span class="inter error text-danger" id="validation_days_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership_status" class="form-label">Status
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="membership_status" id="membership_status"
                                    class="form-control form-select">
                                    <option value="">-------</option>
                                    <option value="Active">Active</option>
                                    <option value="Deactive">Deactive</option>
                                </select>
                                <span class="inter error text-danger" id="membership_status_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="membership_description" class="form-label">Description</label>
                                <textarea name="membership_description" id="membership_description" class="form-control"
                                    cols="10" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Submit Button  -->
            <div class="row mt-3">
                <div class="col-md-6 col-6 text-start">
                    <a type="button" href="admin-details" class="btn btn-danger text-white text-start">Back</a>
                </div>
                <div class="col-md-6 col-6 text-end">
                    <button type="submit" class="btn btn-primary " id="save_membership"
                        name="save_membership">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->




<script src="../assets/js/custom/addSubscriptionError.js"></script>
<?php
include_once ('./inc/footer.php');
?>