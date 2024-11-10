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


if (isset($_GET['view_attend'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['view_attend']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.username, users_detail.Phone, role.name as role, 
    attendence.attend_id, attendence.attend_status, attendence.attend_date 
    FROM `attendence`
    INNER JOIN users ON users.user_id = attendence.users_id
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    INNER JOIN role ON role.role_id = users.role_id
    WHERE `attend_id` = '$edit_id'");

    $check = mysqli_num_rows($select_query);

    if ($check > 0) {
        $fetch_attend = mysqli_fetch_assoc($select_query);


?>

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">



                <!-- Personal Information -->
                <form action="" method="POST" id="add_attendence_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">View Attendence</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <input type="text" id="attend_id" hidden name="attend_id" class="form-control" value="<?= $fetch_attend['attend_id']; ?>">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="attend_name" name="attend_name" class="form-control">
                                            <option value="<?= $fetch_attend['username'] ?>"><?= $fetch_attend['username'] ?></option>
                                        </select>
                                        <span class="inter error text-danger" id="attend_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_phone" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="attend_phone" name="attend_phone" class="form-control">
                                            <option value="<?= $fetch_attend['Phone'] ?>"><?= $fetch_attend['Phone'] ?></option>
                                        </select>
                                        <!-- <span class="inter error text-danger" id="attend_phone_error"></span> -->
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_role" class="form-label">Role Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="attend_role" name="attend_role" class="form-control">
                                            <option value="<?= $fetch_attend['role'] ?>"><?= $fetch_attend['role'] ?></option>
                                        </select>
                                        <span class="inter error text-danger" id="attend_role_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_date" class="form-label">Attendence Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" readonly id="attend_date" name="attend_date" placeholder="Attendence Date" class="form-control" value="<?= $fetch_attend['attend_date']; ?>">
                                        <span class="inter error text-danger" id="attend_date_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_status" class="form-label">Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="attend_status" readonly name="attend_status" class="form-control">
                                                <option value="<?= $fetch_attend['attend_status'] ?>"><?= $fetch_attend['attend_status'] ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="attend_status_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-12 btm-group">
                            <a type="button" href="attendence-details" class="btn btn-danger text-white">Back</a>
                        </div>
                    </div>
                </form>


            </div>
        </div>
        <!-- / Content -->
<?php
    }
}
?>




<script src="../assets/js/custom/addAttendenceError.js"></script>
<?php
include_once('./inc/footer.php');
?>