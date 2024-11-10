<?php
session_start();
include_once('includes/config.php');
include_once('includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Super Admin') {
    // Redirect to login page
    header('location: login');
}

// When the admin login and insert the login time in user_details table in the database
// if (isset($_SESSION['role']) == 'Admin') {
//     $user_id = $_SESSION['UID'];
//     $login_time = date('Y-m-d H:i:s');
//     $query = "UPDATE `user_details` SET `login_time` = '$login_time' WHERE `user_details`.`user_id` = '$user_id'";
//     $result = mysqli_query($conn, $query);
//     if (!$result) {
//         echo "Error: " . $query . "<br>" . mysqli_error($conn);
//     }
// }


?>





<?php
include_once('includes/header.php');
include_once('includes/sidebar.php');
include_once('includes/navbar.php');
?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <!-- Welcome -->
        <div class="col-lg-8 col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <a href="javascript:;" class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <img src="assets/img/avatars/14.png" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="me-2 text-body h5 mb-0 fw-bold">
                                Abu Hammad 🎉
                                <span class="badge bg-label-primary ms-1">Admin</span>
                            </div>
                        </a>
                    </div>
                    <p class="mb-3">Elevate your gym experience with a Gym Management System. Our
                        cutting-edge software simplifies member management, class scheduling, and
                        finances. Experience efficiency and performance analytics at your
                        fingertips. Join the fitness revolution with a Gym Management System!.</p>
                </div>
            </div>
        </div>
        <!-- / welcome -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="row">
                <!-- Member -->
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="card card-border-shadow-primary h-100" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Members">
                        <a href="member-details.html">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-0 pb-1">
                                    <div class="avatar avatar-lg me-2">
                                        <img src="assets/img/members.png" alt="Members">
                                    </div>
                                </div>
                                <h4 class="ms-1 mb-0">42</h4>
                                <p class="mb-1 fs-5 fw-medium text-muted">Members</p>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Member -->
                <!-- Staff  -->
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="card card-border-shadow-warning h-100" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Staff">
                        <a href="staff-details.html">
                            <div class="card-body text-center">
                                <div class="d-flex align-items-center justify-content-center mb-0 pb-1">
                                    <div class="avatar avatar-lg me-2">
                                        <img src="assets/img/staff.png" alt="Staff">
                                    </div>
                                </div>
                                <h4 class="ms-1 mb-0">8</h4>
                                <p class="mb-1 fs-5 fw-medium text-muted">Staff</p>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Staff -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-ld-6 col-md-6">
            <div class="row">
                <!-- Earning -->
                <div class="col-lg-6 col-6 mb-4">
                    <div class="card card-border-shadow-info" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Earning">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class="text-dark">Earning</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2">21,459</h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Earning</p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="assets/img/earning.png" alt="Earning">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Earning -->
                <!-- Profit -->
                <div class="col-lg-6 col-6 mb-4">
                    <div class="card card-border-shadow-danger" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Profit">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class="text-dark">Profit</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2">4,567</h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Profit</p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="assets/img/profit.png" alt="Profit">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="row">
                <!-- Expence -->
                <div class="col-lg-6 col-6 mb-4">
                    <div class="card card-border-shadow-success" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Expense">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class="text-dark">Expense</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2">19,860</h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Expense</p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="assets/img/expence.png" alt="Expence">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- Salary -->
                <div class="col-lg-6 col-6 mb-4">
                    <div class="card card-border-shadow-warning" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" data-bs-original-title="Total Salary">
                        <a href="javascript:void(0)">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left">
                                        <span class="text-dark">Salary</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2">237</h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Salary</p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="assets/img/salary.png" alt="Salary">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="row">

        <!-- Remaining Days Members -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Remaining Days Members</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#membersmodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="membersmodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Members List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Member
                                                    Category</label>
                                                <select id="" class="form-select">
                                                    <option>Select Category</option>
                                                    <option value="Gold Group">Gold Group</option>
                                                    <option value="Platinum Group">Platinum Group
                                                    </option>
                                                    <option value="Silver Group">Silver Group
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="dobWithTitle" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="memberList">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/1.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Gold</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/7.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Silver</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/9.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Platinum</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/2.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Gold</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/3.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Platinum</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/4.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="badge bg-label-primary mb-0">Silver</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Remaining Days Members -->

        <!-- Recently Joining Members -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Recently Joining Members</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#staffmodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="staffmodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Staff List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Staff
                                                    Category</label>
                                                <select id="" class="form-select">
                                                    <option>Select Category</option>
                                                    <option value="Gold Group">Gold Group</option>
                                                    <option value="Platinum Group">Platinum Group
                                                    </option>
                                                    <option value="Silver Group">Silver Group
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="dobWithTitle" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="staffList">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/1.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/7.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/9.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/2.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/3.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/4.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Recently Joining Members -->

        <!-- End Days Members -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">End Days Members</h5>
                    </div>
                    <div class="">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#groupmodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="groupmodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Group List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Group
                                                    Category</label>
                                                <select id="" class="form-select">
                                                    <option>Select Category</option>
                                                    <option value="Gold Group">Gold Group</option>
                                                    <option value="Platinum Group">Platinum Group
                                                    </option>
                                                    <option value="Silver Group">Silver Group
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="dobWithTitle" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="groupList">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/1.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/7.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/9.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/2.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/3.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1 align-items-center">
                            <img src="assets/img/avatars/4.png" alt="Chrome" height="28" class="me-3 rounded">
                            <div class="d-flex w-100 align-items-center gap-2">
                                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                    <div>
                                        <a href="profile.html">
                                            <h6 class="mb-0">Ahmed Khan</h6>
                                        </a>
                                        <small class="text-muted">#161616</small>
                                    </div>

                                    <div class="user-progress d-flex align-items-center gap-2">
                                        <h6 class="mb-0">90.4%</h6>
                                    </div>
                                </div>
                                <div class="chart-progress" data-color="secondary" data-series="85">
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ End Days Members -->
    </div>

</div>
<!-- / Content -->

<?php
include_once('includes/footer.php');
?>