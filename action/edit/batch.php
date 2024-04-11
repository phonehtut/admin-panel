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
    header("Location: /batch.php");
    exit();
}

// Initialize variables
$id = $_GET['id'];
$name = '';
$sd = '';
$ed = '';
$class = '';
$remark = '';
$error_message = ''; // Define the error message variable

// Retrieve student information from the database
$sql = "SELECT * FROM batch WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['batch_name'];
    $sd = $row['start_date'];
    $ed = $row['end_date'];
    $class = $row['class'];
    $remark = $row['remark'];
} else {
    // Redirect to the student list page if student not found
    header("Location: /batch.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['batch_name'];
    $sd = $_POST['start_date'];
    $ed = $_POST['end_date'];
    $class = $_POST['class'];
    $remark = $_POST['remark'];

        // Update student information in the database
        $sql = "UPDATE batch SET batch_name=?, start_date=?, end_date=?, class=?, remark=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $sd, $ed, $class, $remark, $id);

        if ($stmt->execute()) {
            // Redirect back to the student list page after successful update
            header("Location: /batch?edit_success=true");
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
    <h3 class="text-center py-5">Add Batch</h3>
    <div class="container-fulid">
        <form method="post" action="" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="batch_name" class="form-label">Batch Name</label>
                            <input type="text" class="form-control" id="batch_name" name="batch_name" value="<?php echo $name ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sd" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sd" name="start_date" value="<?php echo $sd ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ed" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="ed" name="end_date" value="<?php echo $ed ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="class" class="form-label">Class</label>
                            <select class="form-select" id="class" aria-label="Default select example" name="class">
                                <option value="" selected disabled>--Select Class--</option>
                                <?php
                                include '../../dbconnect/dbconn.php';

                                // Query to fetch unique class values from the 'class' column in the 'users' table
                                $sql = "SELECT class FROM batch";
                                $result = $conn->query($sql);

                                // Check for errors in query execution
                                if (!$result) {
                                    echo "Error: " . $conn->error;
                                } else {
                                    // Fetching data from the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $classValue = $row['class'];
                                            echo "<option value=\"$classValue\"";
                                            if ($class === $classValue) {
                                                echo " selected";
                                            }
                                            echo ">$classValue</option>";
                                        }
                                    } else {
                                        echo "No classes found";
                                    }
                                }
                                ?>
                            </select>
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
    <script src="/include/loader.js"></script>
    
    <?php include '../include/footer.php'; ?>
</body>

</html>