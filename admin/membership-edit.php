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
    $subscrip_id = mysqli_real_escape_string($conn, $_POST['subscrip_id']);
    $membership_name = mysqli_real_escape_string($conn, $_POST['membership_name']);
    $membership_amount = mysqli_real_escape_string($conn, $_POST['membership_amount']);
    $validation_days = mysqli_real_escape_string($conn, $_POST['validation_days']);
    $membership_status = mysqli_real_escape_string($conn, $_POST['membership_status']);
    $membership_description = mysqli_real_escape_string($conn, $_POST['membership_description']);

    // Get current date and user info
    $updated_date = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['username'];

    // Check for duplicate subscription name
    $check_membership_name = "SELECT * FROM `membership` WHERE `membership_name` = '$membership_name' AND `membership_id` != '$subscrip_id'";
    $check_membership_name_res = mysqli_query($conn, $check_membership_name);

    if (mysqli_num_rows($check_membership_name_res) > 0) {
        $_SESSION['error_update_subscrip'] = "Membership name already exists, please change $membership_name";
        header("location: membership-details");
        exit();
    } else {
        // Update data in subscription table
        $update_subscription = "UPDATE `membership` SET 
        `membership_name`='$membership_name', 
        `membership_amount`='$membership_amount',
        `validation_days`='$validation_days',
        `membership_status`='$membership_status',
        `membership_description`='$membership_description', 
        `updated_by`='$updated_by', `updated_date`='$updated_date' 
        WHERE `membership_id` = '$subscrip_id'";

        $update_subscription_res = mysqli_query($conn, $update_subscription);

        // Update data in feture_details table
        if ($update_subscription_res) {
            // If loop completes without errors, redirect with success message
            $_SESSION['success_update_subscrip'] = "Membership Updated Successfully, ($membership_name)";
            header("location: membership-details");
            exit();
        } else {
            $_SESSION['error_update_subscrip'] = "Failed to update membership ($membership_name)";
            header("location: membership-details");
            exit();
        }
    }
}





include_once ('./inc/header.php');
include_once ('./inc/sidebar.php');
include_once ('./inc/navbar.php');



// ======================== Edit fetures code page (add-Membership)[save_Membership]  ========================
if (isset($_GET['edit_membership_id'])) {

    $edit_subscrip_id = mysqli_real_escape_string($conn, $_GET['edit_membership_id']);

    // Fetch the details of the membership being edited
    $sql = "SELECT * FROM `membership` WHERE membership_id  = '$edit_subscrip_id'";
    $result = mysqli_query($conn, $sql);

    $check = mysqli_num_rows($result);

    if ($check > 0) {
        $fetch_subscrip = mysqli_fetch_assoc($result);



        ?>

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <!-- Personal Information -->
                <form action="" method="POST" id="add_subscrip_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">Edit Membership</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_name" class="form-label">Membership Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" hidden type="text" id="subscrip_id" name="subscrip_id"
                                            value="<?= $fetch_subscrip['membership_id']; ?>" />
                                        <input class="form-control" type="text" placeholder="Membership Name"
                                            id="membership_name" name="membership_name"
                                            value="<?= $fetch_subscrip['membership_name']; ?>" />
                                        <span class="inter error text-danger" id="membership_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_amount" class="form-label">Membership Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Membership Amount"
                                            id="membership_amount" name="membership_amount"
                                            value="<?= $fetch_subscrip['membership_amount']; ?>" />
                                        <span class="inter error text-danger" id="membership_amount_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="validation_days" class="form-label">Validation days
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Validation days"
                                            id="validation_days" name="validation_days"
                                            value="<?= $fetch_subscrip['validation_days']; ?>" />
                                        <span class="inter error text-danger" id="validation_days_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_status" class="form-label">Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="membership_status" id="membership_status"
                                            class="form-control form-select">
                                            <option value="Active" <?php if ($fetch_subscrip['membership_status'] == 'Active') { ?> selected <?php } ?>>Active</option>
                                            <option value="Deactive" <?php if ($fetch_subscrip['membership_status'] == 'Deactive') { ?> selected <?php } ?>>Deactive</option>
                                        </select>
                                        <span class="inter error text-danger" id="membership_status_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_description" class="form-label">Description</label>
                                        <textarea name="membership_description" id="membership_description" class="form-control"
                                            cols="10" rows="5"><?= $fetch_subscrip['membership_description']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 text-start">
                            <a type="button" href="membership-details" class="btn btn-danger text-white">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                            <button type="submit" class="btn btn-primary" id="update_Membership"
                                name="update_Membership">Update</button>
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
include_once ('./inc/footer.php');
?>