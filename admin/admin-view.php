<?php
session_start();
include_once('../includes/config.php');
include_once('../includes/functions.php');

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'Admin') {
    // Redirect to login page
    header('location: ../login');
}

include_once('inc/header.php');
include_once('inc/sidebar.php');
include_once('inc/navbar.php');


if (isset($_GET['view_admin'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['view_admin']);

    // Inner joining
    $select_query = mysqli_query($conn, "SELECT users.user_id, users.username, users.email, users.password,
    users_detail.users_detail_id, users_detail.full_name, users_detail.Phone, users_detail.address, users_detail.gender, 
    users_detail.age, users_detail.city, users_detail.country, users_detail.image, users_detail.created_date,
    role.role_id, role.name
    FROM users 
    INNER JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id
    LEFT JOIN role ON role.role_id = users.role_id
    WHERE users.user_id = '$edit_id';
    ");

    $check = mysqli_num_rows($select_query);

    if ($check > 0) {
        $fetch_admin = mysqli_fetch_assoc($select_query);


?>


        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Header -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="user-profile-header-banner">
                            <img src="../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top">
                        </div>
                        <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                <img src="../media/images/<?= $fetch_admin['image'] ?>" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded-circle user-profile-img">
                            </div>
                            <div class="flex-grow-1 mt-3 mt-sm-5">
                                <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                    <div class="user-profile-info">
                                        <h4><?= $fetch_admin['full_name'] ?></h4>
                                        <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-user'></i> <?= $fetch_admin['name'] ?>
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-map-pin'></i> <?= $fetch_admin['city'] . ', ' . $fetch_admin['country'] ?>
                                            </li>
                                            <li class="list-inline-item d-flex gap-1">
                                                <i class='ti ti-calendar'></i> Joined <?= $fetch_admin['created_date'] ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->

            <div class="row">

                <form action="all-db-code.php" method="POST" id="adminForm" enctype="multipart/form-data">
                    <!-- Contact Information -->
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">
                                Contact Information
                            </h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="" class="form-label">Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" hidden type="text" id="admin_id" name="admin_id" value="<?= $fetch_admin['user_id']; ?>" />
                                        <input class="form-control" readonly type="text" placeholder="Name" id="full_name" name="full_name" value="<?= $fetch_admin['full_name']; ?>" />
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="phone_no" class="form-label">Phone Number
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="phone_no" readonly name="phone_no" class="form-control" placeholder="Phone Number" value="<?= $fetch_admin['Phone']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="address" class="form-label">Address
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="address" readonly name="address" placeholder="Address" class="form-control" value="<?= $fetch_admin['address']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="gender" class="form-label">Gender
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <select id="gender" name="gender" readonly class="form-control">
                                                <option value="<?= $fetch_admin['gender']; ?>"><?= $fetch_admin['gender']; ?></option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="age" class="form-label">Age
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="age" name="age" readonly placeholder="Age" class="form-control" value="<?= $fetch_admin['age']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" id="city" name="city" readonly placeholder="City" class="form-control" value="<?= $fetch_admin['city']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" id="country" readonly name="country" placeholder="Country" class="form-control" value="<?= $fetch_admin['country']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Login Information -->
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <h3 class="card-header">
                                Login Information
                            </h3>
                            <hr class="my-4 mt-0">
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="username" class="form-label">Username
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" id="username" readonly name="username" placeholder="Username" class="form-control" value="<?= $fetch_admin['username']; ?>">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <label for="email" class="form-label">Email
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" readonly placeholder="abc@example.com" class="form-control" value="<?= $fetch_admin['email']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


            </div>


            <!-- Submit Button  -->
            <div class="row">
                <div class="col-12 btm-group">
                    <a type="button" href="admin-details" class="btn btn-danger text-white">Back</a>
                </div>
            </div>



        </div>
        <!-- / Content -->
<?php
    }
}
?>
<script src="../assets/js/custom/addAdminError.js"></script>
<?php
include_once('inc/footer.php');
?>