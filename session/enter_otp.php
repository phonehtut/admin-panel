<?php
// Start session if not already started
session_start();

// Check if the status parameter is set
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Display Bootstrap alert based on the status
if ($status === 'success') {
    $alertClass = 'alert-success';
    $message = 'An OTP has been sent to your email.';
} else {
    $alertClass = 'alert-danger';
    $message = 'Failed to send OTP email.';
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Enter OTP</title>
    <?php require "bs/bs.html"; ?>
    <link rel="stylesheet" href="bs/style.css">
</head>

<body>
    <form method="post" action="verify_otp.php">
        <!--ring div starts here-->
        <div class="ring">
            <i style="--clr:#00ff0a;"></i>
            <i style="--clr:#ff0057;"></i>
            <i style="--clr:#fffd44;"></i>
            <div class="login">
                <h2>Reset Password</h2>
                <div class="alertt <?php echo $alertClass; ?>" role="alert">
                    <?php echo $message; ?>
                </div>
                <?php
                if (isset($_SESSION['otp_error'])) {
                    echo '<div class="alertt-danger" role="alert">' . htmlspecialchars($_SESSION['otp_error']) . '</div>';
                    unset($_SESSION['otp_error']); // Remove the error message from the session after displaying itt
                }
                ?>
                <?php if (isset($error)) { ?>
                    <div class="alertt-danger"><?php echo $error; ?></div>
                <?php } ?>
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                <div class="inputBx">
                    <input type="text" placeholder="Enter Yout Otp" name="otp">
                </div>
                <div class="inputBx">
                    <input type="submit" value="Submit">
                </div>
                <div class="links">
                    <a href="forgot_password.php">Set otp again</a>
                </div>
            </div>
        </div>
        <!--ring div ends here-->
    </form>
</body>

</html>