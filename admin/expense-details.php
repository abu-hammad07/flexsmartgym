<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================= Delete expense code page (expense-details)[expense_delete_id]  ========================
if (isset($_GET['expense_delete_id'])) {
    $expense_id = mysqli_real_escape_string($conn, $_GET['expense_delete_id']);

    $delete_expense = "DELETE FROM `expense` WHERE `expense_id` = '$expense_id'";
    $delete_expense_res = mysqli_query($conn, $delete_expense);

    if ($delete_expense_res) {
        $_SESSION['success_update_expense'] = "expense Deleted Successfully";
        header("location: expense-details");
        exit();
    } else {
        $_SESSION['error_update_expense'] = "This expense Not Deleted";
        header("location: expense-details");
        exit();
    }
}

include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_update_expense'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_update_expense'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_update_expense']);
    }
    if (isset($_SESSION['error_update_expense'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_expense'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_expense']);
    }
    ?>

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="expenceSearch" placeholder="Expense Name &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-expense" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Expense
                </a>
            </div>
        </div>
    </div>

    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-header">
                    Expense Details
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="me-2">
                        <input type="date" id="expence-date" class="form-control" onchange="load_expence_Data()">
                    </div>
                    <div class="me-2">
                        <select id="expence-limit" class="form-select" onchange="load_expence_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="div">
                        <select id="expence-order" class="form-select" onchange="load_expence_Data()">
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
                        <th>Name</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <!-- <th>Image</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="expenceDetails">
                </tbody>
            </table>
        </div>
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
        $('#expenceSearch').on('keyup', function() {
            var expenceSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    expenceSearch: expenceSearch
                },
                success: function(data) {
                    $('#expenceDetails').html(data);
                }
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_expence_Data();

    });

    function load_expence_Data() {

        let expenceLimited = $("#expence-limit").val();
        let expenceOrder = $("#expence-order").val();
        let expenceDate = $("#expence-date").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-expence-Data',
                expenceLimited: expenceLimited,
                expenceOrder: expenceOrder,
                expenceDate: expenceDate
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#expenceDetails").html(response.data);
            },
        });
    }
</script>