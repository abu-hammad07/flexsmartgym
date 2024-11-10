<?php
session_start();
include_once ('../includes/config.php');

// Feature Function to filter and display data in the table based on user input or database data depending on your database structure and requirements  
function filter_fetures_data_In_Database($feruresLimited, $feturesOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT * FROM fetures
    ORDER BY id $feturesOrder LIMIT $feruresLimited;
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '
        <tr class="border-bottom">
                <td>' . $count++ . '</td>
                <td>' . $row['feture_name'] . '</td>
                <td>
                    <div class="group">
                        <a class="" href="fetures.php?edit_feture_id=' . $row['id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                            <i class="ti ti-edit me-1 text-success"></i>
                        </a>
                        <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteFeture' . $row['id'] . '" data-bs-placement="top" title="Delete">
                            <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                        </button>
                        <div class="modal fade" id="deleteFeture' . $row['id'] . '" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Feature? Name \'' . $row['id'] . '\'</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        <p>Please confirm that you want to delete this feature. <br>
                                            Once deleted, you won\'t be able to recover it. <br>
                                            Please proceed with caution.
                                        </p>
                                    </div>
                                    <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                        <a href="all-db-code.php?delete_feture_id=' . $row['id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        ';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Features data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_subscription_data_In_Database($subscriptionLimited, $subscriptionOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT * FROM membership
    ORDER BY membership_id $subscriptionOrder LIMIT $subscriptionLimited 
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr class="text-center">
        <td>' . $count++ . '</td>
        <td>' . $row['membership_name'] . '</td>
        <td>' . $row['membership_amount'] . '</td>
        <td>' . $row['validation_days'] . '</td>
        <td>';
        if ($row['membership_status'] == 'Active') {
            $data .= '<span class="badge bg-label-success mb-0">Present</span>';
        } elseif ($row['membership_status'] == 'Deactive') {
            $data .= '<span class="badge bg-label-danger mb-0">Absent</span>';
        }
        $data .='</td>
        <td>
            <a class="" href="membership-view.php?view_membership_id=' . $row['membership_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
            <a href="membership-edit.php?edit_membership_id=' . $row['membership_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
            </a>
        </td>
    </tr>
        ';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Membership data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_members_data_In_Database($membersLimited, $membersOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, users.email, users_detail.phone, users_detail.image, membership.membership_name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id 
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE role.name = 'Member' 
    ORDER BY users.user_id $membersOrder LIMIT $membersLimited;
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr Class="text-center">
        <td>' . $count++ . '</td>
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="../media/images/' . $row['image'] . '" alt="' . $row['username'] . '" class="rounded-circle">
                </li>
                <li>' . $row['username'] . '</li>
            </ul>
        </td>
        <td>' . $row['email'] . '</td>
        <td>' . $row['phone'] . '</td>
        <td>' . $row['membership_name'] . '</td>
        <td>
            <div class="group">
            <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
                <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                    <i class="ti ti-pencil me-1 text-success"></i>
                </a>
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteMember' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteMember' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Member? Username: <span class="text-danger">' . $row['username'] . '</span></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-start">
                                <p>Please confirm that you want to delete your subscription. <br>
                                    Once deleted, you won\'t be able to recover it. <br>
                                    Please proceed with caution.
                                </p>
                            </div>
                            <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                <a href="?delete_member_id=' . $row['user_id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Members data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_staff_data_In_Database($staffLimited, $staffOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, users.email, users_detail.Phone, users_detail.image, users_detail.salary
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Staff'
    ORDER BY users.user_id $staffOrder LIMIT $staffLimited
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr Class="text-center">
        <td>' . $count++ . '</td>
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="../media/images/' . $row['image'] . '" alt="' . $row['username'] . '" class="rounded-circle">
                </li>
                <li>' . $row['username'] . '</li>
            </ul>
        </td>
        <td>' . $row['email'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td>' . $row['salary'] . '</td>
        <td>
        <div class="group">
        <a class="" href="staff-view.php?view_staff=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
            <i class="ti ti-eye me-1 text-info"></i>
        </a>
        <a class="" href="staff-edit.php?edit_staff=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
            <i class="ti ti-pencil me-1 text-success"></i>
        </a>
        <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteStaff' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
            <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
        </button>
        <div class="modal fade" id="deleteStaff' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Staff? Username: <span class="text-danger">' . $row['username'] . '</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <p>Please confirm that you want to delete your subscription. <br>
                            Once deleted, you won\'t be able to recover it. <br>
                            Please proceed with caution.
                        </p>
                    </div>
                    <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                        <a href="?delete_staff_id=' . $row['user_id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </td>
    </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Staff data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_salary_data_In_Database($salaryLimited, $salaryOrder, $salaryDate)
{
    global $conn;

    $day = date('d', strtotime($salaryDate));
    $month = date('m', strtotime($salaryDate));
    $year = date('Y', strtotime($salaryDate));

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users.username, 
    users_detail.Phone, users_detail.salary,
    salary.salary_id, salary.pay_salary, salary.remaining_salary, salary.monthly_date, salary.created_date
        FROM salary 
        INNER JOIN users on users.user_id = salary.users_id
        INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
        LEFT JOIN role ON role.role_id = users.role_id
        WHERE salary.users_id IN (SELECT user_id FROM users)";

    if (!empty($salaryDate)) {
        $query .= " AND day(salary.created_date) = '$day' AND month(salary.created_date) = '$month' AND year(salary.created_date) = '$year'";
    }

    $query .= " ORDER BY `salary_id` $salaryOrder LIMIT $salaryLimited";


    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        // monthly_date to date format
        // $day = date('d', strtotime($row['created_date']));
        $monthly_date = date('Y-F-d', strtotime($row['monthly_date']));

        $data .= '

        <tr class="text-center">
        <td>' . $count++ . '</td>
        <td>' . $row['username'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['salary'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_salary'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_salary'] . '</span></td>
        <td>' . $monthly_date . '</td>
        <td>
            <a href="salary-edit.php?salary_edit_id=' . $row['salary_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
            </a>
            <a class="" href="salary-view.php?salary_view_id=' . $row['salary_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['salary_id'] . '" data-bs-placement="top" title="Delete">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteIncome' . $row['salary_id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Income? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete your Incometion. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?salary_delete_id=' . $row['salary_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Salary data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_admin_data_In_Database($adminLimited, $adminOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT users.user_id, users_detail.full_name, users.username, users.email, users_detail.Phone, users_detail.image, role.name FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Admin' 
    ORDER BY users.user_id $adminOrder LIMIT $adminLimited
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr Class="text-center">
        <td>' . $count++ . '</td>
        <td>
            <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                    <img src="../media/images/' . $row['image'] . '" alt="' . $row['username'] . '" class="rounded-circle">
                </li>
                <li>' . $row['username'] . '</li>
            </ul>
        </td>
        <td>' . $row['email'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td>
        <div class="group">
        <a class="" href="admin-view.php?view_admin=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
            <i class="ti ti-eye me-1 text-info"></i>
        </a>
            <a class="" href="admin-edit.php?edit_admin=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                <i class="ti ti-pencil me-1 text-success "></i>
            </a>
            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteAdmin' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                <span><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteAdmin' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Admin? Username: <span class="text-danger">' . $row['username'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete your subscription. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?delete_admin_id=' . $row['user_id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
    </tr>
        
        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Admin data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_attendence_data_In_Database($attendenceLimited, $attendenceOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT users.username, users_detail.Phone, role.name as role, attendence.attend_id, attendence.attend_status, attendence.attend_date 
    FROM `attendence`
    INNER JOIN users ON users.user_id = attendence.users_id
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    INNER JOIN role ON role.role_id = users.role_id
    ORDER BY attend_id $attendenceOrder LIMIT $attendenceLimited
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $date = date('Y-F-d', strtotime($row['attend_date']));

        $data .= '
            <tr class="text-center">
                <td>' . $count++ . '</td>
                <td>' . $row['username'] . '</td>
                <td>' . $row['Phone'] . '</td>
                <td>' . $row['role'] . '</td>
                <td>' . $date . '</td>
                <td>';

        if ($row['attend_status'] == 'Present') {
            $data .= '<span class="badge bg-label-success mb-0">Present</span>';
        } elseif ($row['attend_status'] == 'Absent') {
            $data .= '<span class="badge bg-label-danger mb-0">Absent</span>';
        } elseif ($row['attend_status'] == 'Leave') {
            $data .= '<span class="badge bg-label-primary mb-0">Leave</span>';
        }

        $data .= '</td>
                <td>
                    <a href="attendence-edit.php?edit_attend_id=' . $row['attend_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
                    </a>
                    <a class="" href="attendence-view.php?view_attend=' . $row['attend_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                        <i class="ti ti-eye me-1 text-info"></i>
                    </a>
                    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteAttendence' . $row['attend_id'] . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteAttendence' . $row['attend_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Attendance? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete this attendance record. <br>
                                        Once deleted, it cannot be recovered. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="?attend_delete_id=' . $row['attend_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Admin data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_expence_data_In_Database($expenceLimited, $expenceOrder, $expenceDate)
{
    global $conn;

    $year = date('Y', strtotime($expenceDate));
    $month = date('m', strtotime($expenceDate));
    $day = date('d', strtotime($expenceDate));

    // Modify the query based on your database structure
    $query = "SELECT expense.*, expense_category.exp_category_name 
    FROM `expense`
    LEFT JOIN expense_category ON expense_category.exp_category_id = expense.expense_category_id";

    if (!empty($expenceDate)) {
        $query .= " WHERE day(expense.created_date) = '$day' AND month(expense.created_date) = '$month' AND year(expense.created_date) = '$year' ";
    }

    $query .= " ORDER BY expense.expense_id $expenceOrder LIMIT $expenceLimited";


    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr class="text-center">
        <td>' . $count++ . '</td>
        <td>' . $row['expense_name'] . '</td>
        <td>' . $row['exp_category_name'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['expense_amount'] . '</span></td>
        <td>
            <a href="expense-edit.php?edit_expense_id=' . $row['expense_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
            </a>
            <a class="" href="expense-view.php?view_expense=' . $row['expense_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteExpence' . $row['expense_id'] . '" data-bs-placement="top" title="Delete">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteExpence' . $row['expense_id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Expense? Name: <span class="text-danger">' . $row['expense_name'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete your Incometion. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?expense_delete_id=' . $row['expense_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Expense data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_income_data_In_Database($incomeLimited, $incomeOrder, $memberIncomeDate)
{
    global $conn;

    $year = date('Y', strtotime($memberIncomeDate));
    $month = date('m', strtotime($memberIncomeDate));
    $day = date('d', strtotime($memberIncomeDate));

    // Modify the query based on your database structure
    $query = "SELECT income_id,users.username,users_detail.Phone, membership.membership_amount, income.pay_fees, income.remaining_fees, income.pay_fees_date 
    FROM `income`
    LEFT JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id";

    if (!empty($memberIncomeDate)) {
        $query .= " WHERE YEAR(income.pay_fees_date) = $year AND MONTH(income.pay_fees_date) = $month AND DAY(income.pay_fees_date) = $day";
    }

    $query .= " ORDER BY income.income_id $incomeOrder LIMIT $incomeLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {

        $monthly_date = date('Y-F-d', strtotime($row['pay_fees_date'] . ' + 1 months'));

        $data .= '

        <tr class="text-center">
        <td>' . $count++ . '</td>
        <td>' . $row['username'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['membership_amount'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_fees'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_fees'] . '</span></td>
        <td>' . $monthly_date . '</td>
        <td>
            <a href="income-edit.php?income_edit_id=' . $row['income_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
            </a>
            <a class="" href="income-view.php?income_view_id=' . $row['income_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['income_id'] . '" data-bs-placement="top" title="Delete">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteIncome' . $row['income_id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Income? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete your Incometion. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?income_delete_id=' . $row['income_id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>

        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Income data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_category_data_In_Database($categoryLimited, $categoryOrder)
{
    global $conn;

    // Modify the query based on your database structure
    $query = "SELECT exp_category_id, exp_category_name FROM `expense_category`
    ORDER BY exp_category_id $categoryOrder LIMIT $categoryLimited
    ";
    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $data .= '

        <tr>
            <td>' . $count++ . '</td>
            <td>' . $row['exp_category_name'] . '</td>
            <td>
                <div class="group">
                    <a class="" href="?edit_category_id=' . $row['exp_category_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-edit me-1 text-success"></i>
                    </a>
                    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteFeture' . $row['exp_category_id'] . '" data-bs-placement="top" title="Delete">
                        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteFeture' . $row['exp_category_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Catogory? Name: <span class="text-danger">' . $row['exp_category_name'] . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete your subscription. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
                                        Please proceed with caution.
                                    </p>
                                </div>
                                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                                    <a href="all-db-code.php?delete_category_id=' . $row['exp_category_id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        ';
    }
    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Category data in the database.</td>
                </tr>';
    }

    return $data;
}

function filter_remaining_days_membership($selectRemainingMembership, $remainingMembershipMonth, $remainingPaginationLimit, $remainingValidationDays)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($remainingMembershipMonth));
    $year = date('Y', strtotime($remainingMembershipMonth));

    // Modify the query based on your database structure
    $remaining_query = "SELECT membership_details.membership_end_date, users.username, users.user_id, users_detail.image
    FROM membership_details
    LEFT JOIN users ON membership_details.user_id = users.user_id
    LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Member'";

    if (!empty($remainingMembershipMonth)) {
        $remaining_query .= " AND MONTH(membership_details.membership_end_date) = $month AND YEAR(membership_details.membership_end_date) = $year";
    }

    if ($selectRemainingMembership != 'All') {
        $remaining_query .= " AND membership_details.membership_id = $selectRemainingMembership";
    }

    $remaining_query .= " ORDER BY membership_details.membership_id ASC
    LIMIT $remainingPaginationLimit";

    $remaining_result = mysqli_query($conn, $remaining_query);

    if (!$remaining_result) {
        // Handle query execution failure
        return "Error executing query: " . mysqli_error($conn);
    }

    $remaining_data = mysqli_fetch_all($remaining_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($remaining_data as $remaining) {
        $end_date = strtotime($remaining['membership_end_date']);
        $remaining_days = ceil(($end_date - time()) / (60 * 60 * 24)); // Calculating remaining days

        // Display data only if days remaining is greater than 0
        if ($remaining_days > 0 && $remaining_days <= $remainingValidationDays) {
            $data .= '
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <a href="view-profile.php?view_profile_id=' . $remaining['user_id'] . '">
                        <img src="../media/images/' . $remaining['image'] . '" alt="User Image" height="28" class="me-3 rounded">
                    </a>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <a href="view-profile.php?view_profile_id=' . $remaining['user_id'] . '">
                                    <h6 class="mb-0">' . $remaining['username'] . '</h6>
                                    <small class="text-muted">#00' . $remaining['user_id'] . '</small>
                                </a>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">
                                <h6 class="badge bg-label-primary mb-0">' . $remaining_days . ' days remaining</h6>
                            </div>
                        </div>
                        <div class="chart-progress" data-color="secondary" data-series="85">
                        </div>
                    </div>
                </li>';
        }
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<li class="fw-semibold bg-light-warning text-warning text-center">There are no remaining data matching this search at ' . $remainingMembershipMonth . ' in ' . $selectRemainingMembership . '</li>';
    }

    return $data;
}


function filter_recently_joining_membership($recentlyMembershipMonth, $recentlyPaginationLimit, $membershipRecentlyDays, $recentlyValidationDays)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($recentlyMembershipMonth));
    $year = date('Y', strtotime($recentlyMembershipMonth));

    // Modify the query based on your database structure
    $recently_query = "SELECT * FROM `users`
    LEFT JOIN `users_detail` ON `users`.`users_detail_id` = `users_detail`.`users_detail_id`
    LEFT JOIN `role` ON `users`.`role_id` = `role`.`role_id`
    LEFT JOIN `membership` ON `membership`.`membership_id` = `users_detail`.`membership_id`
    WHERE `role`.`name` = 'Member'";

    if (!empty($recentlyMembershipMonth)) {
        $recently_query .= " AND MONTH(`users_detail`.`joining_date`) = '$month' AND YEAR(`users_detail`.`joining_date`) = '$year'";
    }

    if ($membershipRecentlyDays != 'All') {
        $recently_query .= " AND users_detail.membership_id = '$membershipRecentlyDays'";
    }

    $recently_query .= " ORDER BY `users_detail`.`joining_date` DESC
    LIMIT $recentlyPaginationLimit;";

    $recently_result = mysqli_query($conn, $recently_query);
    $recently_data = mysqli_fetch_all($recently_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($recently_data as $recently) {
        $join_date = strtotime($recently['joining_date']);
        $days_since_joining = floor((time() - $join_date) / (60 * 60 * 24)); // Calculating days difference

        if ($days_since_joining <= $recentlyValidationDays && $days_since_joining >= 0) { // Display only if joined within the last 20 days

            $data .= '
                <li class="d-flex mb-4 pb-1 align-items-center">
                    <a href="view-profile.php?view_profile_id=' . $recently['user_id'] . '">
                        <img src="../media/images/' . $recently['image'] . '" alt="Chrome" height="28" class="me-3 rounded">
                    </a>
                    <div class="d-flex w-100 align-items-center gap-2">
                        <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                            <div>
                                <a href="view-profile.php?view_profile_id=' . $recently['user_id'] . '">
                                    <h6 class="mb-0">' . $recently['full_name'] . '</h6>
                                    <small class="text-muted">#00' . $recently['user_id'] . '</small>
                                </a>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-2">';
            $data .= '<h6 class="badge bg-label-primary mb-0">' . $days_since_joining . ' days remaining</h6>';

            $data .= '</div>
                        </div>
                        <div class="chart-progress" data-color="secondary" data-series="85">
                        </div>
                    </div>
                </li>';
        }
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no recently joining data matching this search for ' . $recentlyMembershipMonth . '</td>
                </tr>';
    }

    return $data;
}

function filter_end_days_membership($selectEndMembership, $endMembershipMonth, $endPaginationLimit)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($endMembershipMonth));
    $year = date('Y', strtotime($endMembershipMonth));

    // Modify the query based on your database structure
    $endly_query = "SELECT m1.id, m1.membership_start_date, m1.membership_end_date, users.user_id, users.username, users_detail.image
    FROM membership_details m1
    LEFT JOIN users ON m1.user_id = users.user_id
    LEFT JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Member'
    AND NOT EXISTS (
        SELECT 1 FROM membership_details m2
        WHERE m2.user_id = m1.user_id AND m2.membership_start_date > m1.membership_start_date)";

    if (!empty($endMembershipMonth)) {
        $endly_query .= " AND MONTH(m1.membership_end_date) = '$month' AND YEAR(m1.membership_end_date) = '$year'";
    }

    if ($selectEndMembership != 'All') {
        $endly_query .= " AND m1.membership_id = '$selectEndMembership'";
    }

    $endly_query .= " ORDER BY m1.id DESC
    LIMIT $endPaginationLimit";

    $endly_result = mysqli_query($conn, $endly_query);
    $endly_data = mysqli_fetch_all($endly_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($endly_data as $endly) {

        $joining_date = strtotime($endly['membership_start_date']);
        $end_date = strtotime($endly['membership_end_date']);

        // Check if membership is renewed
        $membership_renewed = ($end_date < time()) ? true : false;

        if ($membership_renewed) {

            $data .= '
            <li class="d-flex mb-4 pb-1 align-items-center">
            <a href="view-profile.php?view_profile_id=' . $endly['user_id'] . '">
                <img src="../media/images/' . $endly['image'] . '" alt="' . $endly['username'] . '" height="28" class="me-3 rounded">
            </a>
            <div class="d-flex w-100 align-items-center gap-2">
                <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                        <a href="view-profile.php?view_profile_id=' . $endly['user_id'] . '">
                            <h6 class="mb-0">' . $endly['username'] . '</h6>
                            <small class="text-muted">#00' . $endly['user_id'] . '</small>
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
                ';
        }
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no ended days data matching this search for ' . $selectEndMembership . ' in ' . $endMembershipMonth . '</td>
                </tr>';
    }

    return $data;
}

function filter_attendence_status($selectAttendenceStatus, $attendenceMonthDay, $attendencePaginationLimit)
{
    global $conn;

    // Extract month and year from the selected month variable
    $day = date('d', strtotime($attendenceMonthDay));
    $month = date('m', strtotime($attendenceMonthDay));
    $year = date('Y', strtotime($attendenceMonthDay));

    // Modify the query based on your database structure
    $attendance_query = "SELECT users.user_id, att.attend_id, att.attend_status, users.username, users_detail.image
    FROM attendence as att
    INNER JOIN users ON users.user_id = att.users_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    WHERE att.attend_date = '$attendenceMonthDay'";

    if (!empty($attendenceMonthDay)) {
        $attendance_query .= " AND DAY(att.attend_date) = '$day' AND MONTH(att.attend_date) = '$month' AND YEAR(att.attend_date) = '$year'";
    }

    if ($selectAttendenceStatus != 'All') {
        $attendance_query .= " AND att.attend_status = '$selectAttendenceStatus'";
    }

    $attendance_query .= " ORDER BY att.attend_id DESC
    LIMIT $attendencePaginationLimit";

    $attendance_result = mysqli_query($conn, $attendance_query);
    $attendance_data = mysqli_fetch_all($attendance_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($attendance_data as $attendance) {

        $data .= '
    <li class="d-flex mb-4 pb-1 align-items-center">
        <img src="../assets/img/attendence.png" alt="Chrome" height="28" class="me-3 rounded">
        <div class="d-flex w-100 align-items-center gap-2">
            <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                <div>
                    <a href="attendence-view.php?view_attend=' . $attendance['attend_id'] . '">
                        <h6 class="mb-0">' . $attendance['username'] . '</h6>
                    </a>
                    <small class="text-muted">#00' . $attendance['user_id'] . '</small>
                </div>
                <div class="user-progress d-flex align-items-center gap-2">';

        // Outputting attendance status badge based on the status
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

function filter_income_pagination($incomePaginationMonth, $incomePaginationLimit)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($incomePaginationMonth));
    $year = date('Y', strtotime($incomePaginationMonth));

    // Modify the query based on your database structure
    $income_query = "SELECT users.user_id, users.username, income.*, users_detail.image
    FROM income 
    LEFT JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id";

    if (!empty($incomePaginationMonth)) {
        $income_query .= " WHERE MONTH(income.pay_fees_date) = '$month' AND YEAR(income.pay_fees_date) = '$year'";
    }

    $income_query .= " ORDER BY income.income_id DESC
    LIMIT $incomePaginationLimit";

    $income_result = mysqli_query($conn, $income_query);
    $income_data = mysqli_fetch_all($income_result, MYSQLI_ASSOC);

    $data = '';
    foreach ($income_data as $income) {

        $data .= '
            <li class="d-flex mb-4 pb-1 align-items-center">
                <img src="../assets/img/income.png" alt="Chrome" height="28" class="me-3 rounded">
                <div class="d-flex w-100 align-items-center gap-2">
                    <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                        <div>
                            <a href="income-view.php?income_view_id=' . $income['income_id'] . '">
                                <h6 class="mb-0">' . $income['username'] . '</h6>
                            </a>
                            <small class="text-muted">#00' . $income['user_id'] . '</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-2">
                            <h6 class="badge bg-label-primary mb-0">' . $income['pay_fees'] . '</h6>
                        </div>
                        <div class="chart-progress" data-color="secondary" data-series="85"></div>
                    </div>
                </div>
            </li>
            ';
    }

    // Check if $data is empty
    if (empty($data)) {
        $data = '<tr>
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Income data matching this search for ' . $incomePaginationMonth . '</td>
                </tr>';
    }

    return $data;
}

function filter_expence_pagination($expencePaginationMonth, $expencePaginationLimit)
{
    global $conn;

    // Extract month and year from the selected month variable
    $month = date('m', strtotime($expencePaginationMonth));
    $year = date('Y', strtotime($expencePaginationMonth));

    // Modify the query based on your database structure
    $expence_query = "SELECT expense_id, expense_name, expense_amount 
            FROM expense
            WHERE MONTH(`created_date`) = '$month'
            AND YEAR(`created_date`) = '$year'
            ORDER BY `expense_id` DESC
            LIMIT $expencePaginationLimit;";

    $expence_result = mysqli_query($conn, $expence_query);

    if ($expence_result) {
        $expence_data = mysqli_fetch_all($expence_result, MYSQLI_ASSOC);

        $data = '';
        foreach ($expence_data as $expence) {
            $data .= '
            <li class="d-flex mb-4 pb-1 align-items-center">
                <img src="../assets/img/admin-expense.png" alt="Chrome" height="28" class="me-3 rounded">
                <div class="d-flex w-100 align-items-center gap-2">
                    <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                        <div>
                            <a href="expense-view.php?view_expense=' . $expence['expense_id'] . '">
                                <h6 class="mb-0">' . $expence['expense_name'] . '</h6>
                            </a>
                            <small class="text-muted">#00' . $expence['expense_id'] . '</small>
                        </div>
                        <div class="user-progress d-flex align-items-center gap-2">
                            <h6 class="badge bg-label-primary mb-0">' . $expence['expense_amount'] . '</h6>
                        </div>
                    </div>
                    <div class="chart-progress" data-color="secondary" data-series="85"></div>
                </div>
            </li>';
        }

        // Check if $data is empty
        if (empty($data)) {
            $data = '<tr>
                        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Income data matching this search for ' . $expencePaginationMonth . '</td>
                    </tr>';
        }
    }
    return $data;
}


function search_month_wise_income($searchTotalIncome)
{
    global $conn;

    // $searchTotalIncome change name wise
    $monthNameWise = date('F', strtotime($searchTotalIncome));

    // Extract month and year from the selected month variable
    $selected_month = date('m', strtotime($searchTotalIncome));
    $selected_year = date('Y', strtotime($searchTotalIncome));

    // Set the start and end date of the selected month
    $start_date = "$selected_year-$selected_month-01";
    $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the selected month

    // Get total income from income table for the selected month
    $query1 = "SELECT SUM(pay_fees) AS total_income FROM `income` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
    $result1 = mysqli_query($conn, $query1);

    if (!$result1) {
        // Handle query error, if any
        return "Error: " . mysqli_error($conn);
    }

    $row1 = mysqli_fetch_assoc($result1);
    $total_income_1 = $row1['total_income'];

    // Get total income from users_detail table for the selected month
    $query2 = "SELECT SUM(users_detail.admission_fees) AS total_income FROM users
               LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
               WHERE users_detail.created_date BETWEEN '$start_date' AND '$end_date'";
    $result2 = mysqli_query($conn, $query2);

    if (!$result2) {
        // Handle query error, if any
        return "Error: " . mysqli_error($conn);
    }

    $row2 = mysqli_fetch_assoc($result2);
    $total_income_2 = $row2['total_income'];

    // Calculate the combined total income for the selected month
    $combined_total_income = $total_income_1 + $total_income_2;

    // Format the combined total income amount with commas
    $formatted_total_income = number_format($combined_total_income);

    // Prepare the HTML data to display the combined total income
    $data = '
    <span class="text-dark">Income</span>
    <div class="d-flex align-items-center my-2">
        <h3 class="mb-0 me-2 counter">' . $formatted_total_income . '</h3>
    </div>
    <p class="mb-0 text-muted">Total Income <span class="text-danger">' . $monthNameWise . '</span></p>
    ';

    // Check if $data is empty
    if (empty($formatted_total_income)) {
        $data .= '';
    }

    return $data;
}

function search_month_wise_expence($searchTotalExpence)
{
    global $conn;

    // $searchTotalIncome change name wise
    $monthNameWise = date('F', strtotime($searchTotalExpence));

    // Get the current month and year
    $current_month = date('m', strtotime($searchTotalExpence));
    $current_year = date('Y', strtotime($searchTotalExpence));

    // Set the start and end date of the current month
    $start_date = "$current_year-$current_month-01";
    $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

    // Get total expenses from expense table for the current month
    $query = "SELECT SUM(expense_amount) AS total_expense FROM `expense` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle query error, if any
        return "Error: " . mysqli_error($conn);
    }

    $row = mysqli_fetch_assoc($result);

    // Format the total expense amount with commas
    $get_total_expence = number_format($row['total_expense']);

    // Prepare the HTML data to display the combined total income
    $data = '
    <span class="text-dark">Expense</span>
    <div class="d-flex align-items-center my-2">
        <h3 class="mb-0 me-2 counter">' . $get_total_expence . '</h3>
    </div>
    <p class="mb-0 text-muted">Total Income <span class="text-danger">' . $monthNameWise . '</span></p>
    ';

    // Check if $data is empty
    if (empty($get_total_expence)) {
        $data .= '';
    }

    return $data;
}

function search_month_wise_salary($searchTotalSalary)
{
    global $conn;

    // $searchTotalIncome change name wise
    $monthNameWise = date('F', strtotime($searchTotalSalary));

    // Get the current month and year
    $current_month = date('m', strtotime($searchTotalSalary));
    $current_year = date('Y', strtotime($searchTotalSalary));

    // Set the start and end date of the current month
    $start_date = "$current_year-$current_month-01";
    $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

    // Get total expenses from expense table for the current month
    $query = "SELECT SUM(pay_salary) AS total_salary FROM `salary` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle query error, if any
        return "Error: " . mysqli_error($conn);
    }

    $row = mysqli_fetch_assoc($result);

    // Format the total expense amount with commas
    $get_total_salary = number_format($row['total_salary']);

    // Prepare the HTML data to display the combined total income
    $data = '
    <span class="text-dark">Salary</span>
    <div class="d-flex align-items-center my-2">
        <h3 class="mb-0 me-2 counter">' . $get_total_salary . '</h3>
    </div>
    <p class="mb-0 text-muted">Total Income <span class="text-danger">' . $monthNameWise . '</span></p>
    ';

    // Check if $data is empty
    if (empty($get_total_expence)) {
        $data .= '';
    }

    return $data;
}


function filter_deposit_pagination($memberDepositDate, $memberDepositLimited, $memberDepositOrder)
{
    global $conn;

    // month & year
    $day = date('d', strtotime($memberDepositDate));
    $month = date('m', strtotime($memberDepositDate));
    $year = date('Y', strtotime($memberDepositDate));

    $deposit_query = "SELECT income.pay_fees_date, membership.membership_amount, income.pay_fees, income.remaining_fees, income.income_id, 
    income.created_date, income.status, users.username
	FROM income
    INNER JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE income.status = 'Pending'";

    if (!empty($memberDepositDate)) {
        $deposit_query .= " AND DAY(income.pay_fees_date) = '$day' AND MONTH(income.pay_fees_date) = '$month' AND YEAR(income.pay_fees_date) = '$year'";
    }

    $deposit_query .= " ORDER BY income.income_id {$memberDepositOrder} LIMIT $memberDepositLimited";

    $deposit_result = mysqli_query($conn, $deposit_query);
    $deposit_data = mysqli_fetch_all($deposit_result, MYSQLI_ASSOC);

    $no = 1;
    $data = '';
    foreach ($deposit_data as $deposit) {
        // Extracting day from the date
        $date = date('Y-F-d', strtotime($deposit['pay_fees_date']));

        $data .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . $deposit['username'] . '</td>
        <td>' . $date . '</td>
        <td><span class="badge bg-label-primary me-1">' . $deposit['membership_amount'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $deposit['pay_fees'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $deposit['remaining_fees'] . '</span></td>';

        if ($deposit['status'] == 'Pending') {
            $data .= '
            <td>
            

            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteDeposit' . $deposit['income_id'] . '">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Approve">
                <span class="badge bg-label-danger mb-0">Pending</span>
                </span>
            </button>
        <div class="modal fade" id="deleteDeposit' . $deposit['income_id'] . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Confirm Approved Deposit? Username: <span class="text-danger">' . $deposit['username'] . '</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        <p>
                        Convert this into "Approve" but once approved, <br>
                        it cannot be reverted back to "Pending."
                        </p>
                    </div>
                    <div class="modal-footer justify-content-end" style="margin-top: -20px;">
                        <a href="?deposit_approve_id=' . $deposit['income_id'] . '" class="btn btn-success" name="delete_Income">Approved</a>
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </td>

            ';
        }
        if ($deposit['status'] == 'Approved') {
            $data .= '<td><span class="badge bg-label-success mb-0">Approved</span></td>';
        }

        $data .= '</tr>';
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
    $query = "SELECT attendence.*, users.username, users_detail.Phone, role.name as role
    FROM `attendence`
    INNER JOIN users ON users.user_id = attendence.users_id
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    INNER JOIN role ON role.role_id = users.role_id
    WHERE attendence.users_id = '{$_SESSION['memberViewData']}'";

    if (!empty($memberAttendenceDate)) {
        $query .= " AND attend_date = '{$memberAttendenceDate}'";
    }

    $query .= " ORDER BY attend_id {$memberAttendenceOrder} LIMIT $memberAttendenceLimited";

    $result = mysqli_query($conn, $query);

    $data = '';
    $count = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $dateWise = date('d-F-Y', strtotime($row['attend_date']));
        $date = strtotime($row['attend_date']);
        $day = date('l', $date); // Get the full textual representation of the day

        // Extracting date from the created_date
        // $created_date = isset($row['attend_date']) ? date('Y-m-d', strtotime($row['attend_date'])) : '';
        $data .= '
            <tr class="text-center">
                <td>' . $count++ . '</td>
                <td>' . $dateWise . '</td>
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
                    <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no data in the database.</td>
                </tr>';
    }

    return $data;
}


function filter_member_deposit_pagination($memberDepositDate, $memberDepositLimited, $memberDepositOrder)
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
    WHERE income.user_id = '{$_SESSION['memberViewData']}'";

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
        $dateWise = date('d-F-Y', strtotime($deposit['pay_fees_date']));
        $date = strtotime($deposit['pay_fees_date']);
        $day = date('l', $date); // Get the full textual representation of the day

        $data .= '
<tr>
    <td>' . $no++ . '</td>
    <td>' . $dateWise . '</td>
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




if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Filter fetures
    if ($action == 'load-fetures-Data') {
        $feruresLimited = $_POST['feruresLimited'];
        $feturesOrder = $_POST['feturesOrder'];
        $result = filter_fetures_data_In_Database($feruresLimited, $feturesOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter subscription
    if ($action == 'load-subscription-Data') {
        $subscriptionLimited = $_POST['subscriptionLimited'];
        $subscriptionOrder = $_POST['subscriptionOrder'];

        $result = filter_subscription_data_In_Database($subscriptionLimited, $subscriptionOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter members
    if ($action == 'load-members-Data') {
        $membersLimited = $_POST['membersLimited'];
        $membersOrder = $_POST['membersOrder'];

        $result = filter_members_data_In_Database($membersLimited, $membersOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter staff
    if ($action == 'load-staff-Data') {
        $staffLimited = $_POST['staffLimited'];
        $staffOrder = $_POST['staffOrder'];

        $result = filter_staff_data_In_Database($staffLimited, $staffOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter salary
    if ($action == 'load-salary-Data') {
        $salaryLimited = $_POST['salaryLimited'];
        $salaryOrder = $_POST['salaryOrder'];
        $salaryDate = $_POST['salaryDate'];

        $result = filter_salary_data_In_Database($salaryLimited, $salaryOrder, $salaryDate);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter Admin
    if ($action == 'load-admin-Data') {
        $adminLimited = $_POST['adminLimited'];
        $adminOrder = $_POST['adminOrder'];

        $result = filter_admin_data_In_Database($adminLimited, $adminOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter Attendence
    if ($action == 'load-attendence-Data') {
        $attendenceLimited = $_POST['attendenceLimited'];
        $attendenceOrder = $_POST['attendenceOrder'];

        $result = filter_attendence_data_In_Database($attendenceLimited, $attendenceOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter Expence
    if ($action == 'load-expence-Data') {
        $expenceLimited = $_POST['expenceLimited'];
        $expenceOrder = $_POST['expenceOrder'];
        $expenceDate = $_POST['expenceDate'];

        $result = filter_expence_data_In_Database($expenceLimited, $expenceOrder, $expenceDate);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // Filter Income
    if ($action == 'load-income-Data') {
        $incomeLimited = $_POST['incomeLimited'];
        $incomeOrder = $_POST['incomeOrder'];
        $memberIncomeDate = $_POST['memberIncomeDate'];

        $result = filter_income_data_In_Database($incomeLimited, $incomeOrder, $memberIncomeDate);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter category
    if ($action == 'load-category-Data') {
        $categoryLimited = $_POST['categoryLimited'];
        $categoryOrder = $_POST['categoryOrder'];

        $result = filter_category_data_In_Database($categoryLimited, $categoryOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - members remaining days subscription voice
    if ($action == 'searching-remaining_days-membership') {
        $selectRemainingMembership = $_POST['selectRemainingMembership'];
        $remainingMembershipMonth = $_POST['remainingMembershipMonth'];
        $remainingPaginationLimit = $_POST['remainingPaginationLimit'];
        $remainingValidationDays = $_POST['remainingValidationDays'];

        $result = filter_remaining_days_membership($selectRemainingMembership, $remainingMembershipMonth, $remainingPaginationLimit, $remainingValidationDays);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - members recently joining subscription voice
    if ($action == 'searching-recently_joining-membership') {
        $recentlyMembershipMonth = $_POST['recentlyMembershipMonth'];
        $recentlyPaginationLimit = $_POST['recentlyPaginationLimit'];
        $membershipRecentlyDays = $_POST['membershipRecentlyDays'];
        $recentlyValidationDays = $_POST['recentlyValidationDays'];

        $result = filter_recently_joining_membership($recentlyMembershipMonth, $recentlyPaginationLimit, $membershipRecentlyDays, $recentlyValidationDays);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - members end days subscription voice
    if ($action == 'searching-end_days-membership') {
        $selectEndMembership = $_POST['selectEndMembership'];
        $endMembershipMonth = $_POST['endMembershipMonth'];
        $endPaginationLimit = $_POST['endPaginationLimit'];

        $result = filter_end_days_membership($selectEndMembership, $endMembershipMonth, $endPaginationLimit);

        $response = array('data' => $result);
        echo json_encode($response);
    }

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
    if ($action == 'expense-Pagination-Search') {
        $expencePaginationMonth = $_POST['expencePaginationMonth'];
        $expencePaginationLimit = $_POST['expencePaginationLimit'];

        $result = filter_expence_pagination($expencePaginationMonth, $expencePaginationLimit);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - total income month wise
    if ($action == 'search-month_wise-income') {
        $searchTotalIncome = $_POST['searchIncome'];

        $result = search_month_wise_income($searchTotalIncome);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - total expence month wise
    if ($action == 'search-month_wise-expence') {
        $searchTotalExpence = $_POST['searchExpense'];

        $result = search_month_wise_expence($searchTotalExpence);

        $response = array('data' => $result);
        echo json_encode($response);
    }

    // filter index-page - total salary month wise
    if ($action == 'search-month_wise-salary') {
        $searchTotalSalary = $_POST['searchSalary'];

        $result = search_month_wise_salary($searchTotalSalary);

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
    if ($action == 'load-member_view_deposit-Data') {
        $memberDepositDate = $_POST['memberDepositDate'];
        $memberDepositLimited = $_POST['memberDepositLimited'];
        $memberDepositOrder = $_POST['memberDepositOrder'];

        $result = filter_member_deposit_pagination($memberDepositDate, $memberDepositLimited, $memberDepositOrder);

        $response = array('data' => $result);
        echo json_encode($response);
    }

}
