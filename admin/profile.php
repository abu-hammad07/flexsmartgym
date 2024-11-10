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

$user_select = "SELECT users.*, role.name, users_detail.* FROM `users` 
INNER JOIN users_detail ON users.users_detail_id = users_detail.users_detail_id 
INNER JOIN role ON role.role_id = users.role_id
WHERE `users`.`user_id` = '{$_SESSION['UID']}'";
$result = mysqli_query($conn, $user_select);
$row_num = mysqli_num_rows($result);

while ($row = mysqli_fetch_assoc($result)) {

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
                            <img src="../media/images/<?= $row['image']; ?>" alt="user image" class="d-block h-auto ms-0 ms-sm-4 rounded-circle user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4><?= $row['full_name']; ?></h4>
                                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item d-flex gap-1">
                                            <i class='ti ti-color-swatch'></i> <?php echo $row['name']; ?>
                                        </li>
                                        <li class="list-inline-item d-flex gap-1">
                                            <i class='ti ti-map-pin'></i> <?= $row['address']; ?>
                                        </li>
                                        <li class="list-inline-item d-flex gap-1">
                                            <i class='ti ti-calendar'></i> Joined Fabruary <?= $row['created_date']; ?>
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

        <!-- Default Wizard -->
        <div class="col-12 mb-4">
            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#account-details">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">
                                <i class="ti ti-user-scan"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Profile</span>
                            </span>
                        </button>
                    </div>
                    <!-- <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#personal-info">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">
                                <i class="ti ti-calendar-month"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Attendence</span>
                            </span>

                        </button>
                    </div>
                    <div class="line">
                        <i class="ti ti-chevron-right"></i>
                    </div>
                    <div class="step" data-target="#social-links">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle">
                                <i class="ti ti-coin-filled"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Salary</span>
                            </span>
                        </button>
                    </div> -->
                </div>
                <div class="bs-stepper-content">
                    <form onSubmit="return false">
                        <!-- Profile -->
                        <div id="account-details" class="content">
                            <div class="row g-3 mt-2">
                                <form action="">
                                    <div class="row g-2">
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="" class="form-label">Full Name</label>
                                            <input readonly class="form-control" type="text" placeholder="Full Name" id="full_name" name="full_name" value="<?= $row['full_name']; ?>" />
                                            <span class="inter error text-danger" id="full_name_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="phone_no" class="form-label">Phone Number</label>
                                            <input readonly type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone Number" value="<?= $row['Phone']; ?>">
                                            <span class="inter error text-danger" id="phone_no_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <input readonly type="text" id="address" name="address" placeholder="Address" class="form-control" value="<?= $row['address']; ?>">
                                            <span class="inter error text-danger" id="erorr_address"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <input readonly type="text" id="gender" name="gender" placeholder="Gender" class="form-control" value="<?= $row['gender']; ?>">
                                            <span class="inter error text-danger" id="gender_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input readonly type="text" id="age" name="age" placeholder="Age" class="form-control" value="<?= $row['age']; ?>">
                                            <span class="inter error text-danger" id="age_error"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input readonly type="text" id="city" name="city" placeholder="City" class="form-control" value="<?= $row['city'] ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="country" class="form-label">Country</label>
                                            <input readonly type="text" id="country" name="country" placeholder="Country" class="form-control" value="<?= $row['country'] ?>">
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="username" class="form-label">Username
                                                
                                            </label>
                                            <input readonly type="text" id="username" name="username" placeholder="Username" class="form-control" value="<?= $row['username'] ?>">
                                            <span class="inter error text-danger" id="username_err"></span>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input readonly type="email" id="email" name="email" placeholder="abc@example.com" class="form-control" value="<?= $row['email'] ?>">
                                            <span class="inter error text-danger" id="erorr_email"></span>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-6 border">
                                            <h5 class="mb-3 mt-3 text-center border-bottom pb-4 text-uppercase text-bold fs-5">
                                                Personal Details</h5>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">ID:</span>
                                                <span class="text-muted">00<?= $row['user_id']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 fw-bold me-3">Name:</span>
                                                <span class="text-muted"><?= $row['full_name']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 fw-bold me-3">Age:</span>
                                                <span class="text-muted"><?= $row['age']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 fw-bold me-3">Role:</span>
                                                <span class="text-muted"><?= $row['name']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 fw-bold me-3">Gender:</span>
                                                <span class="text-muted"><?= $row['gender']; ?></span>
                                            </div>
                                        </div>

                                        <div class="col-md-6 border">
                                            <h5 class="mb-3 mt-3 text-center border-bottom pb-4 text-uppercase text-bold fs-5">
                                                Contact Information</h5>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">Mobile Number:</span>
                                                <span class="text-muted"><?= $row['Phone']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">Email:</span>
                                                <span class="text-muted"><?= $row['email']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">Address:</span>
                                                <span class="text-muted"><?= $row['address']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">City:</span>
                                                <span class="text-muted"><?= $row['city']; ?></span>
                                            </div>
                                            <div class="mb-3">
                                                <span class="fs-5 me-3 fw-bold">Status:</span>
                                                <span class="text-muted"><?= $row['status']; ?></span>
                                            </div>

                                        </div>
                                    </div> -->
                                </form>
                                <!-- End Form -->

                            </div>
                        </div>
                        <!-- Attendence -->
                        <div id="personal-info" class="content">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h4 class="card-header">Attendence</h4>
                                </div>
                                <div class="col-md-6 text-end card-header">
                                    <div class="btn-group">
                                        <div class="me-2">
                                            <select id="" class="form-select">
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select id="" class="form-select">
                                                <option value="Jan">Jan</option>
                                                <option value="Feb">Feb</option>
                                                <option value="Mar">Mar</option>
                                                <option value="Apr">April</option>
                                                <option value="May">May</option>
                                                <option value="Jun">Jun</option>
                                                <option value="July">July</option>
                                                <option value="Aug">Aug</option>
                                                <option value="Sep">Sep</option>
                                                <option value="Oct">Oct</option>
                                                <option value="Nov">Nov</option>
                                                <option value="Dec">Dec</option>
                                            </select>
                                        </div>
                                        <!-- <div class="div">
                                                            <select id="membership-limit" class="form-select">
                                                                <option value="Class Every Week">ASC</option>
                                                                <option value="Class Every Month">DSC</option>
                                                            </select>
                                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Day</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td>1</td>
                                                <td>20-02-2024</td>
                                                <td>Saturday</td>
                                                <td><span class="badge bg-label-success me-1">Present</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>21-02-2024</td>
                                                <td>Sunday</td>
                                                <td><span class="badge bg-label-danger me-1">Absent</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>23-02-2024</td>
                                                <td>Monday</td>
                                                <td><span class="badge bg-label-info me-1">Leave</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Salary -->
                        <div id="social-links" class="content">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h4 class="card-header">Salary</h4>
                                </div>
                                <div class="col-md-6 text-end card-header">
                                    <div class="btn-group">
                                        <div class="me-2">
                                            <select id="" class="form-select">
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                            </select>
                                        </div>
                                        <div class="me-2">
                                            <select id="" class="form-select">
                                                <option value="Jan">Jan</option>
                                                <option value="Feb">Feb</option>
                                                <option value="Mar">Mar</option>
                                                <option value="Apr">April</option>
                                                <option value="May">May</option>
                                                <option value="Jun">Jun</option>
                                                <option value="July">July</option>
                                                <option value="Aug">Aug</option>
                                                <option value="Sep">Sep</option>
                                                <option value="Oct">Oct</option>
                                                <option value="Nov">Nov</option>
                                                <option value="Dec">Dec</option>
                                            </select>
                                        </div>
                                        <!-- <div class="div">
                                                            <select id="membership-limit" class="form-select">
                                                                <option value="Class Every Week">ASC</option>
                                                                <option value="Class Every Month">DSC</option>
                                                            </select>
                                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Total Fees</th>
                                                <th class="text-center">Month</th>
                                                <th class="text-center">Condition</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td>1</td>
                                                <td class="text-center">Youssef</td>
                                                <td class="text-center">100000</td>
                                                <td class="text-center">January</td>
                                                <td class="text-center"><span class="badge bg-label-success me-1">Pay</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td class="text-center">Ahmed</td>
                                                <td class="text-center">150000</td>
                                                <td class="text-center">February</td>
                                                <td class="text-center"><span class="badge bg-label-danger me-1">Did't
                                                        Pay</span></td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td class="text-center">Abrar</td>
                                                <td class="text-center">34000</td>
                                                <td class="text-center">March</td>
                                                <td class="text-center"><span class="badge bg-label-success me-1">Pay</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td class="text-center">Youssef</td>
                                                <td class="text-center">50000</td>
                                                <td class="text-center">April</td>
                                                <td class="text-center"><span class="badge bg-label-danger me-1">Did't
                                                        Pay</span></td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td class="text-center">Anus</td>
                                                <td class="text-center">150000</td>
                                                <td class="text-center">May</td>
                                                <td class="text-center"><span class="badge bg-label-success me-1">Pay</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td class="text-center">Youssef</td>
                                                <td class="text-center">100000</td>
                                                <td class="text-center">June</td>
                                                <td class="text-center"><span class="badge bg-label-danger me-1">Did't
                                                        Pay</span></td>
                                                <td class="text-center">
                                                    <div class="group">
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Edit">
                                                            <i class="ti ti-pencil me-1 text-success"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="View">
                                                            <i class="ti ti-eye me-1 text-info"></i>
                                                        </a>
                                                        <a class="" href="javascript:void(0);" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Delete">
                                                            <i class="ti ti-trash me-1 text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Default Wizard -->



    </div>
    <!-- / Content -->

<?php
}

include_once('inc/footer.php');
?>