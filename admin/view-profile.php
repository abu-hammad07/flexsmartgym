<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');


if (isset($_GET['view_profile_id'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['view_profile_id']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.*, users_detail.*,
    membership.membership_id, membership.membership_name, membership.membership_amount,
    role.role_id, role.name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id 
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE users.user_id = '$edit_id';
    ");

    $check = mysqli_num_rows($select_query);

    if ($check > 0) {
        $fetch_member = mysqli_fetch_assoc($select_query);
        $_SESSION['memberViewData'] = $fetch_member['user_id'];
        $dateWise = date('d-F-Y', strtotime($fetch_member['joining_date']));


?>


        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="user-profile-header-banner">
                            <img src="../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top">
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                <img src="../media/images/<?= $fetch_member['image'] ?>" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded-circle user-profile-img">
                            </div>
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4><?= $fetch_member['full_name'] ?></h4>
                                        <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-user'></i> <?= $fetch_member['name'] ?>
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-map-pin'></i>
                                                <?= $fetch_member['city'] . ', ' . $fetch_member['country'] ?>
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-calendar'></i> Joined <?= $dateWise ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->

            <!-- Default Wizard -->
            <div class="col-12 mb-4">
                <div class="bs-stepper wizard-numbered mt-2">
                    <div class="bs-stepper-header">
                        <div class="step" data-target="#account-details">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="ti ti-user-scan"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Profile</span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i class="ti ti-chevron-right"></i>
                        </div>
                        <div class="step" data-target="#personal-info">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="ti ti-calendar-month"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Attendence </span>
                                </span>
                            </button>
                        </div>
                        <div class="line">
                            <i class="ti ti-chevron-right"></i>
                        </div>
                        <div class="step" data-target="#member-deposit">
                            <button type="button" class="step-trigger">
                                <span class="bs-stepper-circle">
                                    <i class="ti ti-businessplan"></i>
                                </span>
                                <span class="bs-stepper-label">
                                    <span class="bs-stepper-title">Deposit History</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="bs-stepper-content">
                        <form onSubmit="return false">
                            <!-- Profile -->
                            <div id="account-details" class="content">
                                    <div class="row g-2">
                                        <!-- <input type="text" hidden name="" class="form-control" value="<?php //$fetch_member['user_id']; ?>"> -->
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="registration_num" class="form-label">Registration Number</label>
                                            <input type="text" readonly id="registration_num" name="registration_num" class="form-control" value="<?= $fetch_member['registration_num'] ?>">
                                            <span class="inter error text-danger" id="erorr_registration_num"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="" class="form-label">Name</label>
                                            <input readonly class="form-control" type="text" id="full_name" name="full_name" value="<?= $fetch_member['full_name']; ?>" />
                                            <span class="inter error text-danger" id="full_name_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="phone_no" class="form-label">Phone Number</label>
                                            <input readonly type="text" id="phone_no" name="phone_no" class="form-control" value="<?= $fetch_member['Phone'] ?>">
                                            <span class="inter error text-danger" id="phone_no_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input readonly type="text" id="address" name="address" class="form-control" value="<?= $fetch_member['address']; ?>">
                                            <span class="inter error text-danger" id="address_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <input readonly type="text" class="form-control" id="gender" name="gender" value="<?= $fetch_member['gender']; ?>">
                                            <span class="inter error text-danger" id="gender_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input readonly type="text" id="age" name="age" class="form-control" value="<?= $fetch_member['age'] ?>">
                                            <span class="inter error text-danger" id="age_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" id="city" name="city" class="form-control" value="<?= $fetch_member['city']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <input readonly type="text" id="country" name="country" class="form-control" value="<?= $fetch_member['country']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="country" class="form-label">Membership Name</label>
                                            <input readonly type="text" id="country" name="country" class="form-control" value="<?= $fetch_member['membership_name']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="country" class="form-label">Membership Amount</label>
                                            <input readonly type="text" id="country" name="country" class="form-control" value="<?= $fetch_member['membership_amount']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="admission_fees" class="form-label">Admission Fees</label>
                                            <input readonly type="text" id="admission_fees" name="admission_fees" placeholder="2000" class="form-control" value="<?= $fetch_member['admission_fees']; ?>">
                                            <span class="inter error text-danger" id="erorr_admission_fees"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="joinning_date" class="form-label">Joining & End Date</label>
                                            <div class="input-group input-daterange" id="bs-datepicker-daterange">
                                                <input readonly type="date" id="joinning_date" name="joinning_date" placeholder="MM/DD/YYYY" class="form-control" value="<?= $fetch_member['joining_date']; ?>" />
                                                <span class="input-group-text">to</span>
                                                <input readonly type="date" id="end_date" name="end_date" placeholder="MM/DD/YYYY" class="form-control" value="<?= $fetch_member['end_date']; ?>" />
                                            </div>
                                            <span class="inter error text-danger"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="username" class="form-label">Username
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="username" readonly name="username" placeholder="Username" class="form-control" value="<?= $fetch_member['username']; ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="email" class="form-label">Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" id="email" name="email" readonly placeholder="abc@example.com" class="form-control" value="<?= $fetch_member['email']; ?>">
                                        </div>
                                    </div>
                            </div>
                            <!-- Attendence -->
                            <div id="personal-info" class="content">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h4 class="card-header">Attendence</h4>
                                    </div>
                                    <div class="col-md-6 text-end card-header">
                                        <div class="btn-group">
                                            <div class="me-2">
                                                <input type="date" id="member_attendence-date" class="form-control" onchange="load_member_attendence_Data()">
                                            </div>
                                            <div class="div">
                                                <select id="member_attendence-limit" class="form-select" onchange="load_member_attendence_Data()">
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="div">
                                                <select id="member_attendence-order" class="form-select" onchange="load_member_attendence_Data()">
                                                    <option value="ASC">Old</option>
                                                    <option value="DESC">New</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Day</th>
                                                    <th>Status</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0" id="memberAttendenceDetails">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Attendence -->
                            <!-- Deposit -->
                            <div id="member-deposit" class="content">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h4 class="card-header">Deposit History</h4>
                                    </div>
                                    <div class="col-md-6 text-end card-header">
                                        <div class="btn-group">
                                            <div class="me-2">
                                                <input type="month" id="member_deposit-date" class="form-control" onchange="load_member_deposit_Data()">
                                            </div>
                                            <div class="div">
                                                <select id="member_deposit-limit" class="form-select" onchange="load_member_deposit_Data()">
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="div">
                                                <select id="member_deposit-order" class="form-select" onchange="load_member_deposit_Data()">
                                                    <option value="ASC">Old</option>
                                                    <option value="DESC">New</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Pay Date</th>
                                                    <th>Day</th>
                                                    <th>Total</th>
                                                    <th>Pay</th>
                                                    <th>Remaining</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody class="table-border-bottom-0" id="memberDepositDetails">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Default Wizard -->

            <!-- Submit Button  -->
            <!-- <div class="row">
                <div class="col-12 btm-group">
                    <a type="button" href="members-details" class="btn btn-danger text-white">Back</a>
                </div>
            </div> -->



        </div>
        <!-- / Content -->
<?php
    }
}
?>
<script src="../assets/js/custom/addMembersError.js"></script>

<?php
include_once('inc/footer.php');
?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_member_attendence_Data();
    });

    function load_member_attendence_Data() {
        let memberAttendenceDate = document.getElementById('member_attendence-date').value;
        let memberAttendenceLimited = $("#member_attendence-limit").val();
        let memberAttendenceOrder = $("#member_attendence-order").val();



        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-member_attendence-Data',
                memberAttendenceDate: memberAttendenceDate,
                memberAttendenceLimited: memberAttendenceLimited,
                memberAttendenceOrder: memberAttendenceOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#memberAttendenceDetails").html(response.data);
            },
        });
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_member_deposit_Data();
    });

    function load_member_deposit_Data() {
        let memberDepositDate = $("#member_deposit-date").val();
        let memberDepositLimited = $("#member_deposit-limit").val();
        let memberDepositOrder = $("#member_deposit-order").val();



        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-member_view_deposit-Data',
                memberDepositDate: memberDepositDate,
                memberDepositLimited: memberDepositLimited,
                memberDepositOrder: memberDepositOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#memberDepositDetails").html(response.data);
            },
        });
    }
</script>