<?php
session_start();
include "../dbconnect/dbconn.php";

function is_valid_otp($conn, $email, $otp)
{
    $email = mysqli_real_escape_string($conn, $email);
    $otp = mysqli_real_escape_string($conn, $otp);
    $sql = "SELECT * FROM password_reset WHERE email = '$email' AND otp = '$otp' AND TIMESTAMPDIFF(MINUTE, timestamp, NOW()) <= 120";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) > 0;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $otp = $_POST["otp"];

    if (is_valid_otp($conn, $email, $otp)) {
        // Redirect to reset password page
        header("Location: reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        // Set the error message in the session
        $_SESSION['otp_error'] = "Invalid OTP or OTP has expired.";
        
        // Redirect the user back to the referring page
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            // Fallback in case HTTP_REFERER is not available
            header("Location: enter_otp.php?email=" . urlencode($email));
        }
        
        // Ensure the script stops executing after the redirection
        exit();
    }
}

mysqli_close($conn);
?>
