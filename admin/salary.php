<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================= Delete salary code page (salary-details)[delete_salary]  ========================
if (isset($_GET['salary_delete_id'])) {
    $salary_id = mysqli_real_escape_string($conn, $_GET['salary_delete_id']);

    $delete_salary = "DELETE FROM `salary` WHERE `salary_id` = '$salary_id'";

    $delete_salary_res = mysqli_query($conn, $delete_salary);

    if ($delete_salary_res) {
        $_SESSION['update_message_salary'] = "salary Deleted Successfully";
        header("location: salary");
        exit();
    } else {
        $_SESSION['error_update_message_salary'] = "This Inome Not Deleted";
        header("location: salary");
        exit();
    }
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
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="salarySearch" placeholder="username &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-salary" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Add Salary
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['update_message_salary'])) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            ' . $_SESSION['update_message_salary'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        unset($_SESSION['update_message_salary']);
    }
    if (isset($_SESSION['error_update_message_salary'])) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ' . $_SESSION['error_update_message_salary'] . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
        unset($_SESSION['error_update_message_salary']);
    }
    ?>
    <!-- / Alert -->


    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-header">
                    Staff Salary
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="me-2">
                        <input type="date" id="salary-date" class="form-control" onchange="load_salary_Data()">
                    </div>
                    <div class="me-2">
                        <select id="salary-limit" class="form-select" onchange="load_salary_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="div">
                        <select id="salary-order" class="form-select" onchange="load_salary_Data()">
                            <option value="ASC">Old</option>
                            <option value="DESC">New</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Username</th>
                        <th>Mobile Number</th>
                        <th>Total Salary</th>
                        <th>pay Salary</th>
                        <th>Remaining Salary</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="salaryDetails">
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
        $('#salarySearch').on('keyup', function() {
            var salarySearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    salarySearch: salarySearch
                },
                success: function(data) {
                    $('#salaryDetails').html(data);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_salary_Data();

    });

    function load_salary_Data() {

        let salaryLimited = $("#salary-limit").val();
        let salaryOrder = $("#salary-order").val();
        let salaryDate = $("#salary-date").val();

        console.log(salaryLimited, salaryOrder);

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-salary-Data',
                salaryLimited: salaryLimited,
                salaryOrder: salaryOrder,
                salaryDate: salaryDate
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#salaryDetails").html(response.data);
            },
        });
    }
</script>