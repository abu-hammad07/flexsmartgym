<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================= Delete Membership code page (Membership-details)[delete_subscrip]  ========================
// if (isset($_GET['delete_membership_id'])) {

//     $membership_id = mysqli_real_escape_string($conn, $_GET['delete_membership_id']);

//     $check_membershipID = "SELECT membership_id FROM `users_detail` WHERE `membership_id` = '$membership_id'";
//     $check_membershipID_res = mysqli_query($conn, $check_membershipID);

//     if (mysqli_num_rows($check_membershipID_res) > 0) {
//         // If membership ID exists in users_detail table, set error message and redirect
//         $_SESSION['error_update_subscrip'] = "This Membership cannot be deleted because it is already in use.";
//         header("location: membership-details");
//         exit();
//     } else {

//         $delete_subscrip = "DELETE FROM `membership` WHERE `membership_id` = '$membership_id'";
//         $delete_subscrip_res = mysqli_query($conn, $delete_subscrip);

//         if ($delete_subscrip_res) {
//             $_SESSION['success_update_subscrip'] = "Membership Deleted Successfully";
//             header("location: membership-details");
//             exit();
//         } else {
//             $_SESSION['error_update_subscrip'] = "This Membership could not be deleted.";
//             header("location: membership-details");
//             exit();
//         }
//     }
// }



include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');
?>

<!-- Content -->

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_update_subscrip'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_update_subscrip'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_update_subscrip']);
    }
    if (isset($_SESSION['error_update_subscrip'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_subscrip'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_subscrip']);
    }
    ?>

    <div class="card card-body mb-4">
        <div class="row">
            <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="subscription-search" placeholder="Name &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-membership" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Membership
                </a>
            </div>
        </div>
    </div>

    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-header">
                    Membership Details
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="me-2">
                        <select id="subscription-limit" class="form-select" onchange="load_subscription_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="div">
                        <select id="subscription-order" class="form-select" onchange="load_subscription_Data()">
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
                        <th>Amount</th>
                        <th>Validation days</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="subscriptionDetails">

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
        $('#subscription-search').on('keyup', function() {
            var subscriptionSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    subscriptionSearch: subscriptionSearch
                },
                success: function(data) {
                    $('#subscriptionDetails').html(data);
                }
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_subscription_Data();

    });

    function load_subscription_Data() {

        let subscriptionLimited = $("#subscription-limit").val();
        let subscriptionOrder = $("#subscription-order").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-subscription-Data',
                subscriptionLimited: subscriptionLimited,
                subscriptionOrder: subscriptionOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#subscriptionDetails").html(response.data);
            },
        });
    }
</script>