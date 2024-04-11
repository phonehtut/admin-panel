<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../header.php';
include '../../dbconnect/dbconn.php';

// Check if ID parameter is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to the student list page if ID parameter is not provided
    header("Location: /batch.php");
    exit();
}

// Initialize variables
$id = $_GET['id'];
$name = '';
$email = '';
$password = '';
$status = '';
$role = '';
$error_message = ''; // Define the error message variable

// Retrieve student information from the database
$sql = "SELECT * FROM member WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $password = $row['password'];
    $status = $row['status'];
    $role = $row['role'];
} else {
    // Redirect to the student list page if student not found
    header("Location: /member.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    
    // Check if a new password was provided
    if (!empty($_POST['password'])) {
        // Hash the password using bcrypt for stronger security
        $password = md5($_POST['password']);
    }
    
    $status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');
    $role = htmlspecialchars($_POST['role'], ENT_QUOTES, 'UTF-8');
    
    // Prepare the SQL statement to update the member's information in the database
    if (!empty($_POST['password'])) {
        // If a new password was provided, include it in the update query
        $sql = "UPDATE member SET name = ?, email = ?, password = ?, status = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $password, $status, $role, $id);
    } else {
        // If no new password was provided, exclude it from the update query
        $sql = "UPDATE member SET name = ?, email = ?, status = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $status, $role, $id);
    }

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect back to the member list page after successful update
        header("Location: /member?edit_success=true");
        exit();
    } else {
        // Display error message if update fails
        $error_message = "Error: " . $stmt->error;
        // Optionally, you can log the error message or display it
        echo $error_message;
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
    <title>Edit Member</title>
</head>

<body>
    <h3 class="text-center py-5">Edit Member</h3>
    <div class="container-fulid">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                        <div class=" col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="" disabled>--Select Status--</option>
                                <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Active</option>
                                <option value="inactive" <?php if ($status == 'inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role">
                            <option value="" disabled>--Select Status--</option>
                                <option value="active" <?php if ($status == 'server admin') echo 'selected'; ?>>Server Admin ( Full Access )</option>
                                <option value="social team" <?php if ($status == 'social team') echo 'selected'; ?>>Social Team ( Normal Access )</option>
                                <option value="developer" <?php if ($status == 'developer') echo 'selected'; ?>>Developer ( Expened Access )</option>
                            </select>
                        </div>
                        <input type="submit" class="btn btn-success" value="update">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div>
    </form>

    <?php include '../../include/footer.php'; ?>
</body>

</html>