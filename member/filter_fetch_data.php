<?php
session_start();
include_once('../includes/config.php');

function filter_attendence_status($selectAttendenceStatus, $attendenceMonthDay, $attendencePaginationLimit)
{
    global $conn;

    // Extract month and year from the selected month variable
    $day = date('d', strtotime($attendenceMonthDay));
    $month = date('m', strtotime($attendenceMonthDay));
    $year = date('Y', strtotime($attendenceMonthDay));

    // Modify the query based on your database structure
    $attendance_query = "SELECT attend_id, attend_date, attend_status, users.username, users_detail.image, users.user_id 
    FROM attendence 
    INNER JOIN users ON attendence.users_id = users.user_id
    LEFT JOIN users_detail on users_detail.users_detail_id = users.users_detail_id
    WHERE attendence.users_id = '{$_SESSION['UID']}'";

    if ($attendenceMonthDay != '') {
        $attendance_query .= " AND DAY(attendence.attend_date) = '$day' AND MONTH(attendence.attend_date) = '$month' AND YEAR(attendence.attend_date) = '$year'";
    }

    if ($selectAttendenceStatus != 'All') {
        $attendance_query .= " AND attendence.attend_status = '$selectAttendenceStatus'";
    }

    $attendance_query .= " ORDER BY attendence.attend_id DESC LIMIT $attendencePaginationLimit;";

    $attendance_result = mysqli_query($conn, $attendance_query);
    $attendance_data = mysqli_fetch_all($attendance_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($attendance_data as $attendance) {

        $data .= '
    <li class="d-flex mb-4 pb-1 align-items-center">
        <img src="../media/images/' . $attendance['image'] . '" alt="Chrome" height="28" class="me-3 rounded">
        <div class="d-flex w-100 align-items-center gap-2">
            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                <div>
                    <a href="javascript:void(0);">
                        <h6 class="mb-0">' . $attendance['username'] . '</h6>
                    </a>
                    <small class="text-muted">#00' . $attendance['user_id'] . '</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">';

        if ($attendance['attend_status'] == 'Present') {
            $data .= '<h6 class="badge bg-label-success mb-0">Present</h6>';
        } elseif ($attendance['attend_status'] == 'Absent') {
            $data .= '<h6 class="badge bg-label-danger mb-0">Absent</h6>';
        } elseif ($attendance['attend_status'] == 'Leave') {
            $data .= '<h6 class="badge bg-label-primary mb-0">Leave</h6>';
        }

        $data .= '</div>
            <div class="chart-progress" data-color="secondary" data-series="85"></div>
        </div>
    </div>
</li>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Attendence data matching this search for ' . $selectAttendenceStatus . ' in ' . $attendenceMonthDay . '</td>
                </tr>';
    }

    return $data;
}

function filter_income_pagination($memberDepositDate, $memberDepositLimited)
{
    global $conn;

    // month & year
    $month = date('m', strtotime($memberDepositDate));
    $year = date('Y', strtotime($memberDepositDate));

    $deposit_query = "SELECT users.user_id, users.username, users_detail.image, income.pay_fees, income.status
    FROM income
    INNER JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail on users.users_detail_id = users_detail.users_detail_id
    WHERE users.user_id = '{$_SESSION['UID']}'";

    if (!empty($memberDepositDate)) {
        $deposit_query .= " AND MONTH(income.pay_fees_date) = '$month' AND YEAR(income.pay_fees_date) = '$year'";
    }

    $deposit_query .= " ORDER BY income.income_id DESC LIMIT $memberDepositLimited";

    $deposit_result = mysqli_query($conn, $deposit_query);
    $deposit_data = mysqli_fetch_all($deposit_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($deposit_data as $deposit) {

        $data .= '
        <li class="d-flex mb-4 pb-1 align-items-center">
            <img src="../media/images/' . $deposit['image'] . '" alt="Chrome" height="28" class="me-3 rounded">
            <div class="d-flex w-100 align-items-center gap-2">
                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                        <a href="javascript:void(0);">
                            <h6 class="mb-0">' . $deposit['username'] . '</h6>
                            <small class="text-muted">#00' . $deposit['user_id'] . '</small>
                        </a>
                    <div class="user-progress d-flex align-items-center gap-2">
                        <h6 class="badge bg-label-primary mb-0">' . $deposit['pay_fees'] . '</h6>';
        if ($deposit['status'] == 'Pending') {
            $data .= "<small class='text-danger'>" . $deposit['status'] . "</small>";
        } elseif ($deposit['status'] == 'Approve') {
            $data .= "<small class='text-success'>" . $deposit['status'] . "</small>";
        }
        $data .= '</div>
                </div>
                <div class="chart-progress" data-color="secondary" data-series="85">
                </div>
            </div>
        </li>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Deposit data matching this search for ' . $memberDepositDate . '</td>
                </tr>';
    }

    return $data;
}
function filter_deposit_pagination($memberDepositDate, $memberDepositLimited, $memberDepositOrder)
{
    global $conn;

    // month & year
    $month = date('m', strtotime($memberDepositDate));
    $year = date('Y', strtotime($memberDepositDate));

    $deposit_query = "SELECT income.pay_fees_date, membership.membership_amount, income.pay_fees, income.remaining_fees, income.income_id, 
    income.created_date, income.status
	FROM income
    INNER JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE income.user_id = '{$_SESSION['UID']}'";

    if (!empty($memberDepositDate)) {
        $deposit_query .= " AND MONTH(income.pay_fees_date) = '$month' AND YEAR(income.pay_fees_date) = '$year'";
    }

    $deposit_query .= " ORDER BY income.income_id {$memberDepositOrder} LIMIT $memberDepositLimited";

    $deposit_result = mysqli_query($conn, $deposit_query);
    $deposit_data = mysqli_fetch_all($deposit_result, MYSQLI_ASSOC);

    $no = 1;
    $data = '';
    foreach ($deposit_data as $deposit) {
        // Extracting day from the date
        $date = strtotime($deposit['pay_fees_date']);
        $day = date('l', $date); // Get the full textual representation of the day

        $data .= '
<tr>
    <td>' . $no++ . '</td>
    <td>' . $deposit['pay_fees_date'] . '</td>
    <td>' . $day . '</td>
    <td><span class="badge bg-label-primary me-1">' . $deposit['membership_amount'] . '</span></td>
    <td><span class="badge bg-label-success me-1">' . $deposit['pay_fees'] . '</span></td>
    <td><span class="badge bg-label-danger me-1">' . $deposit['remaining_fees'] . '</span></td>';

        if ($deposit['status'] == 'Pending') {
            $data .= '<td><span class="badge bg-label-danger mb-0">Pending</span></td>';
        }
        if ($deposit['status'] == 'Approved') {
            $data .= '<td><span class="badge bg-label-success mb-0">Approve</span></td>';
        }

        $data .= '
            </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Deposit data matching this search for ' . $memberDepositDate . '</td>
                </tr>';
    }

    return $data;
}



function load_member_attendence_Data_in_database($memberAttendenceLimited, $memberAttendenceOrder, $memberAttendenceDate)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT attend_id, attend_status, attend_date, attendence.created_by, users.username, users_detail.Phone, role.name as role
    FROM `attendence`
    INNER JOIN users ON users.user_id = attendence.users_id
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    INNER JOIN role ON role.role_id = users.role_id
    WHERE users.username = '{$_SESSION['username']}'";

    if (!empty($memberAttendenceDate)) {
        $query .= " AND attend_date = '{$memberAttendenceDate}'";
    }

    $query .= " ORDER BY attend_id {$memberAttendenceOrder} LIMIT $memberAttendenceLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $date = strtotime($row['attend_date']);
        $day = date('l', $date); // Get the full textual representation of the day

        // Extracting date from the created_date
        // $created_date = isset($row['attend_date']) ? date('Y-m-d', strtotime($row['attend_date'])) : '';
        $data .= '
            <tr class="text-center">
                <td>' . $count++ . '</td>
                <td>' . $row['attend_date'] . '</td>
                <td>' . $day . '</td>
                <td>';
        if ($row['attend_status'] == 'Present') {
            $data .= '<span class="badge bg-label-success mb-0">Present</span>';
        } elseif ($row['attend_status'] == 'Absent') {
            $data .= '<span class="badge bg-label-danger mb-0">Absent</span>';
        } elseif ($row['attend_status'] == 'Leave') {
            $data .= '<span class="badge bg-label-primary mb-0">Leave</span>';
        }

        $data .= '</td>
                <td>' . $row['created_by'] . '</td>
            </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no (' . $_SESSION['username'] . ') data in the database. No match ' . $memberAttendenceDate  . '</td>
                </tr>';
    }

    return $data;
}




if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // filter index-page - attendence status
    if ($action == 'searching-attendence-status') {
        $selectAttendenceStatus = $_POST['selectAttendenceStatus'];
        $attendenceMonthDay = $_POST['attendenceMonthDay'];
        $attendencePaginationLimit = $_POST['attendencePaginationLimit'];

        $result = filter_attendence_status($selectAttendenceStatus, $attendenceMonthDay, $attendencePaginationLimit);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - income
    if ($action == 'searching-income-Data') {
        $incomePaginationMonth = $_POST['incomePaginationMonth'];
        $incomePaginationLimit = $_POST['incomePaginationLimit'];

        $result = filter_income_pagination($incomePaginationMonth, $incomePaginationLimit);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - expence
    if ($action == 'load-member_attendence-Data') {
        $memberAttendenceLimited = $_POST['memberAttendenceLimited'];
        $memberAttendenceOrder = $_POST['memberAttendenceOrder'];
        $memberAttendenceDate = $_POST['memberAttendenceDate'];

        $result = load_member_attendence_Data_in_database($memberAttendenceLimited, $memberAttendenceOrder, $memberAttendenceDate);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter income-deposit page - deposit
    if ($action == 'load-member_deposit-Data') {
        $memberDepositDate = $_POST['memberDepositDate'];
        $memberDepositLimited = $_POST['memberDepositLimited'];
        $memberDepositOrder = $_POST['memberDepositOrder'];

        $result = filter_deposit_pagination($memberDepositDate, $memberDepositLimited, $memberDepositOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    
}
