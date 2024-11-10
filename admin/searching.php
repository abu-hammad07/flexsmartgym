<?php
session_start();
include_once('../includes/config.php');



function getSubscriptionData($searchTerm)
{
    global $conn; // Assuming $conn is your database connection variable

    $sql = "SELECT * FROM membership
            WHERE membership_name LIKE '%$searchTerm%'";

    $result = mysqli_query($conn, $sql);
    $data = '';
    $no = 1;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data .= '<tr class="text-center">
        <td>' . $no++ . '</td>
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
    </tr>';
        }
    } else {
        echo '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Members data in the database. ' . $searchTerm . '</td>
    </tr>';
    }
    return $data;
}

function getMembersData($SearchMemberterm)
{
    global $conn;

    $memberSql = "SELECT users.user_id, users.username, users.email, users_detail.phone, users_detail.image, membership.membership_name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id 
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE role.name = 'Member'
    AND `users`.username LIKE '%$SearchMemberterm%'";
    $memberResult = mysqli_query($conn, $memberSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($memberResult) > 0) {
        while ($row = mysqli_fetch_assoc($memberResult)) {
            $data .= '<tr Class="text-center">
            <td>' . $no++ . '</td>
            <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                        <img src="../media/images/' . $row['image'] . ' " alt=" ' . $row['username'] . ' " class="rounded-circle">
                    </li>
                    <li> ' . $row['username'] . ' </li>
                </ul>
            </td>
            <td> ' . $row['email'] . ' </td>
            <td> ' . $row['phone'] . ' </td>
            <td> ' . $row['membership_name'] . ' </td>
            <td>
                <div class="group">
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-pencil me-1 text-success"></i>
                    </a>
                    <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                        <i class="ti ti-eye me-1 text-info"></i>
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
        </tr>';
        }
    } else {
        echo '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data from database. ' . $memberResult . '</td>
    </tr>';
    }
    return $data;
}


function getStaffData($SearchStaffterm)
{
    global $conn;

    $staffSql = "SELECT users.user_id, users.username, users.email, users_detail.phone, users_detail.image
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Staff'
    AND `users`.username LIKE '%$SearchStaffterm%'";
    $staffResult = mysqli_query($conn, $staffSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($staffResult) > 0) {
        while ($row = mysqli_fetch_assoc($staffResult)) {
            $data .= '<tr Class="text-center">
            <td>' . $no++ . '</td>
            <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                        <img src="../media/images/' . $row['image'] . ' " alt=" ' . $row['username'] . ' " class="rounded-circle">
                    </li>
                    <li> ' . $row['username'] . ' </li>
                </ul>
            </td>
            <td> ' . $row['email'] . ' </td>
            <td> ' . $row['phone'] . ' </td>
            <td>
                <div class="group">
                <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                    <i class="ti ti-eye me-1 text-info"></i>
                </a>
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
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
        </tr>';
        }
    } else {
        echo '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data from database. ' . $SearchStaffterm . '</td>
    </tr>';
    }
    return $data;
}


function getAdminData($SearchAdminterm)
{
    global $conn;

    $adminSql = "SELECT users.user_id, users_detail.full_name, users.username, users.email, users_detail.Phone, users_detail.image, role.name FROM users
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE role.name = 'Admin'
    AND `users`.`username` LIKE '%" . mysqli_real_escape_string($conn, $SearchAdminterm) . "%'";
    $adminResult = mysqli_query($conn, $adminSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($adminResult) > 0) {
        while ($row = mysqli_fetch_assoc($adminResult)) {
            $data .= '<tr Class="text-center">
            <td>' . $no++ . '</td>
            <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="Lilian Fuller">
                        <img src="../media/images/' . $row['image'] . ' " alt=" ' . $row['username'] . ' " class="rounded-circle">
                    </li>
                    <li> ' . $row['username'] . ' </li>
                </ul>
            </td>
            <td> ' . $row['email'] . ' </td>
            <td> ' . $row['Phone'] . ' </td>
            <td>
                <div class="group">
                <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                    <i class="ti ti-eye me-1 text-info"></i>
                </a>
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-pencil me-1 text-success"></i>
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
        </tr>';
        }
    } else {
        echo '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data from database. ' . $SearchAdminterm . '</td>
    </tr>';
    }
    return $data;
}



function getExpenceData($expenceSearch)
{
    global $conn;


    $expenceSql = "SELECT expense.expense_id, expense.expense_name, expense_category.exp_category_name, expense.expense_amount
    FROM expense
    LEFT JOIN expense_category ON expense_category.exp_category_id = expense.expense_category_id
    WHERE expense.expense_name LIKE '%" . mysqli_real_escape_string($conn, $expenceSearch) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '<tr Class="text-center">
            <td>' . $no++ . '</td>
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
                <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteexpense' . $row['expense_id'] . '" data-bs-placement="top" title="Delete">
                    <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                </button>
                <div class="modal fade" id="deleteexpense' . $row['expense_id'] . '" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete This (' . $row['expense_name'] . ')</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger">Confirm Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>';
        }
    } else {
        $data .= '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no matching data from database. ' . $expenceSearch . '</td>
    </tr>';
    }
    return $data;
}



function get_Attendence_Data($SearchAdminTerm)
{
    global $conn;

    $expenceSql = "SELECT users.username, users_detail.Phone, role.name as role, attendence.attend_id, attendence.attend_status, attendence.attend_date 
    FROM `attendence`
    INNER JOIN users ON users.user_id = attendence.users_id
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    INNER JOIN role ON role.role_id = users.role_id
    WHERE username LIKE '%" . mysqli_real_escape_string($conn, $SearchAdminTerm) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '
            <tr class="text-center">
                <td>' . $no++ . '</td>
                <td>' . $row['username'] . '</td>
                <td>' . $row['Phone'] . '</td>
                <td>' . $row['role'] . '</td>
                <td>' . $row['attend_date'] . '</td>
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
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Attendence? Name: <span class="text-danger">' . $row['username'] . '</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-start">
                                    <p>Please confirm that you want to delete your Incometion. <br>
                                        Once deleted, you won\'t be able to recover it. <br>
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
            </tr>

        ';
        }
    } else {
        $data .= '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Attendence data matching this search. ' . $SearchAdminTerm . '</td>
    </tr>';
    }
    return $data;
}


function getIncomeData($SearchIncomeTerm)
{
    global $conn;

    $expenceSql = "SELECT income_id,users.username,users_detail.Phone, membership.membership_amount, income.pay_fees, income.remaining_fees, income.pay_fees_date 
    FROM `income`
    LEFT JOIN users ON users.user_id = income.user_id
    LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN membership ON membership.membership_id = users_detail.membership_id
    WHERE users.username LIKE '%" . mysqli_real_escape_string($conn, $SearchIncomeTerm) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '
            <tr class="text-center">
        <td>' . $no++ . '</td>
        <td>' . $row['username'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['membership_amount'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_fees'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_fees'] . '</span></td>
        <td>' . $row['pay_fees_date'] . '</td>
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
    } else {
        $data .= '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Income data matching this search.</td>
    </tr>';
    }
    return $data;
}


function getSalaryData($searchSalaryTerm)
{
    global $conn;

    $staffSql = "SELECT users.username, 
    users_detail.Phone, users_detail.salary,
    salary.salary_id, salary.pay_salary, salary.remaining_salary, salary.monthly_date
        FROM salary 
        INNER JOIN users on users.user_id = salary.users_id
        INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
        LEFT JOIN role ON role.role_id = users.role_id
        WHERE users.username LIKE '%$searchSalaryTerm%'
        AND salary.users_id IN (SELECT user_id FROM users) 
    ";

    $staffResult = mysqli_query($conn, $staffSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($staffResult) > 0) {
        while ($row = mysqli_fetch_assoc($staffResult)) {
            $data .= '
            <tr class="text-center">
        <td>' . $no++ . '</td>
        <td>' . $row['username'] . '</td>
        <td>' . $row['Phone'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['salary'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_salary'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_salary'] . '</span></td>
        <td>' . $row['monthly_date'] . '</td>
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
    } else {
        $data = '<tr>
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Salary data matching this search.</td>
    </tr>';
    }
    return $data;
}




// Usage:
if (isset($_POST['subscriptionSearch'])) {
    $subscriptionSearch = $_POST['subscriptionSearch'];
    echo getSubscriptionData($subscriptionSearch);
} elseif (isset($_POST['membersSearch'])) {
    $membersSearch = $_POST['membersSearch'];
    echo getMembersData($membersSearch);
} elseif (isset($_POST['staffSearch'])) {
    $staffSearch = $_POST['staffSearch'];
    echo getStaffData($staffSearch);
} elseif (isset($_POST['adminSearch'])) {
    $adminSearch = $_POST['adminSearch'];
    echo getAdminData($adminSearch);
}
if (isset($_POST['attendenceSearch'])) {
    $attendenceSearch = $_POST['attendenceSearch'];
    echo get_Attendence_Data($attendenceSearch);
}
if (isset($_POST['expenceSearch'])) {
    $expenceSearch = $_POST['expenceSearch'];
    echo getExpenceData($expenceSearch);
} elseif (isset($_POST['incomeSearch'])) {
    $incomeSearch = $_POST['incomeSearch'];
    echo getIncomeData($incomeSearch);
} elseif (isset($_POST['salarySearch'])) {
    $salarySearch = $_POST['salarySearch'];
    echo getSalaryData($salarySearch);
}
