<?php
require_once('config.php');

// =============== Date And Time =============== //
// date_default_timezone_set('America/New_York');
date_default_timezone_set('Asia/Karachi');

// =============== Users Table =============== //
function createUsersTable()
{
    global $conn;

    $tableName = "users";
    $successMessages = [];
    $warnings = [];
    $errors = [];

    // Check if the table already exists
    $checkTableQuery = mysqli_query($conn, "SHOW TABLES LIKE '$tableName'");

    if (mysqli_num_rows($checkTableQuery) > 0) {
        $warnings[] = "Table already exists: $tableName";
    } else {
        // Create the users table if it doesn't exist
        $createTableQuery = "CREATE TABLE $tableName (
            id INT PRIMARY KEY AUTO_INCREMENT,
            f_name VARCHAR(50) NOT NULL,
            l_name VARCHAR(50),
            username VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            token VARCHAR(255),
            image VARCHAR(255),
            phone VARCHAR(50),
            address VARCHAR(255),
            city VARCHAR(50),
            state VARCHAR(50),
            zipcode VARCHAR(20),
            country VARCHAR(100),
            role VARCHAR(50),
            status VARCHAR(50),
            login_time VARCHAR(50),
            logout_time VARCHAR(50),
            created_by VARCHAR(100),
            created_date VARCHAR(100),
            updated_by VARCHAR(100),
            updated_date VARCHAR(100)
        );";

        if (mysqli_query($conn, $createTableQuery)) {
            $successMessages[] = "Table created successfully: <strong>$tableName</strong>";
        } else {
            $errors[] = "Error creating table: " . mysqli_error($conn);
        }
    }

    // Define table columns with data types
    $tableColumns = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'f_name' => 'VARCHAR(50) NOT NULL',
        'l_name' => 'VARCHAR(50)',
        'username' => 'VARCHAR(100) NOT NULL',
        'email' => 'VARCHAR(100) NOT NULL UNIQUE',
        'password' => 'VARCHAR(255)NOT NULL',
        'token' => 'VARCHAR(255)',
        'image' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(50)',
        'address' => 'VARCHAR(255)',
        'city' => 'VARCHAR(50)',
        'state' => 'VARCHAR(50)',
        'zipcode' => 'VARCHAR(20)',
        'country' => 'VARCHAR(100)',
        'role' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'login_time' => 'VARCHAR(50)',
        'logout_time' => 'VARCHAR(50)',
        'created_by' => 'VARCHAR(100)',
        'created_date' => 'VARCHAR(100)',
        'updated_by' => 'VARCHAR(100)',
        'updated_date' => 'VARCHAR(100)',
    ];

    // Check and add missing columns
    foreach ($tableColumns as $column => $dataType) {
        $checkColumnQuery = "SHOW COLUMNS FROM $tableName LIKE '$column'";
        $result = mysqli_query($conn, $checkColumnQuery);

        if (mysqli_num_rows($result) == 0) {
            $addColumnQuery = "ALTER TABLE $tableName ADD $column $dataType";

            if (mysqli_query($conn, $addColumnQuery)) {
                $successMessages[] = "Column added successfully: <strong>$column</strong>";
            } else {
                $errors[] = "Error adding column: $column";
            }
        }
    }

    // Check if the table has any rows
    $checkRowsQuery = "SELECT COUNT(*) AS count FROM $tableName";
    $result = mysqli_query($conn, $checkRowsQuery);
    $row = mysqli_fetch_assoc($result);
    $rowCount = $row['count'];

    // Demo user passwords and tokens
    $demoUserPasswords = [
        'admin' => password_hash("admin123", PASSWORD_DEFAULT),
        'customer' => password_hash("customer123", PASSWORD_DEFAULT),
        'employee' => password_hash("employee123", PASSWORD_DEFAULT)
    ];

    $demoUserTokens = array_map('bin2hex', array_map('random_bytes', array_fill(0, 3, 15)));

    // Insert demo users if the table is empty
    if ($rowCount == 0) {
        $currentDateTime = date('Y-m-d H:i:s');

        foreach (['admin', 'customer', 'employee'] as $role) {
            $addDemoUserQuery = "INSERT INTO $tableName (f_name, l_name, username, email, password, role, token, image, status, created_by, created_date)
                VALUES ('$role', 'user', '{$role}_user', '{$role}@gmail.com', '{$demoUserPasswords[$role]}', '$role', '{$demoUserTokens[$role]}', 'assets/img/avatars/{$role}.jpg', 'offline', 'System', '$currentDateTime')";

            if (mysqli_query($conn, $addDemoUserQuery)) {
                $successMessages[] = "Demo $role added to the <strong>$tableName</strong> table.";
            } else {
                $errors[] = "Error adding demo $role: " . mysqli_error($conn);
            }
        }
    } else {
        $errors[] = "Demo admin was not added because the <strong>$tableName</strong> table is not empty.";
    }
?>

    <div class="container my-4">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body m-0 p-0">
                        <h2 class="text-center mt-2">User Table</h2>
                        <hr>
                        <?php
                        foreach ($successMessages as $successMessage) {
                            echo '<div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                                    <strong>Success - </strong> ', $successMessage, '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }

                        foreach ($warnings as $warning) {
                            echo '<div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
                                    <strong>Warning - </strong> ', $warning, '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }

                        foreach ($errors as $error) {
                            echo '<div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                                    <strong>Error - </strong> ', $error, '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}


// =============== Admin Table =============== //
function createAdminTable()
{
    global $conn;

    $admin_table_name = "admin";

    $check_admin_table_result = mysqli_query($conn, "SHOW TABLES LIKE '$admin_table_name'");

    if (mysqli_num_rows($check_admin_table_result) > 0) {
        $warnings[] = "Table already exists: $admin_table_name";
    } else {
        $create_table_query = "CREATE TABLE $admin_table_name (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            token VARCHAR(255),
            image VARCHAR(255),
            status VARCHAR(50),
            login_time VARCHAR(50),
            logout_time VARCHAR(50),
            created_by VARCHAR(100),
            created_date VARCHAR(100),
            updated_by VARCHAR(100),
            updated_date VARCHAR(100)
        );";

        if (mysqli_query($conn, $create_table_query)) {
            $success[] = "Table created successfully: <strong> $admin_table_name </strong>";
        } else {
            $errors[] = "Error creating table: " . mysqli_error($conn);
        }
    }

    // Define the tables and their columns with data types
    $admin_table_columns = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(100) NOT NULL',
        'email' => 'VARCHAR(50) NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL',
        'token' => 'VARCHAR(255)',
        'image' => 'VARCHAR(255)',
        'status' => 'VARCHAR(50)',
        'login_time' => 'VARCHAR(50)',
        'logout_time' => 'VARCHAR(50)',
        'created_by' => 'VARCHAR(100)',
        'created_date' => 'VARCHAR(100)',
        'updated_by' => 'VARCHAR(100)',
        'updated_date' => 'VARCHAR(100)',
        // Add more tables and their columns as needed
    ];

    // Check and add missing columns
    foreach ($admin_table_columns as $column => $dataType) {
        $checkColumnQuery = "SHOW COLUMNS FROM $admin_table_name LIKE '$column'";
        $result = mysqli_query($conn, $checkColumnQuery);

        if (mysqli_num_rows($result) == 0) {
            $addColumnQuery = "ALTER TABLE $admin_table_name ADD $column $dataType";

            if (mysqli_query($conn, $addColumnQuery)) {
                $success[] = "Column added successfully: <strong> $column </strong>";
            } else {
                $errors[] = "Error adding column: $column";
            }
        }
    }

    // Check if the table has any rows
    $checkRowsQuery = "SELECT COUNT(*) as count FROM $admin_table_name";
    $result = mysqli_query($conn, $checkRowsQuery);
    $row = mysqli_fetch_assoc($result);
    $rowCount = $row['count'];

    $hashed_password = password_hash("admin123", PASSWORD_DEFAULT);

    $token = bin2hex(random_bytes(15));

    if ($rowCount == 0) {
        // Table has 0 rows, so insert the demo admin
        $currentDateTime = date('Y-m-d H:i:s');
        $addDemoAdminQuery = "INSERT INTO $admin_table_name (name, email, password,token, image, status, created_by, created_date)
            VALUES ('admin', 'admin@gmail.com', '$hashed_password','$token' ,'assets/img/avatars/male.jpg', 'offline', 'System', '$currentDateTime')";

        if (mysqli_query($conn, $addDemoAdminQuery)) {
            $success[] = "Demo admin added to the <strong>$admin_table_name</strong> table.";
        } else {
            $errors[] = "Error adding demo admin: " . mysqli_error($conn);
        }
    } else {
        $errors[] = "Demo admin was not added because the <strong>$admin_table_name</strong> table is not empty.";
    }
?>
    <!-- <div class="container my-4">
        <div class="row"> -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body m-0 p-0">
                <h2 class="text-center mt-2">Admin Table</h2>
                <hr>
                <?php
                if (isset($success)) {
                    foreach ($success as $success) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                            <strong>Success - </strong> <?php echo $success; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($warnings)) {
                    foreach ($warnings as $warnings) {
                ?>
                        <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
                            <strong>Warning - </strong> <?php echo $warnings; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($errors)) {
                    foreach ($errors as $errors) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                            <strong>Error - </strong> <?php echo $errors; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
            </div>
        </div>
    </div>
    <!-- </div>
    </div> -->
<?php
}

// =============== Customer Table =============== //
function createCustomerTable()
{
    global $conn;

    $customer_table_name = "customer";

    $check_customer_table_result = mysqli_query($conn, "SHOW TABLES LIKE '$customer_table_name'");

    if (mysqli_num_rows($check_customer_table_result) > 0) {
        $warnings[] = "Table already exists: $customer_table_name";
    } else {
        $create_table_query = "CREATE TABLE $customer_table_name (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(50) NOT NULL,
            email VARCHAR(100) UNIQUE,
            password varchar(255) NOT NULL,
            token varchar(255),
            phone VARCHAR(20),
            address VARCHAR(255),
            city VARCHAR(50),
            state VARCHAR(50),
            zip_code VARCHAR(20),
            country VARCHAR(50),
            status VARCHAR(50),
            login_time varchar(50),
            logout_time varchar(50),
            created_by VARCHAR(100),
            created_date VARCHAR(100),
            updated_by VARCHAR(100),
            updated_date VARCHAR(100)
        );";

        if (mysqli_query($conn, $create_table_query)) {
            $success[] = "Table created successfully: <strong> $customer_table_name </strong>";
        } else {
            $errors[] = "Error creating table: " . mysqli_error($conn);
        }
    }

    // Define the tables and their columns with data types
    $customer_table_columns = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(100) NOT NULL',
        'email' => 'VARCHAR(50) NOT NULL',
        'password' => 'VARCHAR(255) NOT NULL',
        'token' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(255)',
        'address' => 'VARCHAR(50)',
        'city' => 'VARCHAR(50)',
        'state' => 'VARCHAR(50)',
        'zip_code' => 'VARCHAR(50)',
        'country' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'login_time' => 'VARCHAR(50)',
        'logout_time' => 'VARCHAR(50)',
        'created_by' => 'VARCHAR(100)',
        'created_date' => 'VARCHAR(100)',
        'updated_by' => 'VARCHAR(100)',
        'updated_date' => 'VARCHAR(100)',
        // Add more tables and their columns as needed
    ];

    // Check and add missing columns
    foreach ($customer_table_columns as $column => $dataType) {
        $checkColumnQuery = "SHOW COLUMNS FROM $customer_table_name LIKE '$column'";
        $result = mysqli_query($conn, $checkColumnQuery);

        if (mysqli_num_rows($result) == 0) {
            $addColumnQuery = "ALTER TABLE $customer_table_name ADD $column $dataType";

            if (mysqli_query($conn, $addColumnQuery)) {
                $success[] = "Column added successfully: <strong> $column </strong>";
            } else {
                $errors[] = "Error adding column: $column";
            }
        }
    }

    // Check if the table has any rows
    $checkRowsQuery = "SELECT COUNT(*) as count FROM $customer_table_name";
    $result = mysqli_query($conn, $checkRowsQuery);
    $row = mysqli_fetch_assoc($result);
    $rowCount = $row['count'];

    $hashed_password = password_hash("customer123", PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(15));

    if ($rowCount == 0) {
        // Table has 0 rows, so insert the demo admin
        $currentDateTime = date('Y-m-d H:i:s');
        $hashed_password = password_hash("customer123", PASSWORD_DEFAULT);

        $addDemoCustomerQuery = "INSERT INTO $customer_table_name (name, email, password, phone, address, city, state, zip_code, country, status, login_time, created_by, created_date)
            VALUES ('John Doe', 'customer@gmail.com', '$hashed_password', '$token','+1234567890', '123 Main St', 'Cityville', 'Stateville', '12345', 'Countryland', 'online', '$currentDateTime','System', '$currentDateTime')";

        if (mysqli_query($conn, $addDemoCustomerQuery)) {
            $success[] = "Demo customer added to the <strong>$customer_table_name</strong> table.";
        } else {
            $errors[] = "Error adding demo customer: " . mysqli_error($conn);
        }
    } else {
        $errors[] = "Demo customer was not added because the <strong>$customer_table_name</strong> table is not empty.";
    }

?>
    <!-- <div class="container my-4">
        <div class="row"> -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body m-0 p-0">
                <h2 class="text-center mt-2">User Table</h2>
                <hr>
                <?php
                if (isset($success)) {
                    foreach ($success as $success) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                            <strong>Success - </strong> <?php echo $success; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($warnings)) {
                    foreach ($warnings as $warnings) {
                ?>
                        <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
                            <strong>Warning - </strong> <?php echo $warnings; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($errors)) {
                    foreach ($errors as $errors) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                            <strong>Error - </strong> <?php echo $errors; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
            </div>
        </div>
    </div>
    <!-- </div>
    </div> -->
<?php
}

// =============== Login Attempt Table =============== //
function createLoginAttemptTable()
{
    global $conn;

    $login_attempt_table_name = "login_attempt";

    $check_customer_table_result = mysqli_query($conn, "SHOW TABLES LIKE '$login_attempt_table_name'");

    if (mysqli_num_rows($check_customer_table_result) > 0) {
        $warnings[] = "Table already exists: $login_attempt_table_name";
    } else {
        $create_table_query = "CREATE TABLE $login_attempt_table_name(
            id INT AUTO_INCREMENT PRIMARY KEY,
            url varchar(255),
            ip_address varchar(50),
            try_time varchar(50)
        );";

        if (mysqli_query($conn, $create_table_query)) {
            $success[] = "Table created successfully: <strong> $login_attempt_table_name </strong>";
        } else {
            $errors[] = "Error creating table: " . mysqli_error($conn);
        }
    }

    // Define the tables and their columns with data types
    $login_attempt_table_columns = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'url' => 'VARCHAR(255)',
        'ip_address' => 'VARCHAR(50)',
        'try_time' => 'VARCHAR(50)',
        // Add more tables and their columns as needed
    ];

    // Check and add missing columns
    foreach ($login_attempt_table_columns as $column => $dataType) {
        $checkColumnQuery = "SHOW COLUMNS FROM $login_attempt_table_name LIKE '$column'";
        $result = mysqli_query($conn, $checkColumnQuery);

        if (mysqli_num_rows($result) == 0) {
            $addColumnQuery = "ALTER TABLE $login_attempt_table_name ADD $column $dataType";

            if (mysqli_query($conn, $addColumnQuery)) {
                $success[] = "Column added successfully: <strong> $column </strong>";
            } else {
                $errors[] = "Error adding column: $column";
            }
        }
    }

?>
    <!-- <div class="container my-4">
        <div class="row"> -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-body m-0 p-0">
                <h2 class="text-center mt-2">Login Attempt</h2>
                <hr>
                <?php
                if (isset($success)) {
                    foreach ($success as $success) {
                ?>
                        <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                            <strong>Success - </strong> <?php echo $success; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($warnings)) {
                    foreach ($warnings as $warnings) {
                ?>
                        <div class="alert alert-warning alert-dismissible fade show m-4" role="alert">
                            <strong>Warning - </strong> <?php echo $warnings; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
                <?php
                if (isset($errors)) {
                    foreach ($errors as $errors) {
                ?>
                        <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                            <strong>Error - </strong> <?php echo $errors; ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                <?php
                    };
                };
                ?>
            </div>
        </div>
    </div>
    <!-- </div>
    </div> -->
<?php
}


// Call the function with the connection parameter
echo createUsersTable();
// echo createAdminTable();
// echo createCustomerTable();
echo createLoginAttemptTable();


// Close the connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database - Run</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>