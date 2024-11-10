<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================= Delete Admin code page (admin-details)[delete_admin_id]  ========================
if (isset($_GET['delete_admin_id'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['delete_admin_id']);

    // First, delete related rows in the salary table
    $delete_from_salary = "DELETE FROM `salary` WHERE `users_id` = '$member_id'";
    $delete_salary_res = mysqli_query($conn, $delete_from_salary);

    if ($delete_salary_res || mysqli_affected_rows($conn) == 0) {
        // Then, delete the row from the users table
        $delete_from_users = "DELETE FROM `users` WHERE `user_id` = '$member_id'";
        $delete_users_res = mysqli_query($conn, $delete_from_users);

        if ($delete_users_res) {
            $_SESSION['success_update_admin'] = "Admin Deleted Successfully";
        } else {
            $_SESSION['error_update_admin'] = "Error deleting Admin";
        }
    } else {
        $_SESSION['error_update_admin'] = "Error deleting salary records";
    }

    header("location: admin-details");
    exit();
}



include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="adminSearch" placeholder="Username &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-admin" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_update_admin'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_update_admin'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_update_admin']);
    }
    if (isset($_SESSION['error_update_admin'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_admin'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_admin']);
    }
    ?>

    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-header">
                    Admin Details
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="btn-group">
                        <div class="me-2">
                            <select id="admin-limit" class="form-select" onchange="load_admin_Data()">
                                <option value="15">15</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="div">
                            <select id="admin-order" class="form-select" onchange="load_admin_Data()">
                                <option value="ASC">Old</option>
                                <option value="DESC">New</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th class="text-start">Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="adminDetails">
                </tbody>
            </table>
        </div>
    </div>
    <!-- Membership Details -->


</div>
<!-- / Content -->




<?php
include_once('inc/footer.php');
?>

<script>
    $(document).ready(function() {
        $('#adminSearch').on('keyup', function() {
            var adminSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    adminSearch: adminSearch
                },
                success: function(data) {
                    $('#adminDetails').html(data);
                }
            });
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_admin_Data();

    });

    function load_admin_Data() {

        let adminLimited = $("#admin-limit").val();
        let adminOrder = $("#admin-order").val();

        console.log(adminLimited, adminOrder);

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-admin-Data',
                adminLimited: adminLimited,
                adminOrder: adminOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#adminDetails").html(response.data);
            },
        });
    }
</script>