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
    $name = $_POST['batch_name'];
    $sd = $_POST['start_date'];
    $ed = $_POST['end_date'];
    $remark = $_POST['remark'];
    $class = $_POST['class'];

    // Add new student
    $sql = "INSERT INTO batch (batch_name, start_date, end_date, remark, class) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $sd, $ed, $remark, $class);

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful addition
        header("Location: /batch.php?new_success=true");
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
    <h3 class="text-center py-5">Add Batch</h3>
    <div class="container-fulid">
        <form method="post" action="" onsubmit="return validateForm()">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="batch_name" class="form-label">Batch Name</label>
                            <input type="text" class="form-control" id="batch_name" name="batch_name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sd" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="sd" name="start_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ed" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="ed" name="end_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="class" class="form-label">Class</label>
                            <select class="form-select" id="class" aria-label="Default select example" name="class">
                                <option value="" selected disabled>--Select Class--</option>
                                <?php
                                include '../../dbconnect/dbconn.php';

                                // Query to fetch unique class values from the 'class' column in the 'users' table
                                $sql = "SELECT name FROM class";
                                $result = $conn->query($sql);

                                // Check for errors in query execution
                                if (!$result) {
                                    echo "Error: " . $conn->error;
                                } else {
                                    // Fetching data from the result set
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            $classValue = $row['name'];
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
                            <textarea class="form-control" placeholder="Leave a comment here" id="remark" name="remark" style="height: 100px"></textarea>
                        </div>
                        <input type="submit" class="btn btn-success" value="Add">
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
    </div>
    </form>

    <?php include '../include/footer.php'; ?>
</body>

</html>