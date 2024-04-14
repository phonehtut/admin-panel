<?php
// Database connection
require_once '../dbconnect/dbconn.php';

// Query to count users registered in each month
$query = "SELECT DATE_FORMAT(start_date, '%Y-%m') AS month, COUNT(*) AS user_count
          FROM users
          GROUP BY month";

// Execute the query
$result = $conn->query($query);

// Prepare an array to hold the counts
$monthlyCounts = [];

// Fetch the results and format them as an associative array
while ($row = $result->fetch_assoc()) {
    // Format the month for readability (e.g., "2023-01" to "January 2023")
    $monthFormatted = date("F Y", strtotime($row['month']));
    $monthlyCounts[$monthFormatted] = $row['user_count'];
}

// Close the database connection
$conn->close();

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode($monthlyCounts);
?>
