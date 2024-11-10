<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================== Add Attendence code page (add-attendence)[save_attendence]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $users_id = mysqli_real_escape_string($conn, $_POST['users_id']);
    $attend_date = mysqli_real_escape_string($conn, $_POST['attend_date']);
    $attend_status = mysqli_real_escape_string($conn, $_POST['attend_status']);

    // Create date time & username
    $created_by = $_SESSION['username'];
    $created_date = date("Y-m-d");

    // Get username
    $username_select = "SELECT username FROM `users` WHERE `user_id` = '$users_id'";
    $username_result = mysqli_query($conn, $username_select);
    $getUsername = mysqli_fetch_assoc($username_result)['username'];

    // check if attendence already exists
    $check_attendence = "SELECT * FROM `attendence` WHERE `users_id` = '$users_id' AND `attend_date` = '$attend_date'";
    $check_attendence_res = mysqli_query($conn, $check_attendence);
    if (mysqli_num_rows($check_attendence_res) > 0) {
        $_SESSION['error_message_attendence'] = "Attendence Already Exists, ($getUsername) please change '$attend_date', ";
        header("location: add-attendence");
        exit();
    }

    // Insert data into attendance table
    $insert_attendance = "INSERT INTO `attendence` (
        `users_id`, `attend_date`, `attend_status`, `created_by`, `created_date`
        )
    VALUES (
        '$users_id','$attend_date', '$attend_status', '$created_by', '$created_date'
        )";

    $insert_attendance_res = mysqli_query($conn, $insert_attendance);

    if ($insert_attendance_res) {
        $_SESSION['success_message_attendence'] = "Attendance Added Successfully, $getUsername ($attend_status at $attend_date)";
        header("location: add-attendence");
        exit();
    } else {
        $_SESSION['error_message_attendence'] = "Attendance Not Added $users_id";
        header("location: add-attendence");
        exit();
    }
}



include_once('./inc/header.php');
include_once('./inc/sidebar.php');
include_once('./inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">



        <!-- Personal Information -->
        <form action="" method="POST" id="add_attendence_form" enctype="multipart/form-data">
            <div class="col-lg-12">
                <!-- Alert -->
                <?php
                if (isset($_SESSION['success_message_attendence'])) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . $_SESSION['success_message_attendence'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    unset($_SESSION['success_message_attendence']);
                }
                if (isset($_SESSION['error_message_attendence'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ' . $_SESSION['error_message_attendence'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    unset($_SESSION['error_message_attendence']);
                }
                ?>
                <!-- / Alert -->
                <div class="card mb-4">
                    <h4 class="card-header">Add Attendence</h4>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="attend_name" class="form-label">Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="attend_name" name="users_id" class="form-control">
                                    <option value="">---------</option>
                                </select>
                                <span class="inter error text-danger" id="attend_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="attend_phone" class="form-label">Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="attend_phone" class="form-control">
                                </select>
                                <span class="inter error text-danger" id="attend_phone_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="attend_role" class="form-label">Role Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select id="attend_role" name="attend_role" class="form-control">
                                </select>
                                <span class="inter error text-danger" id="attend_role_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="attend_date" class="form-label">Attendence Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="attend_date" name="attend_date" placeholder="Attendence Date" class="form-control" value="<?= date('Y-m-d'); ?>">
                                <span class="inter error text-danger" id="attend_date_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="attend_status" class="form-label">Status
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select id="attend_status" name="attend_status" class="form-control">
                                        <option value="">---------</option>
                                        <option value="Present">Present</option>
                                        <option value="Absent">Absent</option>
                                        <option value="Leave">Leave</option>
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
                <div class="col-md-6 col-6 text-start">
                    <a type="button" href="attendence-details" class="btn btn-danger text-white text-start">Back</a>
                </div>
                <div class="col-md-6 col-6 text-end">
                    <button type="submit" class="btn btn-primary" name="save_staff">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->




<script src="../assets/js/custom/addAttendenceError.js"></script>
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
                    if (type === "attend_name_Data") {
                        $('#attend_name').append(data);
                    } else if (type === "attend_phone_Data") {
                        $('#attend_phone').html(data);
                    } else if (type === "attend_role_Data") {
                        $('#attend_role').html(data);
                    }
                }
            });
        }

        loadData("attend_name_Data");

        $("#attend_name").on("change", function() {
            var attendData = $("#attend_name").val();
            if (attendData != "") {
                loadData("attend_phone_Data", attendData);
            } else {
                $('#attend_phone').html("");
            }
        });

        $("#attend_name").on("change", function() {
            var attendData = $("#attend_name").val();
            if (attendData != "") {
                loadData("attend_role_Data", attendData);
            } else {
                $('#attend_role').html("");
            }
        });

    });
</script>