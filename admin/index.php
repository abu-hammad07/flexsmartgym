<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: login');
}

// When the users login and insert the login time in users_detail table in the database
if (isset($_SESSION['role']) == 'Admin') {
    $details_id = $_SESSION['details_id'];

    // login time 
    $query = "UPDATE `users_detail` SET `login_time` = NOW() 
    WHERE `users_detail`.`users_detail_id` = '$details_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

// Get admin details
$query = "SELECT * FROM users_detail
WHERE `users_detail_id` = '{$_SESSION['details_id']}'";
$result = mysqli_query($conn, $query);
$admin_details = mysqli_fetch_assoc($result);
$adminFullName = $admin_details['full_name'];
$adminImage = $admin_details['image'];


include_once('./inc/header.php');
include_once('./inc/sidebar.php');
include_once('./inc/navbar.php');
?>

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row">
        <!-- Welcome -->
        <div class="col-lg-8 col-12 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <a href="profile" class="d-flex align-items-center">
                            <div class="avatar me-2">
                                <img src="../media/images/<?= $adminImage; ?>" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="me-2 text-body h5 mb-0 fw-bold">
                                <?= $adminFullName; ?> 🎉
                                <span class="badge bg-label-primary ms-1"><?php echo $_SESSION['role']; ?></span>
                            </div>
                        </a>
                    </div>
                    <p class="mb-3">Elevate your gym experience with a Gym Management System. Our
                        cutting-edge software simplifies member management, class scheduling, and
                        finances. Experience efficiency and performance analytics at your
                        fingertips.</p>
                </div>
            </div>
        </div>
        <!-- / welcome -->
        <div class="col-lg-4 col-12 mb-4">
            <div class="row">
                <!-- Member -->
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="card card-border-shadow-primary h-100">
                        <a href="members-details">
                            <div class="card-body text-center" id="card1">
                                <div class="d-flex align-items-center justify-content-center mb-0 pb-1">
                                    <div class="avatar avatar-lg me-2">
                                        <img src="../assets/img/admin-members.png" alt="Members">
                                    </div>
                                </div>
                                <h4 class="ms-1 mb-0 counter"><?php echo get_Count_members() ?></h4>
                                <p class="mb-1 fs-5 fw-medium text-muted">Members</p>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Member -->
                <!-- Staff  -->
                <div class="col-lg-6 col-md-6 col-6">
                    <div class="card card-border-shadow-warning h-100">
                        <a href="staff-details">
                            <div class="card-body text-center" id="card2">
                                <div class="d-flex align-items-center justify-content-center mb-0 pb-1">
                                    <div class="avatar avatar-lg me-2">
                                        <img src="../assets/img/admin-staff.png" alt="Staff">
                                    </div>
                                </div>
                                <h4 class="ms-1 mb-0 counter"><?php echo get_Count_staff() ?></h4>
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
        <div class="col-lg-8 col-md-6">
            <div class="row">
                <!-- Income -->
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card card-border-shadow-info">
                        <a href="income-details" data-bs-toggle="modal" data-bs-target="#incomeModal" aria-haspopup="true" aria-expanded="false">
                            <div class="card-body" id="card3">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left" id="total_income">
                                        <span class="text-dark">Income</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2 counter"><?php echo get_total_combined_income() ?></h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Income <span class="text-danger"><?= date('F') ?></span></p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="../assets/img/income.png" alt="Income">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Income -->
                <!-- Income Modal -->
                <div class="modal fade" id="incomeModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Month Wise Income
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-0">
                                        <label for="dobWithTitle" class="form-label">Month</label>
                                        <input type="month" id="search-income_month" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="search-btn" onclick="search_month_wise_income()" data-bs-dismiss="modal">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Income Model -->
                <!-- Expence -->
                <div class="col-lg-6 col-12 mb-4">
                    <div class="card card-border-shadow-success">
                        <a href="expense-details" data-bs-toggle="modal" data-bs-target="#expenseModal" aria-haspopup="true" aria-expanded="false">
                            <div class="card-body" id="card4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left" id="total_expense">
                                        <span class="text-dark">Expense</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2 counter"><?php echo get_total_expense() ?></h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Expense <span class="text-danger"><?= date('F') ?></span></p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="../assets/img/admin-expense.png" alt="Expence">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Expence -->
                <!-- Expense Modal -->
                <div class="modal fade" id="expenseModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Month Wise Expense
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-0">
                                        <label for="dobWithTitle" class="form-label">Month</label>
                                        <input type="month" id="search-expense_month" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="search-btn" onclick="search_month_wise_expense()" data-bs-dismiss="modal">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Expense Model -->
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="row">
                <!-- Salary -->
                <div class="col-lg-12 col-12 mb-4">
                    <div class="card card-border-shadow-warning">
                        <a href="salary" data-bs-toggle="modal" data-bs-target="#salaryModal" aria-haspopup="true" aria-expanded="false">
                            <div class="card-body" id="card5">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="content-left" id="total_salary">
                                        <span class="text-dark">Salary</span>
                                        <div class="d-flex align-items-center my-2">
                                            <h3 class="mb-0 me-2 counter"><?php echo get_total_salary()
                                                                            ?></h3>
                                        </div>
                                        <p class="mb-0 text-muted">Total Salary <span class="text-danger"><?= date('F') ?></span></p>
                                    </div>
                                    <div class="avatar avatar-xl">
                                        <img src="../assets/img/admin-salary.png" alt="Salary">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- / Salary -->
                <!-- Salary Modal -->
                <div class="modal fade" id="salaryModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Month Wise Income
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-0">
                                        <label for="dobWithTitle" class="form-label">Month</label>
                                        <input type="month" id="search-salary_month" class="form-control" value="<?php echo date('Y-m'); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="search-btn" onclick="search_month_wise_salary()" data-bs-dismiss="modal">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Salary Model -->
            </div>
        </div>
    </div>

    <div class="row">
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
                                        <h5 class="modal-title" id="modalCenterTitle">Recently Joining List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Membership</label>
                                                <select id="membership-recently_days" class="form-select">
                                                    <option value="All">All</option>
                                                    <?php
                                                    $sql = "SELECT membership_id, membership_name FROM `membership`";
                                                    $res = mysqli_query($conn, $sql);

                                                    if (mysqli_num_rows($res) > 0) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                                            <option value='<?= $row['membership_id'] ?>'><?= $row['membership_name'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="membership-recently_joining-month" class="form-control" value="<?php echo date('Y-m') ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="recentlyPaginationLimit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Joining Days</label>
                                                <select class="form-select" id="recentlyValidationDays">
                                                    <option value="10">10</option>
                                                    <option value="25">15</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="searching_recently_joining()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="staffList">
                    <ul class="p-0 m-0" id="recentlyJoiningList">
                        <?php
                        $members_sql = "SELECT users_detail.joining_date, users.user_id, users.username, users_detail.image FROM users 
                        LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
                        LEFT JOIN role on role.role_id = users.role_id
                    WHERE `role`.`name` = 'Member' ORDER BY `users_detail`.`joining_date` DESC";
                        $members_result = mysqli_query($conn, $members_sql);
                        $members = mysqli_fetch_all($members_result, MYSQLI_ASSOC);

                        foreach ($members as $member) {
                            $join_date = strtotime($member['joining_date']);
                            $days_since_joining = floor((time() - $join_date) / (60 * 60 * 24)); // Calculating days difference

                            if ($days_since_joining <= 30 && $days_since_joining >= 0) { // Display only if joined within the last 20 days
                        ?>
                                <li class="d-flex mb-4 pb-1 align-items-center">
                                    <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                        <img src="../media/images/<?= $member['image'] ?>" alt="<?= $member['username'] ?>" height="28" class="me-3 rounded">
                                    </a>
                                    <div class="d-flex w-100 align-items-center gap-2">
                                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                            <div>
                                                <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                                    <h6 class="mb-0"><?= $member['username'] ?></h6>
                                                    <small class="text-muted">#00<?= $member['user_id'] ?></small>
                                                </a>
                                            </div>

                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <?php
                                                echo '<h6 class="badge bg-label-primary mb-0">' . $days_since_joining . ' days ago</h6>';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="chart-progress" data-color="secondary" data-series="85">
                                        </div>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Remaining Days Members -->
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
                                        <h5 class="modal-title" id="modalCenterTitle">Remaining Days List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Membership</label>
                                                <select id="membership-remaining_days" class="form-select">
                                                    <option value="All">All</option>
                                                    <?php
                                                    $sql = "SELECT membership_id, membership_name FROM `membership`";
                                                    $res = mysqli_query($conn, $sql);

                                                    if (mysqli_num_rows($res) > 0) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                                            <option value='<?= $row['membership_id'] ?>'><?= $row['membership_name'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="membership-remaining_days-month" class="form-control" value="<?php echo date('Y-m'); ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="remainingPaginationLimit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Remaining Days</label>
                                                <select class="form-select" id="remainingValidationDays">
                                                    <option value="10">10</option>
                                                    <option value="25">15</option>
                                                    <option value="20">20</option>
                                                    <option value="25">25</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="search-btn" onclick="searching_remaining_days()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="memberList">
                    <ul class="p-0 m-0" id="subscriptionRemainingList">
                        <?php
                        $members_sql = "SELECT membership_start_date, membership_end_date, users.user_id, users.username, users_detail.image
                FROM membership_details
                LEFT JOIN users ON membership_details.user_id = users.user_id
                LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
                LEFT JOIN role ON role.role_id = users.role_id
                WHERE role.name = 'Member'
                ORDER BY users.user_id ASC";
                        $members_result = mysqli_query($conn, $members_sql);
                        $members = mysqli_fetch_all($members_result, MYSQLI_ASSOC);

                        foreach ($members as $member) {
                            $joining_date = strtotime($member['membership_start_date']);
                            $end_date = strtotime($member['membership_end_date']);

                            // Calculate remaining validation days
                            $remaining_validation_days = ceil(($end_date - time()) / (60 * 60 * 24));

                            if ($remaining_validation_days <= 10 && $remaining_validation_days >= 0) {
                        ?>
                                <li class="d-flex mb-4 pb-1 align-items-center">
                                    <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                        <img src="../media/images/<?= $member['image'] ?>" alt="<?= $member['username'] ?>" height="28" class="me-3 rounded">
                                    </a>
                                    <div class="d-flex w-100 align-items-center gap-2">
                                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                            <div>
                                                <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                                    <h6 class="mb-0"><?= $member['username'] ?></h6>
                                                <small class="text-muted">#00<?= $member['user_id'] ?></small>
                                                </a>
                                            </div>

                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <h6 class="badge bg-label-primary mb-0"><?= $remaining_validation_days ?> days remaining</h6>
                                            </div>
                                        </div>
                                        <div class="chart-progress" data-color="secondary" data-series="85">
                                        </div>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>

                    </ul>
                </div>
            </div>
        </div>
        <!--/ Remaining Days Members -->
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
                                        <h5 class="modal-title" id="modalCenterTitle">End Days List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Member Subscription</label>
                                                <select id="membership-end_days" class="form-select">
                                                    <option value="All">All</option>
                                                    <?php
                                                    $sql = "SELECT membership_id, membership_name FROM `membership`";
                                                    $res = mysqli_query($conn, $sql);

                                                    if (mysqli_num_rows($res) > 0) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                    ?>
                                                            <option value='<?= $row['membership_id'] ?>'><?= $row['membership_name'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="membership-end_date-month" class="form-control" value="<?= date('Y-m'); ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="endPaginationLimit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="searching_end_days()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="groupList">
                    <ul class="p-0 m-0" id="subscriptionEndList">
                        <?php
                        // Fetching latest entries for each user_id
                        $members_sql = "SELECT m1.id, m1.membership_start_date, m1.membership_end_date, users.user_id, users.username, users_detail.image
                FROM membership_details m1
                LEFT JOIN users ON m1.user_id = users.user_id
                LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
                LEFT JOIN role ON role.role_id = users.role_id
                WHERE role.name = 'Member'
                AND NOT EXISTS (
                    SELECT 1 FROM membership_details m2
                    WHERE m2.user_id = m1.user_id AND m2.membership_start_date > m1.membership_start_date)";

                        $members_result = mysqli_query($conn, $members_sql);
                        $members = mysqli_fetch_all($members_result, MYSQLI_ASSOC);

                        foreach ($members as $member) {
                            $joining_date = strtotime($member['membership_start_date']);
                            $end_date = strtotime($member['membership_end_date']);

                            // Check if membership is renewed
                            $membership_renewed = ($end_date < time()) ? true : false;

                            if ($membership_renewed) {
                        ?>
                                <li class="d-flex mb-4 pb-1 align-items-center">
                                    <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                        <img src="../media/images/<?= $member['image'] ?>" alt="<?= $member['username'] ?>" height="28" class="me-3 rounded">
                                    </a>
                                    <div class="d-flex w-100 align-items-center gap-2">
                                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                            <div>
                                                <a href="view-profile.php?view_profile_id=<?= $member['user_id'] ?>">
                                                    <h6 class="mb-0"><?= $member['username'] ?></h6>
                                                <small class="text-muted">#00<?= $member['user_id'] ?></small>
                                                </a>
                                            </div>

                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <h6 class="badge bg-label-danger mb-0">Membership End</h6>
                                            </div>
                                        </div>
                                        <div class="chart-progress" data-color="secondary" data-series="85">
                                        </div>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ End Days Members -->
        <!-- Attendence -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Attendence List</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#attendencemodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="attendencemodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Attendence List
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Status</label>
                                                <select id="attendence_status" class="form-select">
                                                    <option value="All">All</option>
                                                    <option value="Present">Present</option>
                                                    <option value="Absent">Absent</option>
                                                    <option value="Leave">Leave</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="date" id="attendence_month_day" class="form-control" value="<?= date('Y-m-d') ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="attendencePaginationLimit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="searching_attendence()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="attendenceList">
                    <ul class="p-0 m-0">
                        <?php
                        // Attendence List Data Load Code
                        $sql = "SELECT users.user_id, att.attend_id, att.attend_status, users.username, users_detail.image
                        FROM attendence as att
                        INNER JOIN users ON users.user_id = att.users_id
                        LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($attendence_row = mysqli_fetch_assoc($result)) {
                        ?>
                                <li class="d-flex mb-4 pb-1 align-items-center">
                                    <a href="attendence-view.php?view_attend=<?= $attendence_row['attend_id'] ?>">
                                        <img src="../assets/img/attendence.png" alt="Chrome" height="28" class="me-3 rounded">
                                    </a>
                                    <div class="d-flex w-100 align-items-center gap-2">
                                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                            <div>
                                                <a href="attendence-view.php?view_attend=<?= $attendence_row['attend_id'] ?>">
                                                    <h6 class="mb-0"><?= $attendence_row['username'] ?></h6>
                                                    <small class="text-muted">#00<?= $attendence_row['user_id'] ?></small>
                                                </a>
                                            </div>
                                            <div class="user-progress d-flex align-items-center gap-2">
                                                <?php
                                                if ($attendence_row['attend_status'] == 'Present') {
                                                    echo '<h6 class="badge bg-label-success mb-0">Present</h6>';
                                                } elseif ($attendence_row['attend_status'] == 'Absent') {
                                                    echo '<h6 class="badge bg-label-danger mb-0">Absent</h6>';
                                                } elseif ($attendence_row['attend_status'] == 'Leave') {
                                                    echo '<h6 class="badge bg-label-primary mb-0">Leave</h6>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="chart-progress" data-color="secondary" data-series="85">
                                        </div>
                                    </div>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Attendence -->
        <!-- Income -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Income List</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#incomemodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="incomemodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Income List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="income_Pagination_Month" class="form-control" value="<?= date('Y-m') ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="income_Pagination_Limit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="searching_income()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="incomeList">
                    <ul class="p-0 m-0" id="incomeListData">
                        <?php
                        // Income List data from database
                        $income_sql = "SELECT users.user_id, users.username, income.income_id, income.pay_fees, income.status, users_detail.image
                        FROM income 
                        LEFT JOIN users ON users.user_id = income.user_id
                        LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id                        
                        ORDER BY income_id DESC LIMIT 25";
                        $income_result = mysqli_query($conn, $income_sql);
                        $incomes = mysqli_fetch_all($income_result, MYSQLI_ASSOC);
                        foreach ($incomes as $income) {
                        ?>
                            <li class="d-flex mb-4 pb-1 align-items-center">
                                <img src="../assets/img/income.png" alt="Chrome" height="28" class="me-3 rounded">
                                <div class="d-flex w-100 align-items-center gap-2">
                                    <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                        <div>
                                            <a href="income-view.php?income_view_id=<?= $income['income_id'] ?>">
                                                <h6 class="mb-0"><?= $income['username'] ?></h6>
                                                <small class="text-muted">#00<?= $income['user_id'] ?></small>
                                            </a>
                                        </div>

                                        <div class="user-progress d-flex align-items-center gap-2">
                                            <h6 class="badge bg-label-primary mb-0"><?= $income['pay_fees'] ?></h6>
                                        </div>
                                    </div>
                                    <div class="chart-progress" data-color="secondary" data-series="85">
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Income -->
        <!-- Expense -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Expense List</h5>
                    </div>
                    <div class="">
                        <button class="btn p-0" type="button" id="employeeList" data-bs-toggle="modal" data-bs-target="#expensemodal" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-adjustments-horizontal ti-sm text-muted"></i>
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="expensemodal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCenterTitle">Expense List</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-2">
                                            <div class="col mb-0">
                                                <label for="dobWithTitle" class="form-label">Month</label>
                                                <input type="month" id="expense_Pagination_Month" class="form-control" value="<?= date('Y-m') ?>">
                                            </div>
                                            <div class="col-md-6 col-12 mb-0">
                                                <label for="" class="form-label">Pagination</label>
                                                <select class="form-select" id="expense_Pagination_Limit">
                                                    <option value="15">15</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" onclick="expense_Pagination_Search()" data-bs-dismiss="modal">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Model -->
                    </div>
                </div>
                <div class="card-body" id="expenseList">
                    <ul class="p-0 m-0" id="expenseListData">
                        <?php
                        // Expence List data from database
                        $expence_sql = "SELECT expense_id, expense_name, expense_amount 
                        FROM expense";
                        $expence_result = mysqli_query($conn, $expence_sql);
                        $expence = mysqli_fetch_all($expence_result, MYSQLI_ASSOC);
                        foreach ($expence as $expence_row) {
                        ?>
                            <li class="d-flex mb-4 pb-1 align-items-center">
                                <img src="../assets/img/admin-expense.png" alt="Chrome" height="28" class="me-3 rounded">
                                <div class="d-flex w-100 align-items-center gap-2">
                                    <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                        <div>
                                            <a href="expense-view.php?view_expense=<?= $expence_row['expense_id'] ?>">
                                                <h6 class="mb-0"><?= $expence_row['expense_name'] ?></h6>
                                            </a>
                                            <small class="text-muted">#00<?= $expence_row['expense_id'] ?></small>
                                        </div>

                                        <div class="user-progress d-flex align-items-center gap-2">
                                            <h6 class="badge bg-label-primary mb-0"><?= $expence_row['expense_amount'] ?></h6>
                                            <!-- <h6 class="mb-0"></h6> -->
                                        </div>
                                    </div>
                                    <div class="chart-progress" data-color="secondary" data-series="85">
                                    </div>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Expense -->


    </div>

    <!--/ End Days Members -->



</div>
<!-- / Content -->

<?php
include_once('inc/footer.php');
?>


<script>
    // Search for recently joining
    function searching_recently_joining() {
        var recentlyMembershipMonth = document.getElementById('membership-recently_joining-month').value;
        var recentlyPaginationLimit = $("#recentlyPaginationLimit").val();
        var membershipRecentlyDays = $("#membership-recently_days").val();
        var recentlyValidationDays = $("#recentlyValidationDays").val();

        // Send the AJAX request
        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searching-recently_joining-membership',
                recentlyMembershipMonth: recentlyMembershipMonth,
                recentlyPaginationLimit: recentlyPaginationLimit,
                membershipRecentlyDays: membershipRecentlyDays,
                recentlyValidationDays: recentlyValidationDays,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#recentlyJoiningList").html(response.data);
            },
        });
    }

    // Search for remaining days
    function searching_remaining_days() {
        var selectRemainingMembership = $("#membership-remaining_days").val();
        var remainingMembershipMonth = document.getElementById('membership-remaining_days-month').value;
        var remainingPaginationLimit = $("#remainingPaginationLimit").val();
        var remainingValidationDays = $("#remainingValidationDays").val();

        console.log(selectRemainingMembership, remainingMembershipMonth, remainingPaginationLimit);

        // Send the AJAX request
        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searching-remaining_days-membership',
                selectRemainingMembership: selectRemainingMembership,
                remainingMembershipMonth: remainingMembershipMonth,
                remainingPaginationLimit: remainingPaginationLimit,
                remainingValidationDays: remainingValidationDays,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#subscriptionRemainingList").html(response.data);
            },
        });
    }


    // Search for end days
    function searching_end_days() {
        var selectEndMembership = $("#membership-end_days").val();
        var endMembershipMonth = document.getElementById('membership-end_date-month').value;
        var endPaginationLimit = $("#endPaginationLimit").val();


        // Send the AJAX request
        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searching-end_days-membership',
                selectEndMembership: selectEndMembership,
                endMembershipMonth: endMembershipMonth,
                endPaginationLimit: endPaginationLimit,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#subscriptionEndList").html(response.data);
            },
        });
    }

    // Search for attendence
    function searching_attendence() {
        var selectAttendenceStatus = $("#attendence_status").val();
        var attendenceMonthDay = document.getElementById('attendence_month_day').value;
        var attendencePaginationLimit = $("#attendencePaginationLimit").val();

        // Send the AJAX request
        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searching-attendence-status',
                selectAttendenceStatus: selectAttendenceStatus,
                attendenceMonthDay: attendenceMonthDay,
                attendencePaginationLimit: attendencePaginationLimit,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#attendenceList").html(response.data);
            },
        });
    }

    // Search for income
    function searching_income() {
        var incomePaginationMonth = document.getElementById('income_Pagination_Month').value;
        var incomePaginationLimit = $("#income_Pagination_Limit").val();

        console.log(incomePaginationMonth, incomePaginationLimit);

        // Send the AJAX request
        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'searching-income-Data',
                incomePaginationMonth: incomePaginationMonth,
                incomePaginationLimit: incomePaginationLimit,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#incomeListData").html(response.data);
            },
        });
    }

    // search for expense
    function expense_Pagination_Search() {
        var expencePaginationMonth = document.getElementById('expense_Pagination_Month').value;
        var expencePaginationLimit = $("#expense_Pagination_Limit").val();

        console.log(expencePaginationMonth, expencePaginationLimit);

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'expense-Pagination-Search',
                expencePaginationMonth: expencePaginationMonth,
                expencePaginationLimit: expencePaginationLimit,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#expenseListData").html(response.data);
            },
        });
    }

    function search_month_wise_income() {
        var searchIncome = document.getElementById('search-income_month').value;

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-month_wise-income',
                searchIncome: searchIncome,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#total_income").html(response.data);
            },
        });
    }

    function search_month_wise_expense() {
        var searchExpense = document.getElementById('search-expense_month').value;

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-month_wise-expence',
                searchExpense: searchExpense,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#total_expense").html(response.data);
            },
        });
    }

    function search_month_wise_salary() {
        var searchSalary = document.getElementById('search-salary_month').value;

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'search-month_wise-salary',
                searchSalary: searchSalary,
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#total_salary").html(response.data);
            },
        });
    }
</script>