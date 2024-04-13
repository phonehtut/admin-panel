<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

// Include database connection
include '../header.php';
include '../../dbconnect/dbconn.php';

// Only Access For Role is Founder and Server Admin
if (
    !isset($_SESSION['email']) ||
    $_SESSION['status'] !== 'active' ||
    ($_SESSION['role'] !== 'server admin' && $_SESSION['role'] !== 'founder')
) {
    // Set an error message in the session
    $_SESSION['error_message'] = 'You do not have permission to access this page.';

    // Display a JavaScript alert and then redirect back to the previous page
    echo "<script>";
    echo "alert('You do not have permission to access this page.');";
    echo "window.history.back();";
    echo "</script>";
    exit();
}

// Initialize variables
$id = $_GET['id'];
$name = '';
$host = '';
$username = '';
$password = '';
$ip4 = '';
$ip6 = '';
$port = '';
$database = '';
$remark = '';
$error_message = ''; // Define the error message variable

// Retrieve student information from the database
$sql = "SELECT * FROM server_admin_access WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $host = $row['host'];
    $username = $row['username'];
    $password = $row['password'];
    $ip4 = $row['ip_address_4'];
    $ip6 = $row['ip_address_6'];
    $port = $row['port'];
    $database = $row['database_name'];
    $remark = $row['remark'];
} else {
    // Redirect to the student list page if student not found
    header("Location: /server_admin.php");
    exit();
}

// Check if form is submitted
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

    // Update student information in the database
    $sql = "UPDATE server_admin_access SET name=?, host=?, username=?, password=?, ip_address_4=?, ip_address_6=?, port=?, database_name=?, remark=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssissi", $name, $host, $username, $password, $ip4, $ip6, $port, $database, $remark, $id);

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful update
        header("Location: /server_admin?edit_success=true");
        exit();
    } else {
        // Display error message if update fails
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
    <title>Edit Access List</title>
</head>

<body>
    <h3 class="text-center py-5">Edit Access List</h3>
    <div class="container-fulid">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Access Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="host" class="form-label">Host Name</label>
                            <input type="text" class="form-control" id="host" name="host" value="<?php echo $host ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="usrname" class="form-label">Username</label>
                            <input type="text" class="form-control" id="usrname" name="username" value="<?php echo $username ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ip4" class="form-label">Internet Protocol Address ( v 4 )</label>
                            <input type="text" class="form-control" id="ip4" name="ip_address_4" value="<?php echo $ip4 ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ip6" class="form-label">Internet Protocol Address ( v 6 )</label>
                            <input type="text" class="form-control" id="ip6" name="ip_address_6" value="<?php echo $ip6 ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="port" class="form-label">Port Number</label>
                            <input type="number" class="form-control" id="port" name="port" value="<?php echo $port ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="database" class="form-label">Database Name</label>
                            <input type="text" class="form-control" id="database" name="database_name" value="<?php echo $database ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" placeholder="Leave a remark here" id="remark" name="remark" style="height: 100px"><?php echo $remark ?></textarea>
                        </div>
                        <input type="submit" class="btn btn-outline-primary" value="Update">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </form>
    </div>

    <?php include '/include/footer.php'; ?>
</body>

</html>