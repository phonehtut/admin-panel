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

// Initialize variables
$name = '';
$email = '';
$phone_number = '';
$birth_date = '';
$age = '';
$gender = '';
$class = '';
$batch = '';
$os_version = '';

// Error message variable
$error_message = '';

// Check if form is submitted for adding
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
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $start_date = date('Y-m-d / H:i:s');

    // Perform client-side validation using JavaScript
    // You can also perform server-side validation here

    // Check if the email already exists
    $email_exists_sql = "SELECT COUNT(*) as count FROM users WHERE email = ?";
    $stmt = $conn->prepare($email_exists_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $email_count = $row['count'];

    if ($email_count > 0) {
        $error_message = "Error: Email ( $email ) already exists. Please Check Again";
    } else {
        // Add new student
        $sql = "INSERT INTO users (name, email, phone_number, birth_date, age, gender, Class, Batch, os_version, ip_address, start_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssissssss", $name, $email, $phone_number, $birth_date, $age, $gender, $class, $batch, $os_version, $ip_address, $start_date);

        if ($stmt->execute()) {
            // Redirect back to the student list page after successful addition
            header("Location: /student.php?new_success=true");
            exit();
        } else {
            // Display error message if addition fails
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
    <title>Add Student</title>
    <script>
        function validateForm() {
            var name = document.forms["addForm"]["name"].value;
            var email = document.forms["addForm"]["email"].value;
            var phone_number = document.forms["addForm"]["phone_number"].value;
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
    <h3 class="text-center py-5">Add Student</h3>
    <form name="addForm" method="post" action="" onsubmit="return validateForm()">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row">
                    <!-- Error message alert -->
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
                    <input type="hidden" name="start_date" value="<?php echo date('Y-m-d H:i:s'); ?>">
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
                        <label for="birtDate" class="form-label">Birth Date</label>
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
                    <div class="col-md-6 mb-3">
                        <label for="class" class="form-label">Batch</label>
                        <select class="form-select" id="class" aria-label="Default select example" name="batch">
                            <option value="" selected disabled>--Select Class--</option>
                            <?php
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

                    <input type="submit" class="btn btn-success" value="Add">
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </form>

    <?php include '/include/footer.php'; ?>
</body>

</html>