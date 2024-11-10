<?php

session_start();
include_once ('../includes/config.php');
include_once ('../includes/functions.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================== Update Admin User Details page (admin-edit)[update_admin]  ========================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $users_detail_id = mysqli_real_escape_string($conn, $_POST['users_detail_id']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Get the current date and time
    $updated_date = date('Y-m-d');
    // Get the user's ID and name
    $updated_by = $_SESSION['username'];


    // check duplicate username
    $check_username = "SELECT * FROM `users` WHERE `username` = '$username' AND `user_id` != '$user_id'";
    $check_username_res = mysqli_query($conn, $check_username);

    if (mysqli_num_rows($check_username_res) > 0) {
        $_SESSION['error_update_admin'] = "Username already exists";
        header("location: admin-details");
        exit();
    } else {
        // check duplicate email
        $check_email = "SELECT * FROM `users` WHERE `email` = '$email' AND `user_id` != '$user_id'";
        $check_email_res = mysqli_query($conn, $check_email);

        if (mysqli_num_rows($check_email_res) > 0) {
            $_SESSION['error_update_admin'] = "Email already exists";
            header("location: admin-details");
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
                `full_name` = '$full_name', 
                `phone` = '$phone_no', 
                `address` = '$address', 
                `gender` = '$gender', 
                `age` = '$age', 
                `city` = '$city', 
                `country` = '$country',
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
                    $_SESSION['success_update_admin'] = "Admin Updated Successfully, ($username).";
                    header('location: admin-details');
                    exit();
                } else {
                    $_SESSION['error_update_admin'] = "Admin 'Users_detail' not updated. ($username).";
                    header('location: admin-details');
                    exit();
                }
            } else {
                $_SESSION['error_update_admin'] = "Admin 'Users' not updated. ($username).";
                header('location: admin-details');
                exit();
            }
        }
    }
}


if (isset($_GET['edit_admin'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit_admin']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.user_id, users.username, users.email, users.password,
    users_detail.users_detail_id, users_detail.full_name, users_detail.Phone, users_detail.address, users_detail.gender, 
    users_detail.age, users_detail.city, users_detail.country, users_detail.image, users_detail.created_date,
    role.role_id, role.name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE users.user_id = '$edit_id';
    ");

    $check = mysqli_num_rows($select_query);

    if ($check > 0) {
        $fetch_admin = mysqli_fetch_assoc($select_query);


        include_once ('./inc/header.php');
        include_once ('./inc/sidebar.php');
        include_once ('./inc/navbar.php');
        ?>

        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">



                <!-- Personal Information -->
                <form method="POST" id="adminForm" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <!-- Alert -->
                        <?php
                        if (isset($_SESSION['success_message_admin'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        ' . $_SESSION['success_message_admin'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                            unset($_SESSION['success_message_admin']);
                        }
                        if (isset($_SESSION['error_message_admin'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ' . $_SESSION['error_message_admin'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                            unset($_SESSION['error_message_admin']);
                        }
                        ?>
                        <!-- / Alert -->
                        <div class="card mb-4">
                            <h3 class="card-header">Edit Admin</h3>
                            <!-- <hr class="my-4 mt-0"> -->
                            <div class="card-body">
                                <div class="row g-2">
                                    <input class="form-control" type="text" hidden name="user_id"
                                        value="<?= $fetch_admin['user_id']; ?>" />
                                    <input class="form-control" type="text" hidden name="users_detail_id"
                                        value="<?= $fetch_admin['users_detail_id']; ?>" />
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="" class="form-label">Full Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" placeholder="Full Name" id="full_name"
                                            name="full_name" value="<?= $fetch_admin['full_name']; ?>" />
                                        <span class="inter error text-danger" id="full_name_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone_no" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="phone_no" name="phone_no" class="form-control"
                                            placeholder="Phone Number" value="<?= $fetch_admin['Phone']; ?>">
                                        <span class="inter error text-danger" id="phone_no_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="address" class="form-label">Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="address" name="address" placeholder="Address"
                                            class="form-control" value="<?= $fetch_admin['address']; ?>">
                                        <span class="inter error text-danger" id="erorr_address"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="gender" class="form-label">Gender
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="gender" name="gender" class="form-control">
                                                <option value="<?= $fetch_admin['gender']; ?>"><?= $fetch_admin['gender']; ?>
                                                </option>
                                                <option value="Male" <?php echo ($fetch_admin['gender'] == 'Male') ? 'hidden' : ''; ?>>Male</option>
                                                <option value="Female" <?php echo ($fetch_admin['gender'] == 'Female') ? 'hidden' : ''; ?>>Female</option>
                                            </select>
                                        </div>
                                        <span class="inter error text-danger" id="gender_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="age" class="form-label">Age
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="age" name="age" placeholder="Age" class="form-control"
                                            value="<?= $fetch_admin['age']; ?>">
                                        <span class="inter error text-danger" id="age_error"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" id="city" name="city" placeholder="City" class="form-control"
                                            value="<?= $fetch_admin['city']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" id="country" name="country" placeholder="Country"
                                            class="form-control" value="<?= $fetch_admin['country']; ?>">
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
                                            class="form-control" value="<?= $fetch_admin['username']; ?>">
                                        <span class="inter error text-danger" id="username_err"></span>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email" class="form-label">Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" placeholder="abc@example.com"
                                            class="form-control" value="<?= $fetch_admin['email']; ?>">
                                        <span class="inter error text-danger" id="erorr_email"></span>
                                    </div>
                                    <!-- <div class="col-md-6 col-12 mb-3">
                                        <label for="password" class="form-label">Password
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <input type="password" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" class="form-control" aria-describedby="password" value="<?= $fetch_admin['password']; ?>">
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
                            <a type="button" href="admin-details" class="btn btn-danger text-white">Back</a>
                        </div>
                        <div class="col-md-6 col-6 text-end">
                            <button type="submit" class="btn btn-primary" name="update_admin">Update</button>
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




<script src="../assets/js/custom/empty-error.js"></script>
<?php
include_once ('./inc/footer.php');
?>