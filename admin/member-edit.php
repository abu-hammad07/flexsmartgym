<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================== Update Member User Details page (member-edit)[update_member]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $users_detail_id = mysqli_real_escape_string($conn, $_POST['users_detail_id']);
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

    // Get the current date and time
    $updated_date = date('Y-m-d');
    // Get the user's ID and name
    $updated_by = $_SESSION['username'];

    // check registration_num already exists or not
    $check_registration_num = "SELECT * FROM `users_detail` WHERE `registration_num` = '$registration_num' AND `users_detail_id` != '$users_detail_id'";
    $check_registration_num_res = mysqli_query($conn, $check_registration_num);
    if (mysqli_num_rows($check_registration_num_res) > 0) {
        $_SESSION['error_update_member'] = "Registration number already exists, ($registration_num)";
        header("location: members-details");
        exit();
    }


    // check duplicate username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$user_id'";
    $check_username_res = mysqli_query($conn, $check_username);

    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_update_member'] = "Username already exists, ($username)";
        header("location: members-details");
        exit();
    } else {
        // check duplicate email
        $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$user_id'";
        $check_email_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['error_update_member'] = "Email already exists, ($email)";
            header("location: members-details");
            exit();
        } else {

            // Check if an image was uploaded
            $image = '';
            if (!empty($_FILES['image']['name'])) {
                $image = mysqli_real_escape_string($conn, rand(111111111, 999999999) . '_' . $_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], '../media/images/' . $image);
            }

            // Update users table
            $update_user_query = "UPDATE `users`
        SET
            `username` = '$username',
            `email` = '$email',
            `updated_date` = '$updated_date',
            `updated_by` = '$updated_by'
        WHERE `user_id` = $user_id";
            $update_user_res = mysqli_query($conn, $update_user_query);

            if ($update_user_res) {
                // Update user_details table
                $update_details_query = "UPDATE `users_detail`
            SET 
                `registration_num` = '$registration_num',
                `full_name` = '$full_name', 
                `phone` = '$phone_no', 
                `address` = '$address', 
                `gender` = '$gender', 
                `age` = '$age', 
                `city` = '$city', 
                `country` = '$country',
                `admission_fees` = '$admission_fees',
                `joining_date` = '$joinning_date',
                `end_date` = '$end_date',
                `updated_date` = '$updated_date',
                `updated_by` = '$updated_by'";
                // Append image update if an image was uploaded
                if (!empty($image)) {
                    $update_details_query .= ", `image` = '$image'";
                }
                $update_details_query .= " WHERE `users_detail_id` = $users_detail_id";

                // Perform the update query
                $update_details_res = mysqli_query($conn, $update_details_query);

                if ($update_details_res) {
                    $_SESSION['update_message_member'] = "Member Updated Successfully, ($username)";
                    header('location: members-details');
                    exit();
                } else {
                    $_SESSION['error_update_member'] = "Member 'Users_detail' not updated, ($username)";
                    header('location: members-details');
                    exit();
                }
            } else {
                $_SESSION['error_update_member'] = "Member 'Users' not updated. ($username)";
                header('location: members-details');
                exit();
            }
        }
    }
}



// Get the user ID from the URL
if (isset($_GET['edit_member'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_member']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.*, users_detail.*,
    membership.membership_id, membership.membership_name, membership.membership_amount,
    role.role_id, role.name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id 
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE users.user_id = '$edit_id';");

    $check = mysqli_num_rows($select_query);

    if ($check > 0) {
        $fetch_member = mysqli_fetch_assoc($select_query);


        include_once ('./inc/header.php');
        include_once ('./inc/sidebar.php');
        include_once ('./inc/navbar.php');
        ?>

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">



                <!-- Personal Information -->
                <form method="POST" id="add_member_form" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">Edit Member</h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <input class="form-control" type="text" hidden name="user_id"
                                        value="<?= $fetch_member['user_id'] ?>" />
                                    <input class="form-control" type="text" hidden name="users_detail_id"
                                        value="<?= $fetch_member['users_detail_id'] ?>" />
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="registration_num" class="form-label">Registration Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="registration_num" name="registration_num" placeholder="123456789"
                                            class="form-control" value="<?= $fetch_member['registration_num'] ?>">
                                        <span class="inter error text-danger" id="erorr_registration_num"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Salman" id="full_name"
                                            name="full_name" value="<?= $fetch_member['full_name'] ?>" />
                                        <span class="inter error text-danger" id="full_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone_no" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="phone_no" name="phone_no" class="form-control"
                                            placeholder="03xxxxxxxxx" value="<?= $fetch_member['Phone'] ?>">
                                        <span class="inter error text-danger" id="phone_no_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="address" class="form-label">Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="address" name="address" placeholder="Address"
                                            class="form-control" value="<?= $fetch_member['address'] ?>">
                                        <span class="inter error text-danger" id="address_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="gender" class="form-label">Gender
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="gender" name="gender" class="form-control">
                                                <option value="<?= $fetch_member['gender'] ?>"><?= $fetch_member['gender'] ?>
                                                </option>
                                                <option value="Male" <?php if ($fetch_member['gender'] == 'Male') {
                                                    echo 'hidden';
                                                } ?>>Male</option>
                                                <option value="Female" <?php if ($fetch_member['gender'] == 'Female') {
                                                    echo 'hidden';
                                                } ?>>Female</option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="gender_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="age" class="form-label">Age
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="age" name="age" placeholder="20" class="form-control"
                                            value="<?= $fetch_member['age'] ?>">
                                        <span class="inter error text-danger" id="age_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" id="city" name="city" placeholder="Karachi" class="form-control"
                                            value="<?= $fetch_member['city'] ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" id="country" name="country" placeholder="Pakistan"
                                            class="form-control" value="<?= $fetch_member['country'] ?>">
                                    </div>
                                    <!-- <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Memberchip
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="subscription" name="membership_id" class="form-control">
                                                <option value="<?= $fetch_member['membership_id'] ?>"><?= $fetch_member['membership_name'] ?></option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="subscription_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Amount</label>
                                        <div class="input-group">
                                            <select id="amount" name="amount" class="form-control">
                                                <option value="<?= $fetch_member['membership_amount'] ?>"><?= $fetch_member['membership_amount'] ?></option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="admission_fees" class="form-label">Admission Fees
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="admission_fees" name="admission_fees" placeholder="2000"
                                            class="form-control" value="<?= $fetch_member['admission_fees'] ?>">
                                        <span class="inter error text-danger" id="erorr_admission_fees"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="joinning_date" class="form-label">Joining & End Date</label>
                                        <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                            <input type="date" id="joinning_date" name="joinning_date" placeholder="MM/DD/YYYY"
                                                class="form-control" value="<?= $fetch_member['joining_date'] ?>" />
                                            <span class="input-group-text">to</span>
                                            <input type="date" id="end_date" name="end_date" placeholder="MM/DD/YYYY"
                                                class="form-control" value="<?= $fetch_member['end_date'] ?>" />
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
                                        <input type="text" id="username" name="username" placeholder="Username"
                                            class="form-control" value="<?= $fetch_member['username'] ?>">
                                        <span class="inter error text-danger" id="username_err"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email" class="form-label">Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" placeholder="abc@example.com"
                                            class="form-control" value="<?= $fetch_member['email'] ?>">
                                        <span class="inter error text-danger" id="erorr_email"></span>
                                    </div>
                                    <!-- <div class="col-md-6 col-12 mb-3">
                                        <label for="password" class="form-label">Password
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" readonly id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" class="form-control" aria-describedby="password" value="<?= $fetch_member['password'] ?>">
                                            <span class="input-group-text cursor-pointer" id="toggle_password"><i id="eye_icon" class="ti ti-eye-off"></i></span>
                                        </div>
                                        <span class="inter error text-danger" id="erorr_password"></span>
                                    </div> -->
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
                        <button type="submit" class="btn btn-primary" id="update_member"
                                name="update_member">Update</button>
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




<!-- <script src="../assets/js/custom/addMembersError.js"></script> -->
<?php
include_once ('./inc/footer.php');
?>

<script>
    $(document).ready(function () {
        function loadData(type, id) {
            $.ajax({
                url: 'ajex.php',
                type: 'POST',
                data: {
                    type: type,
                    id: id
                },
                dataType: 'html',
                success: function (data) {
                    if (type === "subscription_Data") {
                        $('#subscription').append(data);
                    } else if (type === "amount_Data") {
                        $('#amount').html(data);
                    } else if (type === "amount_Data") {
                        $('#amount').html(data);
                    }
                }
            });
        }

        loadData("subscription_Data");

        $("#subscription").on("change", function () {
            var department = $("#subscription").val();
            if (department != "") {
                loadData("amount_Data", department);
            } else {
                $('#amount').html("");
                $('#trade_add').html("");
            }
        });

        $("#subscription").on("change", function () {
            var department = $("#subscription").val();
            if (department != "") {
                loadData("amount_Data", department);
            } else {
                $('#amount').html("");
                $('#trade_add').html("");
            }
        });

    });
</script>