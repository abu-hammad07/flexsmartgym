<?php

session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================== Insert Data into database page (add-member)[save_member] =========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $registration_num = mysqli_real_escape_string($conn, $_POST['registration_num']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $admission_fees = mysqli_real_escape_string($conn, $_POST['admission_fees']);
    $joinning_date = mysqli_real_escape_string($conn, $_POST['joinning_date']);
    $end_date = mysqli_real_escape_string($conn, $_POST['end_date']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // hash password
    $pass = password_hash($password, PASSWORD_DEFAULT);
    // token generate
    $token = bin2hex(random_bytes(50));
    // Get the current date and time
    $created_date = date('Y-m-d');
    // Get the user's ID and name
    $created_by = $_SESSION['username'];

    // check registration_num already exists or not
    $check_registration_num = "SELECT * FROM `users_detail` WHERE `registration_num` = '$registration_num'";
    $check_registration_num_res = mysqli_query($conn, $check_registration_num);
    if (mysqli_num_rows($check_registration_num_res) > 0) {
        $_SESSION['error_message_member'] = "Registration number already exists, ($registration_num)";
        header("location: add-member");
        exit();
    }


    // check duplicate username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username'";
    $check_username_res = mysqli_query($conn, $check_username);

    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_message_member'] = "Username already exists, ($username)";
        header("location: add-member");
        exit();
    } else {
        // check duplicate email
        $check_email = "SELECT * FROM `users` WHERE `email` = '$email'";
        $check_email_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['error_message_member'] = "Email already exists, ($email)";
            header("location: add-member");
            exit();
        } else {
            // Upload image img empty
            $image = '789654-random-profile.png';
            if (!empty($_FILES['image']['name'])) {
                $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
            }
            // $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
            // move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);

            // Insert data into user_details table first
            $insert_details = "INSERT INTO `users_detail`(
                `registration_num`,`full_name`, `phone`, `address`, `gender`, `age`, `city`, `country`, `image`, 
                `admission_fees`, `joining_date`, `end_date`, created_date, created_by
            ) VALUES (
                '$registration_num', '$full_name', '$phone_no', '$address', '$gender', '$age', '$city', '$country', '$image', 
                '$admission_fees', '$joinning_date', '$end_date', '$created_date', '$created_by'
            )";

            $insert_udetails_res = mysqli_query($conn, $insert_details);

            if ($insert_udetails_res) {
                $users_detail_id = mysqli_insert_id($conn); // Get the ID of the inserted user_detail record

                $get_role_id = "SELECT `role_id` FROM `role` WHERE `name` = 'Member'";
                $get_role_id_res = mysqli_query($conn, $get_role_id);
                $row = mysqli_fetch_assoc($get_role_id_res);
                $role_id = $row['role_id'];

                // Insert data into users table with details_id as foreign key
                $insert_user_tbl = "INSERT INTO `users`(
                    `username`, `email`, `password`, `token`, `status`, `role_id`, `users_detail_id`, `created_by`, `created_date`
                ) VALUES (
                    '$username', '$email', '$pass', '$token', 'Active', '$role_id', '$users_detail_id', '$created_by', '$created_date'
                )";

                $insert_user_res = mysqli_query($conn, $insert_user_tbl);
                if ($insert_user_res) {
                    $_SESSION['success_message_member'] = "Member Added Successfully, ($username)";
                    header('location: add-member');
                    exit();
                } else {
                    $_SESSION['error_message_member'] = "Member 'Users' Not Added, ($username)";
                    header('location: add-member');
                    exit();
                }
            } else {
                $_SESSION['error_message_member'] = "Member 'Users_detail' Not Added, ($username)";
                header('location: add-member');
                exit();
            }
        }
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
        <form method="POST" id="add_member_form" enctype="multipart/form-data">
            <div class="col-lg-12">
                <!-- Alert -->
                <?php
                if (isset($_SESSION['success_message_member'])) {
                    echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_message_member'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['success_message_member']);
                }
                if (isset($_SESSION['error_message_member'])) {
                    echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_message_member'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                    unset($_SESSION['error_message_member']);
                }
                ?>
                <!-- / Alert -->
                <div class="card mb-4">
                    <h4 class="card-header">Add Member</h4>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="registration_num" class="form-label">Registration Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="registration_num" name="registration_num" placeholder="123456789" class="form-control">
                                <span class="inter error text-danger" id="erorr_registration_num"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="" class="form-label">Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input class="form-control" type="text" placeholder="Salman" id="full_name" name="full_name" />
                                <span class="inter error text-danger" id="full_name_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="phone_no" class="form-label">Phone Number
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="03xxxxxxxxx">
                                <span class="inter error text-danger" id="phone_no_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="address" class="form-label">Address
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="address" name="address" placeholder="Address" class="form-control">
                                <span class="inter error text-danger" id="address_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="gender" class="form-label">Gender
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <select id="gender" name="gender" class="form-control">
                                        <option value="">---------</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <span class="inter error text-danger" id="gender_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="age" class="form-label">Age
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="age" name="age" placeholder="20" class="form-control">
                                <span class="inter error text-danger" id="age_error"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" id="city" name="city" placeholder="Karachi" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" id="country" name="country" placeholder="Pakistan" class="form-control">
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="admission_fees" class="form-label">Admission Fees
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="admission_fees" name="admission_fees" placeholder="2000" class="form-control">
                                <span class="inter error text-danger" id="erorr_admission_fees"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="joinning_date" class="form-label">Joining & End Date</label>
                                <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                    <input type="date" id="joinning_date" name="joinning_date" placeholder="MM/DD/YYYY" class="form-control" />
                                    <span class="input-group-text">to</span>
                                    <input type="date" id="end_date" name="end_date" placeholder="MM/DD/YYYY" class="form-control" />
                                </div>
                                <span class="inter error text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <h3 class="card-header">Login</h3>
                    <hr class="my-4 mt-0">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-6 col-12 mb-3">
                                <label for="username" class="form-label">Username
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" id="username" name="username" placeholder="Username" class="form-control">
                                <span class="inter error text-danger" id="username_err"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="email" class="form-label">Email
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" id="email" name="email" placeholder="abc@example.com" class="form-control">
                                <span class="inter error text-danger" id="erorr_email"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="password" class="form-label">Password
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" class="form-control" aria-describedby="password">
                                    <span class="input-group-text cursor-pointer" id="toggle_password"><i id="eye_icon" class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="inter error text-danger" id="erorr_password"></span>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="password" class="form-label">Image
                                </label>
                                <div class="input-group">
                                    <input type="file" id="image" name="image" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button  -->
            <div class="row mt-3">
                <div class="col-md-6 col-6 text-start">
                    <a type="button" href="members-details" class="btn btn-danger text-white text-start">Back</a>
                </div>
                <div class="col-md-6 col-6 text-end">
                <button type="submit" class="btn btn-primary" id="save_member" name="save_member">Save</button>
                </div>
            </div>
        </form>


    </div>
</div>
<!-- / Content -->




<script src="../assets/js/custom/addMembersError.js"></script>
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
                    if (type === "subscrip_Data") {
                        $('#subscription').append(data);
                    } else if (type === "membership_amount_Data") {
                        $('#amount').html(data);
                    }
                }
            });
        }

        loadData("subscrip_Data");

        $("#subscription").on("change", function() {
            var department = $("#subscription").val();
            if (department != "") {
                loadData("membership_amount_Data", department);
            } else {
                $('#amount').html("");
                $('#trade_add').html("");
            }
        });


    });
</script>