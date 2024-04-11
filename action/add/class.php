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
    $remark = $_POST['remark'];

    // Add new student
    $sql = "INSERT INTO class (name, remark) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $remark);

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful addition
        header("Location: /class.php?new_success=true");
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
    <title>Add Batch</title>
</head>

<body>
    <h3 class="text-center py-5">Add Class</h3>
    <div class="container-sm">
        <form method="post" action="" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="class_name" class="form-label">Class Name</label>
                            <input type="text" class="form-control" id="class_name" name="name">
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