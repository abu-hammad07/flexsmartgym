<?php
include "config.php";
// ===================================================
// =============count function in index page===============
// =====================================================
function validate($input)
{
   return $input;
}
//  get Count members function in index page
function get_Count_members()
{
   global $conn;
   // $roleName = validate($roleName); // Use the validate function

   $query = "SELECT role.name FROM users 
   LEFT JOIN role ON role.role_id = users.role_id WHERE role.name = 'Member'";
   $result = mysqli_query($conn, $query);

   if (!$result) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }
   $totalCount = mysqli_num_rows($result);
   return $totalCount;
}


//  get Count members function in index page
function get_Count_staff()
{
   global $conn;
   // $roleName = validate($roleName); // Use the validate function

   $query = "SELECT user_id FROM users LEFT JOIN role ON role.role_id = users.role_id WHERE role.name = 'Staff'";
   $result = mysqli_query($conn, $query);

   if (!$result) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }
   $totalCount = mysqli_num_rows($result);
   return $totalCount;
}

// Function to get total income count from both sources
function get_total_combined_income()
{
   global $conn;

   // Get the current month and year
   $current_month = date('m');
   $current_year = date('Y');

   // Set the start and end date of the current month
   $start_date = "$current_year-$current_month-01";
   $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

   // Get total income from income table for the current month
   $query1 = "SELECT SUM(pay_fees) AS total_income FROM `income` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
   $result1 = mysqli_query($conn, $query1);

   if (!$result1) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }

   $row1 = mysqli_fetch_assoc($result1);
   $total_income_1 = $row1['total_income'];

   // Get total income from user_details table for the current month
   $query2 = "SELECT SUM(users_detail.admission_fees) AS total_income FROM `users`
   LEFT JOIN users_detail ON users_detail.users_detail_id = users.users_detail_id 
   WHERE users_detail.created_date BETWEEN '$start_date' AND '$end_date'";
   $result2 = mysqli_query($conn, $query2);

   if (!$result2) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }

   $row2 = mysqli_fetch_assoc($result2);
   $total_income_2 = $row2['total_income'];

   // Calculate the combined total income for the current month
   $combined_total_income = $total_income_1 + $total_income_2;

   // Format the combined total income amount with commas
   return number_format($combined_total_income);
}


// // get total expense count function in index page
function get_total_expense() {
   global $conn;

   // Get the current month and year
   $current_month = date('m');
   $current_year = date('Y');

   // Set the start and end date of the current month
   $start_date = "$current_year-$current_month-01";
   $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

   // Get total expenses from expense table for the current month
   $query = "SELECT SUM(expense_amount) AS total_expense FROM `expense` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
   $result = mysqli_query($conn, $query);

   if (!$result) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }

   $row = mysqli_fetch_assoc($result);

   // Format the total expense amount with commas
   return number_format($row['total_expense']);
}


// // get total salary count function in index page
function get_total_salary() {
   global $conn;

   // Get the current month and year
   $current_month = date('m');
   $current_year = date('Y');

   // Set the start and end date of the current month
   $start_date = "$current_year-$current_month-01";
   $end_date = date('Y-m-t', strtotime($start_date)); // Get the last day of the current month

   // Get total salary expenses from salary table for the current month
   $query = "SELECT SUM(pay_salary) AS total_salary FROM `salary` WHERE created_date BETWEEN '$start_date' AND '$end_date'";
   $result = mysqli_query($conn, $query);

   if (!$result) {
      // Handle query error, if any
      return "Error: " . mysqli_error($conn);
   }

   $row = mysqli_fetch_assoc($result);

   // Format the total salary amount with commas
   return number_format($row['total_salary']);
}