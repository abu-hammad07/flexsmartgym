<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================= Edit Attendence code page (attendence-edit)[update_attendence]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $attend_id = mysqli_real_escape_string($conn, $_POST['attend_id']);
    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $attend_date = mysqli_real_escape_string($conn, $_POST['attend_date']);
    $attend_status = mysqli_real_escape_string($conn, $_POST['attend_status']);

    // Get username
    $username_select = "SELECT username FROM `users` WHERE `user_id` = '$users_id'";
    $username_result = mysqli_query($conn, $username_select);
    $getUsername = mysqli_fetch_assoc($username_result)['username'];

    // check if attendence already exists
    $check_attendence = "SELECT * FROM `attendence` WHERE `users_id` = '$users_id' AND `attend_date` = '$attend_date' AND `attend_id` != '$attend_id'";
    $check_attendence_res = mysqli_query($conn, $check_attendence);
    if (mysqli_num_rows($check_attendence_res) > 0) {
        $_SESSION['error_update_attendence'] = "$getUsername '$attend_date' This day attendence already exists, please change '$attend_date'";
        header("location: attendence-details");
        exit();
    }

    // create date time & username
    $updated_by = $_SESSION['username'];
    $updated_date = date("Y-m-d h:i:sa");

    // Insert data into interested table
    $insert_attendence = "UPDATE `attendence` 
    SET 
        `users_id`='$users_id',
        `attend_date`='$attend_date',
        `attend_status`='$attend_status',
        `updated_by`='$updated_by',
        `updated_date`='$updated_date'
    WHERE `attend_id` = '$attend_id'";

    $insert_attendence_res = mysqli_query($conn, $insert_attendence);

    if ($insert_attendence_res) {
        $_SESSION['success_update_attendence'] = "Attendence Updated Successfully, $getUsername ($attend_status at $attend_date)";
        header("location: attendence-details");
        exit();
    } else {
        $_SESSION['error_update_attendence'] = "Failed to Update Attendence $getUsername.";
        header("location: attendence-details");
        exit();
    }
}


include_once ('./inc/header.php');
include_once ('./inc/sidebar.php');
include_once ('./inc/navbar.php');


if (isset($_GET['edit_attend_id'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_attend_id']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.username, users_detail.Phone, role.name as role, 
    attendence.attend_id, attendence.attend_status, attendence.attend_date, attendence.users_id
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
                            <h3 class="card-header">Edit Attendence</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <input type="text" id="attend_id" hidden name="attend_id" class="form-control"
                                        value="<?= $fetch_attend['attend_id']; ?>">
                                    <input type="text" id="users_id" hidden name="users_id" class="form-control"
                                        value="<?= $fetch_attend['users_id']; ?>">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_name" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select id="attend_name" name="attend_name" class="form-control">
                                            <option value="<?= $fetch_attend['username'] ?>"><?= $fetch_attend['username'] ?>
                                            </option>
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
                                        <span class="inter error text-danger" id="attend_phone_error"></span>
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
                                        <input type="date" id="attend_date" name="attend_date" placeholder="Attendence Date"
                                            class="form-control" value="<?= $fetch_attend['attend_date']; ?>">
                                        <span class="inter error text-danger" id="attend_date_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="attend_status" class="form-label">Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="attend_status" name="attend_status" class="form-control">
                                                <option value="<?= $fetch_attend['attend_status'] ?>">
                                                    <?= $fetch_attend['attend_status'] ?></option>
                                                <option value="Present" <?= $fetch_attend['attend_status'] === 'Present' ? 'hidden' : '' ?>>Present</option>
                                                <option value="Absent" <?= $fetch_attend['attend_status'] === 'Absent' ? 'hidden' : '' ?>>Absent</option>
                                                <option value="Leave" <?= $fetch_attend['attend_status'] === 'Leave' ? 'hidden' : '' ?>>Leave</option>
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
                        </div>
                    </div>
                    <!-- Submit Button  -->
                    <div class="row mt-3">
                        <div class="col-md-6 col-6 text-start">
                            <a type="button" href="attendence-details" class="btn btn-danger text-white">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                            <button type="submit" class="btn btn-primary" name="update_attendence">Update</button>
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
include_once ('./inc/footer.php');
?>