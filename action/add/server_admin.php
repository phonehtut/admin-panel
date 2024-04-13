<?php
// Start the session
session_start();

// Only Access For Role is Founder and Server Admin
if (!isset($_SESSION['email']) || 
    $_SESSION['status'] !== 'active' || 
    ($_SESSION['role'] !== 'server admin' && $_SESSION['role'] !== 'founder')) {
    // Set an error message in the session
    $_SESSION['error_message'] = 'You do not have permission to access this page.';

    // Display a JavaScript alert and then redirect back to the previous page
    echo "<script>";
    echo "alert('You do not have permission to access this page.');";
    echo "window.history.back();";
    echo "</script>";
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../../dbconnect/dbconn.php';
include '../header.php';

// Check if form is submitted for adding
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ip4 = $_POST['ip_address_4'];
    $ip6 = $_POST['ip_address_6'];
    $port = $_POST['port'];
    $database = $_POST['database_name'];
    $remark = $_POST['remark'];

    // Add new student
    $sql = "INSERT INTO server_admin_access (name, host, username, password, ip_address_4, ip_address_6, port, database_name, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisiss", $name, $host, $username, $password, $ip4, $ip6, $port, $database, $remark);    

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful addition
        header("Location: /server_admin.php?new_success=true");
        exit();
    } else {
        // Display error message if addition fails
        $error_message = "Error: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Access List</title>
</head>

<body>
    <h3 class="text-center py-5">Add Access List</h3>
    <div class="container-sm">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Access Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="host" class="form-label">Host Name</label>
                            <input type="text" class="form-control" id="host" name="host">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="usrname" class="form-label">Username</label>
                            <input type="text" class="form-control" id="usrname" name="username">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ip4" class="form-label">Internet Protocol Address ( v 4 )</label>
                            <input type="text" class="form-control" id="ip4" name="ip_address_4">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ip6" class="form-label">Internet Protocol Address ( v 6 )</label>
                            <input type="text" class="form-control" id="ip6" name="ip_address_6">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="port" class="form-label">Port Number</label>
                            <input type="number" class="form-control" id="port" name="port">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="database" class="form-label">Database Name</label>
                            <input type="text" class="form-control" id="database" name="database_name">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" placeholder="Leave a remark here" id="remark" name="remark" style="height: 100px"></textarea>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Add">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div>
    </form>

    <?php include '/include/footer.php'; ?>
</body>

</html>