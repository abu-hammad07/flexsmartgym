<?php
session_start();
include_once('../includes/config.php');


function getSubscriptionData($searchTerm)
{
    global $conn; // Assuming $conn is your database connection variable

    $sql = "SELECT subscription.subscrip_id, subscription.subscrip_name, subscription.subscrip_amount, subscription.validation_days
            FROM subscription
            WHERE subscription.subscrip_name LIKE '%$searchTerm%'";

    $result = mysqli_query($conn, $sql);
    $data = '';
    $no = 1;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data .= '<tr class="text-center">
        <td>' . $no++ . '</td>
        <td>' . $row['subscrip_name'] . '</td>
        <td>' . $row['subscrip_amount'] . '</td>
        <td>' . $row['validation_days'] . '</td>
        <td>
        <a href="subscription-edit.php?edit_subscrip_id=' . $row['subscrip_id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
    </a>
    <a class="" href="subscription-view.php?view_subscrip=' . $row['subscrip_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
        <i class="ti ti-eye me-1 text-info"></i>
    </a>
    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteSubscrip_' . $row['subscrip_id'] . '" data-bs-placement="top" title="Delete">
        <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
    </button>
    <div class="modal fade" id="deleteSubscrip_' . $row['subscrip_id'] . '" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Subscription? Name (<span class="text-danger">' . $row['subscrip_name'] . '</span>)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <p>Please confirm that you want to delete your subscription. <br>
                        Once deleted, you won\'t be able to recover it. <br>
                        Please proceed with caution.
                    </p>
                </div>
                <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                    <a href="all-db-code.php?delete_subscrip_id=' . $row['subscrip_id'] . '" class="btn btn-danger" name="delete_subscrip">Delete</a>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
        </td>
    </tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center text-danger">No Data Found</tr>';
    }
    return $data;
}

function getMembersData($SearchMemberterm)
{
    global $conn;

    $memberSql = "SELECT * 
    FROM `users` INNER JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id` 
    WHERE `users`.`role` = 'Member' AND `users`.username LIKE '%$SearchMemberterm%'";
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
            <td> ' . $row['subscription'] . ' </td>
            <td>
                <div class="group">
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-pencil me-1 text-success"></i>
                    </a>
                    <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                        <i class="ti ti-eye me-1 text-info"></i>
                    </a>
                    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteMember' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                        <span><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteMember' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">' . $row['username'] . ' Do you want to delete this member? </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Confirm Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </td>
        </tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center text-danger">No Data Found</tr>';
    }
    return $data;
}


function getStaffData($SearchStaffterm)
{
    global $conn;

    $staffSql = "SELECT * 
    FROM `users` INNER JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id` 
    WHERE `users`.`role` = 'Staff' AND `users`.username LIKE '%$SearchStaffterm%'";
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
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-pencil me-1 text-success"></i>
                    </a>
                    <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                        <i class="ti ti-eye me-1 text-info"></i>
                    </a>
                    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteMember' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                        <span><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteMember' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">' . $row['username'] . ' Do you want to delete this member? </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Confirm Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </td>
        </tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center text-danger">No Data Found</tr>';
    }
    return $data;
}


function getAdminData($SearchAdminterm)
{
    global $conn;

    $adminSql = "SELECT * FROM `users` INNER JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id` 
    WHERE `users`.`role` = 'Admin' AND `users`.`username` LIKE '%" . mysqli_real_escape_string($conn, $SearchAdminterm) . "%'";
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
            <td> ' . $row['phone'] . ' </td>
            <td>
                <div class="group">
                    <a class="" href="member-edit.php?edit_member=' . $row['user_id'] . ' " data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                        <i class="ti ti-pencil me-1 text-success"></i>
                    </a>
                    <a class="" href="member-view.php?view_member=' . $row['user_id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                        <i class="ti ti-eye me-1 text-info"></i>
                    </a>
                    <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteMember' . $row['user_id'] . '" data-bs-placement="top" title="Delete">
                        <span><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
                    </button>
                    <div class="modal fade" id="deleteMember' . $row['user_id'] . '" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel1">' . $row['username'] . ' Do you want to delete this member? </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-danger">Confirm Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </td>
        </tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center text-danger">No Data Found</td></tr>';
    }
    return $data;
}



function getExpenceData($SearchExpenceterm)
{
    global $conn;

    $expenceSql = "SELECT expense.expense_id, expense.expense_name, category.category_name, expense.expense_amount, expense.expense_image 
    FROM `expense` LEFT JOIN category ON category.id = expense.category_id
    WHERE expense.expense_name LIKE '%" . mysqli_real_escape_string($conn, $SearchExpenceterm) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '<tr Class="text-center">
            <td>' . $no++ . '</td>
            <td>' . $row['expense_name'] . '</td>
            <td>' . $row['category_name'] . '</td>
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
        $data .= '<tr><td colspan="5" class="text-center text-danger">No Data Found</td></tr>';
    }
    return $data;
}



function get_Attendence_Data($SearchAdminTerm)
{
    global $conn;

    $expenceSql = "SELECT * FROM `attendence`
    WHERE attend_name LIKE '%" . mysqli_real_escape_string($conn, $SearchAdminTerm) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '
            <tr class="text-center">
                <td>' . $no++ . '</td>
                <td>' . $row['attend_name'] . '</td>
                <td>' . $row['attend_phone'] . '</td>
                <td>' . $row['attend_role'] . '</td>
                <td>' . $row['attend_date'] . '</td>
                <td>' . $row['attend_status'] . '</td>
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
                                    <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Attendence? Name: <span class="text-danger">' . $row['attend_name'] . '</span></h5>
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
        <td colspan="7" class="fw-semibold bg-light-warning text-warning text-center">There are no Attendence data matching this search.</td>
    </tr>';
    }
    return $data;
}


function getIncomeData($SearchIncomeTerm)
{
    global $conn;

    $expenceSql = "SELECT * FROM `income`
    WHERE name LIKE '%" . mysqli_real_escape_string($conn, $SearchIncomeTerm) . "%'";

    $expenceResult = mysqli_query($conn, $expenceSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($expenceResult) > 0) {
        while ($row = mysqli_fetch_assoc($expenceResult)) {
            $data .= '
            <tr class="text-center">
        <td>' . $no++ . '</td>
        <td>' . $row['name'] . '</td>
        <td>' . $row['phone_no'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['amount'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_fees'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_fees'] . '</span></td>
        <td>'. $row['monthly_date'] . '</td>
        <td>
            <a href="income-edit.php?income_edit_id=' . $row['id'] . '" class="border-0  rounded-2 p-0 py-1 bg-transparent">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit"><i class="ti ti-pencil me-1 text-success"></i></span>
            </a>
            <a class="" href="income-view.php?income_view_id=' . $row['id'] . '" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                <i class="ti ti-eye me-1 text-info"></i>
            </a>
            <button type="button" class="border-0  rounded-2 p-0 py-1 bg-transparent" data-bs-toggle="modal" data-bs-target="#deleteIncome' . $row['id'] . '" data-bs-placement="top" title="Delete">
                <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete"><i class="fs-5 ti ti-trash  text-danger p-1 "></i></span>
            </button>
            <div class="modal fade" id="deleteIncome' . $row['id'] . '" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Income? Name: <span class="text-danger">' . $row['name'] . '</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <p>Please confirm that you want to delete your Incometion. <br>
                                Once deleted, you won\'t be able to recover it. <br>
                                Please proceed with caution.
                            </p>
                        </div>
                        <div class="modal-footer justify-content-start" style="margin-top: -20px;">
                            <a href="?income_delete_id=' . $row['id'] . '" class="btn btn-danger" name="delete_Income">Delete</a>
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

    $staffSql = "SELECT * FROM `salary`
    WHERE `salary_name` LIKE '%$searchSalaryTerm%'";
    $staffResult = mysqli_query($conn, $staffSql);

    $data = '';
    $no = 1;
    if (mysqli_num_rows($staffResult) > 0) {
        while ($row = mysqli_fetch_assoc($staffResult)) {
            $data .= '
            <tr class="text-center">
        <td>' . $no++ . '</td>
        <td>' . $row['salary_name'] . '</td>
        <td>' . $row['salary_phone'] . '</td>
        <td><span class="badge bg-label-primary me-1">' . $row['salary_amount'] . '</span></td>
        <td><span class="badge bg-label-success me-1">' . $row['pay_salary'] . '</span></td>
        <td><span class="badge bg-label-danger me-1">' . $row['remaining_salary'] . '</span></td>
        <td>'. $row['monthly_date'] . '</td>
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
                            <h5 class="modal-title" id="exampleModalLabel1">Confirm Delete Income? Name: <span class="text-danger">' . $row['salary_name'] . '</span></h5>
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
        $data = '<tr><td colspan="6" class="text-center text-danger">No Data Found</td></tr>';
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
} elseif (isset($_POST['attendenceSearch'])) {
    $attendenceSearch = $_POST['attendenceSearch'];
    echo get_Attendence_Data($attendenceSearch);
} elseif (isset($_POST['expenceSearch'])) {
    $expenceSearch = $_POST['expenceSearch'];
    echo getExpenceData($expenceSearch);
} elseif (isset($_POST['incomeSearch'])) {
    $incomeSearch = $_POST['incomeSearch'];
    echo getIncomeData($incomeSearch);
} elseif (isset($_POST['salarySearch'])) {
    $salarySearch = $_POST['salarySearch'];
    echo getSalaryData($salarySearch);
}
