<?php
// Start the session
session_start();

// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Include the database connection file
include "../dbconnect/dbconn.php";

// Function to sanitize input data
function sanitize_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

// Function to authenticate the user and retrieve their role
function authenticate_user($conn, $email, $password)
{
    // Sanitize input data
    $email = sanitize_input($email);
    $password = sanitize_input($password);

    // Hash the password using MD5 (consider using bcrypt instead for stronger security)
    $hashed_password = md5($password);

    // Prepare and execute the SQL query to verify user credentials and get their role
    $stmt = $conn->prepare("SELECT id, role, status FROM member WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user is found
    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Store user ID, email, and role in session variables
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["email"] = $email;
        $_SESSION["role"] = $row["role"];
        $_SESSION["status"] = $row["status"];

        // Record login history
        record_login_history($conn, $row["id"], $email);

        // Close the statement
        $stmt->close();

        // Authentication successful
        return true;
    }

    // Close the statement
    $stmt->close();

    // Authentication failed
    return false;
}

// Function to record login history
function record_login_history($conn, $user_id, $email)
{
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $timestamp = date('Y-m-d H:i:s', strtotime('+6 hours 30 minutes'));

    // Prepare and execute the SQL query to insert login history record
    $stmt = $conn->prepare("INSERT INTO login_history (user_id, email, ip_address, login_time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $email, $ip_address, $timestamp);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize user inputs
    $email = sanitize_input($_POST["email"]);
    $password = sanitize_input($_POST["password"]);

    // Check if the user is authenticated
    if (authenticate_user($conn, $email, $password)) {
        // Redirect the user based on their role
        header("Location: /");
        exit();
    } else {
        // Set an error message if authentication fails
        $error = "Invalid email or password.";
    }
}

// Password Change Success
$pwd_success = '';
if (isset($_SESSION['pwd_success'])) {
    $pwd_success = $_SESSION['pwd_success'];
    // Clear the success message from the session after displaying it
    unset($_SESSION['pwd_success']);
}

// Retrieve the error message from the session, if any
$error = $error;
if (isset($_SESSION['error_message'])) {
    $error = $_SESSION['error_message'];
    // Clear the error message from the session after displaying it
    unset($_SESSION['error_message']);
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <?php require "bs/bs.html"; ?>
    <link rel="stylesheet" href="bs/style.css">
</head>

<body>
    <div class="container-fulid">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <!--ring div starts here-->
            <div class="ring">
                <i style="--clr:#00ff0a;"></i>
                <i style="--clr:#ff0057;"></i>
                <i style="--clr:#fffd44;"></i>
                <div class="login">
                    <h2>Login</h2>
                    <?php
                    if (!empty($pwd_success)) {
                        echo "<div class='alertt'>" . htmlspecialchars($pwd_success) . "</div>";
                    }
                    ?>
                    <?php
                    if (!empty($error)) {
                        echo "<div class='alertt-danger'>" . htmlspecialchars($error) . "</div>";
                    }
                    ?>
                    <div class="inputBx">
                        <input type="text" placeholder="Email" name="email">
                    </div>
                    <div class="inputBx">
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    <div class="inputBx">
                        <input type="submit" value="Sign in">
                    </div>
                    <div class="links">
                        <a href="forgot_password.php">Forget Password</a>
                        <a href="#">Signup</a>
                    </div>
                </div>
            </div>
            <!--ring div ends here-->
        </form>
    </div>
</body>

</html>