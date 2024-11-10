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


// ======================== Edit fetures code page (add-Membership)[save_Membership]  ========================
if (isset($_GET['view_membership_id'])) {

    $view_subscrip = mysqli_real_escape_string($conn, $_GET['view_membership_id']);

    // Fetch the details of the Membership being edited
    $sql = "SELECT * FROM `membership` WHERE membership_id  = '$view_subscrip'";
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
                            <h3 class="card-header">View Membership</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="subscrip_name" class="form-label">Membership Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" hidden type="text" id="subscrip_id" name="subscrip_id" value="<?= $fetch_subscrip['membership_id']; ?>" />
                                        <input class="form-control" readonly type="text" placeholder="Membership Name" id="subscrip_name" name="subscrip_name" value="<?= $fetch_subscrip['membership_name']; ?>" />
                                        <span class="inter error text-danger" id="subscrip_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="subscrip_amount" class="form-label">Membership Amount
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" readonly type="text" placeholder="Membership Amount" id="subscrip_amount" name="subscrip_amount" value="<?= $fetch_subscrip['membership_amount']; ?>" />
                                        <span class="inter error text-danger" id="subscrip_amount_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="validation_days" class="form-label">Validation days
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" readonly type="text" placeholder="Validation days" id="validation_days" name="validation_days" value="<?= $fetch_subscrip['validation_days']; ?>" />
                                        <span class="inter error text-danger" id="validation_days_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_status" class="form-label">Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="membership_status" id="membership_status"
                                            class="form-control form-select">
                                            <option value="<?= $fetch_subscrip['membership_status']; ?>"><?= $fetch_subscrip['membership_status']; ?></option>
                                        </select>
                                        <span class="inter error text-danger" id="membership_status_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="membership_description" class="form-label">Description</label>
                                        <textarea readonly name="membership_description" id="membership_description" class="form-control"
                                            cols="10" rows="5"><?= $fetch_subscrip['membership_description']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-12 btm-group">
                            <!-- <button type="submit" disabled class="btn btn-primary" id="update_Membership" name="update_Membership">Update</button> -->
                            <a type="button" href="Membership-details" class="btn btn-danger text-white">Back</a>
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



<script src="../assets/js/custom/addMembershipError.js"></script>
<?php
include_once('./inc/footer.php');
?>