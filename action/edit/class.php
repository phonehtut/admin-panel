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

// Check if ID parameter is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to the student list page if ID parameter is not provided
    header("Location: /class.php");
    exit();
}

// Initialize variables
$id = $_GET['id'];
$name = '';
$remark = '';
$error_message = ''; // Define the error message variable

// Retrieve student information from the database
$sql = "SELECT * FROM class WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $remark = $row['remark'];
} else {
    // Redirect to the student list page if student not found
    header("Location: /class.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $remark = $_POST['remark'];

        // Update student information in the database
        $sql = "UPDATE class SET name=?, remark=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $remark, $id);

        if ($stmt->execute()) {
            // Redirect back to the student list page after successful update
            header("Location: /class?edit_success=true");
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
    <title>Edit Student</title>
</head>

<body>
    <h3 class="text-center py-5">Update Class</h3>
    <div class="container-fulid">
        <form method="post" action="" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="batch_name" class="form-label">Class Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <textarea class="form-control" placeholder="Leave a comment here" id="remark" name="remark" style="height: 100px"><?php echo $remark ?></textarea>
                        </div>
                        <input type="submit" class="btn btn-success" value="update">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div>
    </form>

    <?php include '/include/footer.php'; ?>
</body>

</html>