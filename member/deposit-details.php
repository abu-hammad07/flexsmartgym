<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');


if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Member') {
    // Redirect to login page
    header('location: ../login');
}


include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-12 text-end mt-3 mt-md-0">
                <a href="income-deposit" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Deposit
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_update_deposit'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_update_deposit'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_update_deposit']);
    }
    if (isset($_SESSION['error_update_deposit'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_deposit'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_deposit']);
    }
    ?>
    <!-- / Alert -->

    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-header">
                    Deposit Details
                </h4>
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
    <!-- Membership Details -->


</div>
<!-- / Content -->




<?php
include_once('inc/footer.php');
?>




<script>
    $(document).ready(function() {
        $('#incomeSearch').on('keyup', function() {
            var incomeSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    incomeSearch: incomeSearch
                },
                success: function(data) {
                    $('#incomeDetails').html(data);
                }
            });
        });
    });
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
                action: 'load-member_deposit-Data',
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