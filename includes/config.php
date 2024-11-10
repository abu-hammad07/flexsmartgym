<?php
// ------ (Hostinger) Server ------ //
// $server = "mysql";
// $username = "u423820677_flexsmartgym";
// $password = "B7x;BqOuF";
// $db = "u423820677_flexsmartgym";

// ------ (Localhost) Server ------ //
$server = "localhost";
$username = "root";
$password = "";
$db = "flexsmartgym";

$conn = mysqli_connect($server, $username, $password, $db);

if (!$conn) {
    die("Connection failed:" . mysqli_connect_error());
}
