<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


// ======================= Delete Member code page (member-details)[delete_member_id]  ========================
if (isset($_GET['delete_member_id'])) {
    $member_id = mysqli_real_escape_string($conn, $_GET['delete_member_id']);

    // Select users_detail_id from users table
    $select_user_id = "SELECT users_detail_id FROM users WHERE user_id = '$member_id'";
    $select_user_id_res = mysqli_query($conn, $select_user_id);

    // Then delete from users table
    $delete_from_users = "DELETE FROM `users` WHERE `user_id` = '$member_id'";
    $delete_users_res = mysqli_query($conn, $delete_from_users);

    if ($delete_users_res) {

        if (mysqli_num_rows($select_user_id_res) > 0) {
            $user_id = mysqli_fetch_assoc($select_user_id_res);
            $users_detail_id = $user_id['users_detail_id'];

            // Delete from users_detail table first
            $delete_from_details = "DELETE FROM `users_detail` WHERE `users_detail_id` = '$users_detail_id'";
            $delete_details_res = mysqli_query($conn, $delete_from_details);

            if ($delete_details_res) {
                $_SESSION['update_message_member'] = "Member Deleted Successfully";
            } else {
                $_SESSION['error_update_member'] = "This Member Not Deleted";
            }
        } else {
            $_SESSION['error_update_member'] = "Error deleting member details";
        }
    } else {
        $_SESSION['error_update_member'] = "Member not found";
    }



    header("location: members-details");
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
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="membersSearch" placeholder="Username &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div>
            <!-- <div class="col-md-4 col-xl-3">
                <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5 word-spacing-2px" id="input-search" placeholder="Phone Number &nbsp;..." />
                    <i class="ti ti-search position-absolute top-50 start-1 translate-middle-y fs-6 mx-3"></i>
                </form>
            </div> -->
            <div class="col-md-8 col-xl-9 text-end mt-3 mt-md-0">
                <a href="add-member" class="btn btn-info waves-effect waves-light">
                    <i class="ti ti-plus me-2"></i> Member
                </a>
            </div>
        </div>
    </div>

    <!-- Alert -->
    <?php
    if (isset($_SESSION['update_message_member'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . $_SESSION['update_message_member'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['update_message_member']);
    }
    if (isset($_SESSION['error_update_member'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . $_SESSION['error_update_member'] . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        unset($_SESSION['error_update_member']);
    }
    ?>


    <!-- Membership Details -->
    <div class="card mt-4">
        <div class="row">
            <div class="col-md-6">
                <h4 class="card-header">
                    Members Details
                </h4>
            </div>
            <div class="col-md-6 text-end card-header">
                <div class="btn-group">
                    <div class="me-2">
                        <select id="members-limit" class="form-select" onchange="load_members_Data()">
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="75">75</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="div">
                        <select id="members-order" class="form-select" onchange="load_members_Data()">
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
                    <tr Class="text-center">
                        <th>#</th>
                        <th Class="text-start">Username</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Membership</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" id="membersDetails">
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
        $('#membersSearch').on('keyup', function() {
            var membersSearch = $(this).val();

            $.ajax({
                type: 'POST',
                url: 'searching.php',
                data: {
                    membersSearch: membersSearch
                },
                success: function(data) {
                    $('#membersDetails').html(data);
                }
            });
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_members_Data();

    });

    function load_members_Data() {

        let membersLimited = $("#members-limit").val();
        let membersOrder = $("#members-order").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-members-Data',
                membersLimited: membersLimited,
                membersOrder: membersOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#membersDetails").html(response.data);
            },
        });
    }
</script>