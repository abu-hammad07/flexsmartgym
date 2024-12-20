<?php

session_start();
// config file
include "includes/config.php";


// <!-- =========================Forget Password page code =============================== -->

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/PHPMailer/src/Exception.php';
require 'includes/PHPMailer/src/PHPMailer.php';
require 'includes/PHPMailer/src/SMTP.php';



if (isset($_POST['forget-pass'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  if (empty($email)) {
    $errors['empty_email'] = 'Please Enter Email';
  }

  if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['input'] = $_POST;
    header("location: forgot-password");
    exit();
  } else {

    $email_query = "SELECT * FROM `users` WHERE `email` = '$email' AND `status` = 'Active'";
    $email_query_run = mysqli_query($conn, $email_query);

    $count_email = mysqli_num_rows($email_query_run);
    if ($count_email) {
      $userData = mysqli_fetch_array($email_query_run);
      $user_name = $userData['username'];
      $user_token = $userData['token'];
      $_SESSION['user_email'] = $userData['email'];

      $mail = new PHPMailer(true);
      try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hammadking427@gmail.com';
        $mail->Password = 'gtohfmaaanqufdbn';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('hammadking427@gmail.com', 'Abu_Hammad');
        $mail->addAddress($email, $user_name);
        $mail->Subject = 'Password Reset';
        // Include the email content from email.php
        include('email_Reset.php');
        // Replace placeholders with actual values
        $emailContent = str_replace('$user_name', $user_name, $emailContent);
        $emailContent = str_replace('$user_token', $user_token, $emailContent);
        // Set the email content as HTML
        $mail->isHTML(true);
        $mail->Body = $emailContent;
        $mail->send();
        unset($_SESSION['input']);
        header('location: verify-email');
        $_SESSION['reset_msg'] =  $email;
        exit();
      } catch (Exception $e) {
        echo "Failed to send email. Error: {$mail->ErrorInfo}";
      }
    } else {
      unset($_SESSION['input']);
      header('location: forgot-password');
      $_SESSION['reset_msg'] = "Enter valid email";
      exit();
    }
  }
}






?>






<!DOCTYPE html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Forgot Password</title>
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 5" />
  <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="assets/img/favicon-1.png" />
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;ampdisplay=swap" rel="stylesheet">
  <!-- Icons -->
  <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />
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

  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/loader.css">


</head>

<body>

  <!-- Content -->

  <div class="authentication-wrapper authentication-cover authentication-bg">
    <div class="authentication-inner row">

      <!-- /Left Text -->
      <div class="d-none d-lg-flex col-lg-7 p-0">
        <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
          <img src="assets/img/illustrations/auth-forgot-password-illustration-light.png" alt="auth-forgot-password-cover" class="img-fluid my-5 auth-illustration" data-app-light-img="illustrations/auth-forgot-password-illustration-light.png" data-app-dark-img="illustrations/auth-forgot-password-illustration-dark.html">

          <img src="assets/img/illustrations/bg-shape-image-light.png" alt="auth-forgot-password-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.html">
        </div>
      </div>
      <!-- /Left Text -->

      <!-- Forgot Password -->
      <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
        <div class="w-px-400 mx-auto">
          <!-- Logo -->
          <div class="app-brand mb-4">
            <a href="index.html" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                  <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
                </svg>
              </span>
            </a>
          </div>
          <!-- /Logo -->
          <h3 class="mb-1">Forgot Password? 🔒</h3>
          <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
          <form id="" class="mb-3" action="" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus>
              <span class="inter error text-danger"><?php if (isset($_SESSION['errors']['empty_email'])) {
                                                      echo $_SESSION['errors']['empty_email'];
                                                      unset($_SESSION['errors']['empty_email']);
                                                    } ?></span>
              <span class="inter error text-danger">
                <?php
                if (isset($_SESSION['reset_msg'])) {
                  echo $_SESSION['reset_msg'] . '! Check your email & reset password.';
                  unset($_SESSION['reset_msg']);
                }
                ?>
              </span>
            </div>
            <button class="btn btn-primary d-grid w-100" name="forget-pass">Send Reset Link</button>
          </form>
          <div class="text-center">
            <a href="login" class="d-flex align-items-center justify-content-center">
              <i class="ti ti-chevron-left scaleX-n1-rtl"></i>Back to login</a>
          </div>
        </div>
      </div>
      <!-- /Forgot Password -->
    </div>
  </div>

  <!-- / Content -->

  <!-- Loader -->
  <div class="loader"></div>


  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
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

  <!-- Custom JS -->
  <script src="assets/js/loader.js"></script>


</body>

</html>