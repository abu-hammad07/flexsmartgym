<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================= Delete Attendence code page (Attendence-details)[attend_delete_id]  ========================
if (isset($_GET['attend_delete_id'])) {
    $attend_id = mysqli_real_escape_string($conn, $_GET['attend_delete_id']);

    $delete_attendence = "DELETE FROM `attendence` WHERE `attend_id` = '$attend_id'";

    $delete_attendence_res = mysqli_query($conn, $delete_attendence);

    if ($delete_attendence_res) {
        $_SESSION['success_update_attendence'] = "Attendence Deleted Successfully";
        header("location: attendence-details");
        exit();
    } else {
        $_SESSION['error_update_attendence'] = "Failed to Delete Attendence";
        header("location: attendence-details");
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
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="attendence-search" placeholder="Username &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-attendence" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Attendence
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['success_update_attendence'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['success_update_attendence'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['success_update_attendence']);
    }
    if (isset($_SESSION['error_update_attendence'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_attendence'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_attendence']);
    }
    ?>
    <!-- / Alert -->

    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">

            <div class="col-md-6">
                <h4 class="card-header">
                    Attendence Details
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="me-2">
                        <select id="attendence-limit" class="form-select" onchange="load_attendence_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="div">
                        <select id="attendence-order" class="form-select" onchange="load_attendence_Data()">
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
                        <th>Phone Number</th>
                        <th>Role Type</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="attendenceDetails">
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
        $('#attendence-search').on('keyup', function() {
            var attendenceSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    attendenceSearch: attendenceSearch
                },
                success: function(data) {
                    $('#attendenceDetails').html(data);
                }
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_attendence_Data();

    });

    function load_attendence_Data() {

        let attendenceLimited = $("#attendence-limit").val();
        let attendenceOrder = $("#attendence-order").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-attendence-Data',
                attendenceLimited: attendenceLimited,
                attendenceOrder: attendenceOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#attendenceDetails").html(response.data);
            },
        });
    }
</script>
