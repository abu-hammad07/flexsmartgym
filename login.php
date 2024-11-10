<?php
session_start();
include "includes/config.php";
include "includes/functions.php";

// Check if the signIn form is submitted
if (isset($_POST['signIn'])) {
    // Escape user inputs to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['email-username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Initialize an empty array to store error messages
    $errors = array();

    // Check if username or email is empty
    if (empty($username) || empty($password)) {
        // Display error message
        if (empty($username)) {
            $errors['empty_email'] = "Please fill email or username";
        }
        if (empty($password)) {
            $errors['empty_password'] = "Please fill password";
        }
    }

    // Redirect to login page with error message if there are errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location: login');
        exit();
    } else {
        // SQL query to select user with provided username/email and active status
        $login_query = "SELECT user_id, username, email, users.users_detail_id, role.name AS role, users.password FROM users
        LEFT JOIN role ON role.role_id = users.role_id WHERE (username = '$username' OR email = '$username') AND users.status = 'Active'";

        // Execute the query
        $login_result = mysqli_query($conn, $login_query);

        // Check if any row is returned
        if (mysqli_num_rows($login_result) > 0) {
            // Fetch user data
            $row = mysqli_fetch_assoc($login_result);
            // Retrieve hashed password from database
            $db_pass = $row['password'];

            // Verify entered password with hashed password
            $pass_decode = password_verify($password, $db_pass);

            // If passwords match
            if ($pass_decode) {
                // Store user data in session variables
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['UID'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['details_id'] = $row['users_detail_id'];

                // If remember me is checked, set cookies
                if (isset($_POST['rememberme'])) {
                    setcookie('emailcookie', $username, time() + 86400);
                    setcookie('passwordcookie', $password, time() + 86400);
                }

                // Redirect based on user role
                if ($_SESSION['role'] == 'Admin') {
                    header('location: admin/index');
                } elseif ($_SESSION['role'] == 'Member') {
                    header('location: member/index');
                } else {
                    // Handle unknown role
                    header('location: index');
                }
                $_SESSION['login'] = true;
                exit(); // Terminate script execution after redirection
            } else {
                // Incorrect password
                $_SESSION['incorrect_password'] = "Incorrect Password";
            }
        } else {
            // Incorrect email/username
            $_SESSION['incorrect_credentials'] = "Incorrect Email/Username";
        }

        // Redirect to login page with error message
        header('location: login');
        exit();
    }
}






?>



<!DOCTYPE html>
<html lang="en" class="light-style layout-wide  customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>


    <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://1.envato.market/vuexy_admin">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon-1.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="assets/vendor/libs/%40form-validation/umd/styles/index.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css">

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>

    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/loader.css">


</head>

<body>


    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand d-flex justify-content-center mb-4 mt-2">
                            <a href="index" class="text-center">
                                <!-- <img src="assets/img/logo/flexsmartgym.png" alt="" width="25%"> -->
                                <!-- <span class="app-brand-text demo text-body fw-bold ms-1">Flex Smart Gym</span> -->
                            </a>
                        </div>

                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Welcome to Flex Smart Gym ! 👋</h4>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>
                        <!-- Display error messages -->
                        <?php 
                        if (isset($_SESSION['msg'])) {
                            echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                                        ' . $_SESSION['msg'] . '
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>';
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <!-- /Display error messages -->
                        <form id="" class="mb-3" action="" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="text" class="form-control" id="email" name="email-username" placeholder="Enter your email or username" autofocus>
                                <span class="inter error text-danger"><?php if (isset($_SESSION['errors']['empty_email'])) {
                                                                            echo $_SESSION['errors']['empty_email'];
                                                                            unset($_SESSION['errors']['empty_email']);
                                                                        } ?></span>
                                <span class="inter error text-danger"><?php if (isset($_SESSION['incorrect_credentials'])) {
                                                                            echo $_SESSION['incorrect_credentials'];
                                                                            unset($_SESSION['incorrect_credentials']);
                                                                        } ?></span>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="forgot-password">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                <span class="inter error text-danger"><?php if (isset($_SESSION['errors']['empty_password'])) {
                                                                            echo $_SESSION['errors']['empty_password'];
                                                                            unset($_SESSION['errors']['empty_password']);
                                                                        } ?></span>
                                <span class="error text-danger"><?php if (isset($_SESSION['incorrect_password'])) {
                                                                    echo $_SESSION['incorrect_password'];
                                                                    unset($_SESSION['incorrect_password']);
                                                                } ?></span>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="rememberme">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" name="signIn">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Loader -->
    <div class="loader"></div>




    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- Custom JS -->
    <script src="assets/js/loader.js"></script>

    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/libs/hammer/hammer.js"></script>
    <script src="assets/vendor/libs/i18n/i18n.js"></script>
    <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/%40form-validation/umd/bundle/popular.min.js"></script>
    <script src="assets/vendor/libs/%40form-validation/umd/plugin-bootstrap5/index.min.js"></script>
    <script src="assets/vendor/libs/%40form-validation/umd/plugin-auto-focus/index.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>


    <!-- Page JS -->
    <script src="assets/js/pages-auth.js"></script>



</body>

</html>