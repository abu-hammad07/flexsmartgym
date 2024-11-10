<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}


if (isset($_GET['edit_feture_id'])) {
    $edit_feture_id = mysqli_real_escape_string($conn, $_GET['edit_feture_id']);


    $sql = "SELECT * FROM fetures WHERE id = '$edit_feture_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $getRow = mysqli_fetch_assoc($result);

        $get_feture_id = $getRow['id'];
        $get_feture_name = $getRow['feture_name'];
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
    if (isset($_SESSION['success_message_fetures'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['success_message_fetures'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        unset($_SESSION['success_message_fetures']);
    }
    if (isset($_SESSION['error_message_fetures'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $_SESSION['error_message_fetures'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        unset($_SESSION['error_message_fetures']);
    }
    ?>

    <div class="row">
        <div class="col-md-5 col-sm-12 mb-4">
            <div class="card" style="height: 300px;">
                <h4 class="card-header">
                    <?php
                    if (isset($_GET['edit_feture_id'])) {
                        echo 'Edit Feature';
                    }else{
                        echo 'Add Feature';
                    }
                    ?>
                </h4>
                <form action="all-db-code.php" method="POST" id="add_fetures_form">
                    <div class="card-body">
                        <!-- Interested Name -->
                        <div class="mb-3">
                            <input type="text" name="get_feture_id" value="<?php echo $get_feture_id ?>" hidden>
                            <label for="fetures" class="col-form-label">Add Feature
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="text" placeholder="Enter Feature Name" id="fetures" name="fetures" value="<?php if (isset($_GET['edit_feture_id'])) {
                                                                                                                                            echo $get_feture_name;
                                                                                                                                        } else {
                                                                                                                                            echo '';
                                                                                                                                        } ?>" />
                            <span class="inter error text-danger" id="fetures_error"></span>
                        </div>
                        <!-- Submit Button  -->
                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary" id="fetures_save" name="<?php if (isset($_GET['edit_feture_id'])) {
                                                                                                        echo 'update_fetures';
                                                                                                    } else {
                                                                                                        echo 'fetures_save';
                                                                                                    } ?>"><?php if (isset($_GET['edit_feture_id'])) {
                                                                                                                echo 'Update';
                                                                                                            } else {
                                                                                                                echo 'Save';
                                                                                                            } ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Interested List -->
        <div class="col-md-7 col-sm-12">
            <div class="card overflow-hidden mb-4" style="height: 700px;">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-header">
                            Feature List
                        </h4>
                    </div>
                    <div class="col-md-6 text-end card-header">
                        <div class="btn-group">
                            <div class="me-2">
                                <select id="ferures-limit" class="form-select" onchange="load_fetures_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="div">
                                <select id="ferures-order" class="form-select" onchange="load_fetures_Data()">
                                    <option value="ASC">Old</option>
                                    <option value="DESC">New</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="featuresList">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Feature Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="feturesList">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Interested List -->
    </div>

</div>
<!-- / Content -->



<script src="../assets/js/custom/feturesError.js"></script>
<?php
include_once('inc/footer.php');
?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_fetures_Data();

    });

    function load_fetures_Data() {

        let feruresLimited = $("#ferures-limit").val();
        let feturesOrder = $("#ferures-order").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-fetures-Data',
                feruresLimited: feruresLimited,
                feturesOrder: feturesOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#feturesList").html(response.data);
            },
        });
    }
</script>
