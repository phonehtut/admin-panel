<?php
session_start();
include "../dbconnect/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the new password
    $hashed_password = md5($password);

    // Update the password in the database using a prepared statement
    $stmt = $conn->prepare("UPDATE member SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $hashed_password, $email);

    // Execute the statement and handle any errors
    if ($stmt->execute()) {
        // Password reset was successful
        $_SESSION['pwd_success'] = 'Password Reset Successful';
    } else {
        // Password reset failed
        $_SESSION['pwd_error'] = 'Failed to reset password. Please try again.';
    }

    // Close the statement
    $stmt->close();

    // Redirect the user to login.php
    header("Location: login.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
