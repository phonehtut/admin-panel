<?php
// Start the session
session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

// Include database connection
include '../../dbconnect/dbconn.php';
include '../header.php';

// Check if form is submitted for adding
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $status = $_POST['status'];
    $role = $_POST['role'];

    // Add new student
    $sql = "INSERT INTO member (name, email, password, status, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $password, $status, $role);

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful addition
        header("Location: /member.php?new_success=true");
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
    <title>Add Member</title>
</head>

<body>
    <h3 class="text-center py-5">Add Member</h3>
    <div class="container-fulid">
        <form method="post" action="">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="class" class="form-label">Role</label>
                            <select class="form-select" id="role" aria-label="Default select example" name="role">
                                <option value="" selected disabled>--Select Role--</option>
                                <option value="server admin">Server Admin</option>
                                <option value="social team">Social Team</option>
                                <option value="developer">Developer</option>
                            </select>
                        </div>
                        <input type="hidden" name="status" value="inactive">
                        <input type="submit" class="btn btn-primary" value="Add">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div>
    </form>

    <?php include '../include/footer.php'; ?>
</body>

</html>