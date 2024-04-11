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
    header("Location: /student.php");
    exit();
}

// Initialize variables
$id = $_GET['id'];
$name = '';
$email = '';
$phone_number = '';
$birth_date = '';
$age = '';
$gender = '';
$class = '';
$batch = '';
$os_version = '';
$error_message = ''; // Define the error message variable

// Retrieve student information from the database
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if student exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    $birth_date = $row['birth_date'];
    $age = $row['age'];
    $gender = $row['gender'];
    $class = $row['Class'];
    $batch = $row['Batch'];
    $os_version = $row['os_version'];
} else {
    // Redirect to the student list page if student not found
    header("Location: /student.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $birth_date = $_POST['birth_date'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $batch = $_POST['batch'];
    $os_version = $_POST['os_version'];

    // Check if the provided email already exists for a different student
    $sql_check_email = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("si", $email, $id);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    // Check if the provided email already exists for a different student
    $sql_check_email = "SELECT id FROM users WHERE email = ? AND id != ?";
    $stmt_check_email = $conn->prepare($sql_check_email);
    $stmt_check_email->bind_param("si", $email, $id);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    // Check if the provided phone number already exists for a different student
    $sql_check_phone = "SELECT id FROM users WHERE phone_number = ? AND id != ?";
    $stmt_check_phone = $conn->prepare($sql_check_phone);
    $stmt_check_phone->bind_param("si", $phone_number, $id);
    $stmt_check_phone->execute();
    $result_check_phone = $stmt_check_phone->get_result();

    if ($result_check_email->num_rows > 0) {
        // Email already exists for a different student
        $error_message = "Error: Email { $email } already exists for another student.";
    } elseif ($result_check_phone->num_rows > 0) {
        // Phone number already exists for a different student
        $error_message = "Error: Phone number { $phone_number } already exists for another student.";
    } else {
        // Update student information in the database
        $sql = "UPDATE users SET name=?, email=?, phone_number=?, birth_date=?, age=?, gender=?, Class=?, Batch=?, os_version=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssissssi", $name, $email, $phone_number, $birth_date, $age, $gender, $class, $batch, $os_version, $id);

        if ($stmt->execute()) {
            // Redirect back to the student list page after successful update
            header("Location: /student?edit_success=true");
            exit();
        } else {
            // Display error message if update fails
            $error_message = "Error: " . $conn->error;
        }
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
    <script>
        function validateForm() {
            var name = document.forms["editForm"]["name"].value;
            var email = document.forms["editForm"]["email"].value;
            var phone_number = document.forms["editForm"]["phone_number"].value;
            // Add validation for other fields as needed

            if (name == "") {
                alert("Name must be filled out");
                return false;
            }

            // Add validation for email format
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Invalid email address");
                return false;
            }

            // Add validation for phone number format
            // For example: Check if it contains only numbers and a certain length

            // Add validation for other fields as needed

            return true;
        }
    </script>
</head>

<body>
    <h3 class="text-center py-5">Edit Student</h3>
    <form name="editForm" method="post" action="" onsubmit="return validateForm()">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <!-- Error message alert -->
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone Number</label>
                        <input type="phone" class="form-control" name="phone_number" id="phone" value="<?php echo $phone_number ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birtDate" class="form-label"></label>
                        <input type="date" class="form-control" name="birth_date" id="birthDate" value="<?php echo $birth_date ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" name="age" id="age" value="<?php echo $age ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" aria-label="Default select example">
                            <option value="">--Select Gender--</option>
                            <option value="male" <?php if ($gender === 'male') echo 'selected'; ?>>Male</option>
                            <option value="female" <?php if ($gender === 'female') echo 'selected'; ?>>Female</option>
                            <option value="other" <?php if ($gender === 'other') echo 'selected'; ?>>Other</option>
                            <option value="not_for_say" <?php if ($gender === 'not_for_say') echo 'selected'; ?>>Not For Say</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select class="form-select" id="class" aria-label="Default select example" name="class">
                            <option value="" disabled>--Select Class--</option>
                            <?php
                            // Include database connection
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
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">Batch</label>
                        <select class="form-select" id="class" aria-label="Default select example" name="batch">
                            <option value="" disabled>--Select Class--</option>
                            <?php
                            // Include database connection
                            include '../../dbconnect/dbconn.php';

                            // Query to fetch unique class values from the 'class' column in the 'users' table
                            $sql = "SELECT batch_name FROM batch";
                            $result = $conn->query($sql);

                            // Fetching data from the result set
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $batchValue = $row['batch_name'];
                                    echo "<option value=\"$batchValue\"";
                                    if ($batch === $batchValue) {
                                        echo " selected";
                                    }
                                    echo ">$batchValue</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="os" class="form-label">Operating System</label>
                        <select class="form-select" id="os" aria-label="Default select example" name="os_version">
                            <option value="" selected disabled>--Select OS--</option>
                            <?php
                            // Include database connection
                            include '../../dbconnect/dbconn.php';

                            // Query to fetch unique OS values from the 'os_version' table
                            $sql = "SELECT name FROM os_version";
                            $result = $conn->query($sql);

                            // Check for errors in query execution
                            if (!$result) {
                                echo "Error: " . $conn->error;
                            } else {
                                // Fetching data from the result set
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $osValue = $row['name'];
                                        echo "<option value=\"$osValue\"";
                                        if ($os_version === $osValue) {
                                            echo " selected";
                                        }
                                        echo ">$osValue</option>";
                                    }
                                } else {
                                    echo "No OS versions found";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" class="btn btn-success" value="Update">
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </form>

    <script src="/include/loader.js"></script>

    <?php include '../include/footer.php'; ?>
</body>

</html>