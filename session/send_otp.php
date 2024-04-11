<?php
session_start();
include "../dbconnect/dbconn.php"; // Include your database connection script

// Include PHPMailer autoloader
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generate_otp()
{
    // Generate a random 6-digit number
    $random_number = rand(100000, 999999);

    // Add the prefix "TLTC-" to the random 6-digit number
    $otp = "TLTC-" . $random_number;

    // Return the generated OTP
    return $otp;
}

// Function to send OTP via email
function send_otp_email($email, $otp)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'mail.technologylearn.info'; // Your SMTP host
        $mail->Port = 465; // Your SMTP port
        $mail->SMTPSecure = 'ssl'; // Enable TLS encryption
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'phonehtutkhaung@technologylearn.info'; // Your SMTP username
        $mail->Password = 'Yamm235795#'; // Your SMTP password

        //Recipients
        $mail->setFrom('phonehtutkhaung@technologylearn.info', 'TLTC - Phone Htut Khaung'); // Sender email and name
        $mail->addAddress($email); // Recipient email

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Password Reset OTP'; // Email subject
        $mail->Body = 'Your OTP: ' . $otp; // Email body

        $mail->send();
        echo "An OTP has been sent to your email.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Function to insert OTP into the database
function insert_otp($conn, $email, $otp)
{
    $email = mysqli_real_escape_string($conn, $email);
    $otp = mysqli_real_escape_string($conn, $otp);
    $timestamp = date('Y-m-d H:i:s', strtotime('+6 hours 30 minutes')); // Adjusted timestamp for Myanmar Standard Time
    $sql = "INSERT INTO password_reset (email, otp, timestamp) VALUES ('$email', '$otp', '$timestamp')";
    mysqli_query($conn, $sql);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Generate a random OTP
    $otp = generate_otp();

    // Insert OTP into the database
    insert_otp($conn, $email, $otp);

    // Send OTP via email
    send_otp_email($email, $otp);

    // Redirect to enter_otp.php to verify OTP
    header("Location: enter_otp.php?email=" . urlencode($email) . "&status=success");
    exit();
}

mysqli_close($conn); // Close database connection
?>

<style>
    /* Styles for your loading overlay */
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        /* Ensure the loading overlay appears on top */
    }

    .loader {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        border: 3px solid;
        border-color: blue blue transparent transparent;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
    }

    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        border: 3px solid;
        border-color: transparent transparent #FF3D00 #FF3D00;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-sizing: border-box;
        animation: rotationBack 0.5s linear infinite;
        transform-origin: center center;
    }

    .loader::before {
        width: 32px;
        height: 32px;
        border-color: blue blue transparent transparent;
        animation: rotation 1.5s linear infinite;
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes rotationBack {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    /* Initially hide the content */
    body {
        overflow: hidden;
        /* Prevent scrolling while loading */
    }
</style>
<script>
    // Function to track page loading progress
    function trackPageLoadProgress() {
        // Create a new XMLHttpRequest object
        var xhr = new XMLHttpRequest();

        // Add event listeners to track progress
        xhr.addEventListener('loadstart', function() {
            // Page loading has started
            console.log('Page loading started...');
        });

        xhr.addEventListener('progress', function(event) {
            if (event.lengthComputable) {
                // Calculate loading percentage
                var percentage = (event.loaded / event.total) * 100;
                // Update progress bar
                updateProgressBar(percentage);
            }
        });

        xhr.addEventListener('load', function() {
            // Page loading has completed
            console.log('Page loading completed.');
            // Ensure the progress bar reaches 100% even if the event does not fire due to caching or other reasons
            updateProgressBar(100);
        });

        xhr.open('GET', window.location.href); // Send a GET request to the current page URL
        xhr.send(); // Send the request
    }

    // Call the function to start tracking page loading progress
    trackPageLoadProgress();

    // Loading Sapnner

    // Hide the loading overlay when the page is fully loaded
    window.addEventListener('load', function() {
        var loadingOverlay = document.getElementById('loading-overlay');
        loadingOverlay.style.display = 'none';
    });
</script>

<div id="loading-overlay">
    <span class="loader"></span>
</div>