<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

// ======================== Add category code page (category)[category_save]  ========================
if (isset($_POST['category_save'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category']);

    // Get the current date and time
    $created_date = date('Y-m-d');
    // Get the user's ID
    $created_by = $_SESSION['username'];
    // Get the user's ID
    $uid = $_SESSION['UID'];

    // check if category already exists
    $check_category = "SELECT exp_category_id, exp_category_name FROM `expense_category` WHERE `exp_category_name` = '$category_name'";
    $check_category_res = mysqli_query($conn, $check_category);
    if (mysqli_num_rows($check_category_res) > 0) {
        $_SESSION['error_message_category'] = "Category Already Exists ($category_name)";
        header('location: category');
        exit();
    }

    // Insert data into interested table
    $insert_category = "INSERT INTO `expense_category`(`exp_category_name`, `created_by`, `created_date`) 
    VALUES ('$category_name', '$created_by', '$created_date')";

    $insert_category_res = mysqli_query($conn, $insert_category);
    if ($insert_category_res) {
        $_SESSION['success_message_category'] = "Category Added Successfully ($category_name)";
        header('location: category');
        exit();
    } else {
        $_SESSION['error_message_category'] = "Category Not Added ($category_name)";
        header('location: category');
        exit();
    }
}


// ======================== Add category code page (category)[update_category]  ========================
if (isset($_POST['update_category'])) {

    $get_category_id = mysqli_real_escape_string($conn, $_POST['get_category_id']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category']);

    // Get the current date and time
    $updated_date = date('Y-m-d');
    // Get the user's ID
    $updated_by = $_SESSION['username'];
    // Get the user's ID
    $uid = $_SESSION['UID'];

    // check if category already exists
    $check_category = "SELECT * FROM `expense_category` WHERE `exp_category_name` = '$category_name' AND `exp_category_id` != '$get_category_id'";
    $check_category_res = mysqli_query($conn, $check_category);
    if (mysqli_num_rows($check_category_res) > 0) {
        $_SESSION['error_message_category'] = "Category Already Exists ($category_name)";
        header('location: category');
        exit();
    }

    // Insert data into interested table
    $insert_category = "UPDATE `expense_category` SET `exp_category_name`='$category_name',
    `updated_by`='$updated_by',`updated_date`='$updated_date' 
    WHERE `exp_category_id` = '$get_category_id'";

    $insert_category_res = mysqli_query($conn, $insert_category);
    if ($insert_category_res) {
        $_SESSION['success_message_category'] = "Category Updated Successfully ($category_name)";
        header('location: category');
        exit();
    } else {
        $_SESSION['error_message_category'] = "Category Not Updated ($category_name)";
        header('location: category');
        exit();
    }
}



// ======================= Edit Category code page (category-edit)[save_category]  ========================
if (isset($_GET['edit_category_id'])) {
    $edit_category_id = mysqli_real_escape_string($conn, $_GET['edit_category_id']);

    $sql = "SELECT exp_category_id, exp_category_name FROM expense_category WHERE exp_category_id = '$edit_category_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $getRow = mysqli_fetch_assoc($result);

        $get_category_id = $getRow['exp_category_id'];
        $get_category_name = $getRow['exp_category_name'];
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
    if (isset($_SESSION['success_message_category'])) {
        echo '<div id="successAlert" class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['success_message_category'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        unset($_SESSION['success_message_category']);
    }
    if (isset($_SESSION['error_message_category'])) {
        echo '<div id="errorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $_SESSION['error_message_category'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        unset($_SESSION['error_message_category']);
    }
    ?>

    <div class="row">
        <div class="col-md-5 col-sm-12 mb-4">
            <div class="card" style="height: 300px;">
                <h4 class="card-header">
                    <?php
                    if (isset($_GET['edit_category_id'])) {
                        echo 'Update Category';
                    } else {
                        echo 'Add Category';
                    }
                    ?>
                </h4>
                <form action="" method="POST" id="add_category_form">
                    <div class="card-body">
                        <!-- Interested Name -->
                        <div class="mb-3">
                            <input type="text" name="get_category_id" value="<?php echo $get_category_id ?>" hidden>
                            <label for="category" class="col-form-label">Add Category
                                <span class="text-danger">*</span>
                            </label>
                            <input class="form-control" type="text" placeholder="Category Name" id="category" name="category" value="<?php if (isset($get_category_name)) {
                                                                                                                                            echo $get_category_name;
                                                                                                                                        } ?>" />
                            <span class="inter error text-danger" id="category_error"></span>
                        </div>
                        <!-- Submit Button  -->
                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary" id="category_save" name="<?php if (isset($get_category_id)) {
                                                                                                        echo 'update_category';
                                                                                                    } else {
                                                                                                        echo 'category_save';
                                                                                                    } ?>"><?php if (isset($get_category_id)) {
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
                            Category
                        </h4>
                    </div>
                    <div class="col-md-6 text-end card-header">
                        <div class="btn-group">
                            <div class="me-2">
                                <select id="category-limit" class="form-select" onchange="load_category_Data()">
                                    <option value="15">15</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div class="div">
                                <select id="category-order" class="form-select" onchange="load_category_Data()">
                                    <option value="DESC">New</option>
                                    <option value="ASC">Old</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="categoryList">
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" id="categorydetails">
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




<script src="../assets/js/custom/categoryError.js"></script>
<?php
include_once('inc/footer.php');
?>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Load data on page load with default value (10)
        load_category_Data();

    });

    function load_category_Data() {

        let categoryLimited = $("#category-limit").val();
        let categoryOrder = $("#category-order").val();

        $.ajax({
            url: 'filter_fetch_data.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'load-category-Data',
                categoryLimited: categoryLimited,
                categoryOrder: categoryOrder
            },
            success: function(response) {
                console.log(response);
                // Update the result div with the loaded data
                $("#categorydetails").html(response.data);
            },
        });
    }
</script>