<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Member') {
    // Redirect to login page
    header('location: ../login');
}

// When the admin login and insert the login time in user_details table in the database
if (isset($_SESSION['role']) == 'Member') {
    $user_id = $_SESSION['details_id'];
    // $login_time = date('Y-m-d H:i:s');
    $query = "UPDATE `users_detail` SET `login_time` = NOW() WHERE `users_detail`.`users_detail_id` = '$user_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

$getMember = "SELECT * FROM users_detail WHERE users_detail_id = '" . $_SESSION['details_id'] . "'";
$result = mysqli_query($conn, $getMember);

if (mysqli_num_rows($result) > 0) {
    $member = mysqli_fetch_assoc($result);
    // $user_id = $member['user_id'];
    $full_name = $member['full_name'];
    $image = $member['image'];
}



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
                                <img src="../assets/img/avatars/14.png" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="me-2 text-body h5 mb-0 fw-bold">
                                <?= $full_name; ?> 🎉
                                <span class="badge bg-label-primary ms-1"><?= $_SESSION['role']; ?></span>
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
        </div>
    </div>


    <div class="row">

        <!-- Attendence -->
        <div class="col-12 col-md-4 mb-4">
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
                                        <div class="row">

                                        </div>
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
                        $sql = "SELECT attend_status, users.username, users_detail.image, users.user_id 
                        FROM attendence 
                        INNER JOIN users ON attendence.users_id = users.user_id
                        LEFT JOIN users_detail on users_detail.users_detail_id = users.users_detail_id
                        WHERE users.user_id = '{$_SESSION['UID']}'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($attendence_row = mysqli_fetch_assoc($result)) {
                        ?>
                                <li class="d-flex mb-4 pb-1 align-items-center">
                                    <img src="../media/images/<?= $attendence_row['image'] ?>" alt="Chrome" height="28" class="me-3 rounded">
                                    <div class="d-flex w-100 align-items-center gap-2">
                                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                            <div>
                                                <a href="javascript:void(0);">
                                                    <h6 class="mb-0"><?= $attendence_row['username'] ?></h6>
                                                </a>
                                                <small class="text-muted">#00<?= $attendence_row['user_id'] ?></small>
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
        <div class="col-12 col-md-4 mb-4">
            <div class="card overflow-hidden" style="height: 500px;">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">Deposit List</h5>
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
                                                <label class="form-label">Month</label>
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
                        $income_sql = "SELECT users.user_id, users.username, users_detail.image, income.pay_fees, income.status
                        FROM income
                        INNER JOIN users ON users.user_id = income.user_id
                        LEFT JOIN users_detail on users.users_detail_id = users_detail.users_detail_id
                        WHERE users.user_id = '{$_SESSION['UID']}'";
                        $income_result = mysqli_query($conn, $income_sql);
                        $incomes = mysqli_fetch_all($income_result, MYSQLI_ASSOC);
                        foreach ($incomes as $income) {
                        ?>
                            <li class="d-flex mb-4 pb-1 align-items-center">
                                <img src="../media/images/<?= $income['image'] ?>" alt="Chrome" height="28" class="me-3 rounded">
                                <div class="d-flex w-100 align-items-center gap-2">
                                    <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                                        <div>
                                            <a href="javascript:void(0);">
                                                <h6 class="mb-0"><?= $income['username'] ?></h6>
                                            </a>
                                            <small class="text-muted">#00<?= $income['user_id'] ?></small>
                                        </div>

                                        <div class="user-progress d-flex align-items-center gap-2">
                                            <h6 class="badge bg-label-primary mb-0"><?= $income['pay_fees'] ?></h6>
                                            <?php
                                            if ($income['status'] == 'Pending') {
                                                echo "<small class='text-danger'>" . $income['status'] . "</small>";
                                            } elseif ($income['status'] == 'Approved') {
                                                echo "<small class='text-success'>" . $income['status'] . "</small>";
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
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Income -->
    </div>
    <!--/ End Days Members -->



</div>
<!-- / Content -->

<?php
include_once('inc/footer.php');
?>


<script>
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
</script>