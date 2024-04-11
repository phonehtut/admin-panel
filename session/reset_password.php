<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>

    <link rel="stylesheet" href="bs/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/eliyantosarage/font-awesome-pro@main/fontawesome-pro-6.5.1-web/css/all.min.css">

    <style>
        /* Style for the eye icon inside the password fields */
        .inputBx {
            position: relative;
            /* Make the container relative for absolute positioning of the icon */
        }

        .inputBx .toggle-password {
            position: absolute;
            right: 10px;
            /* Position the icon to the right of the input field */
            top: 50%;
            /* Vertically center the icon */
            transform: translateY(-50%);
            cursor: pointer;
            /* Make the icon clickable */
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            /* Adjust the size of the icon */
            height: 24px;
            /* Adjust the size of the icon */
        }

        .inputBx .toggle-password svg {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <!-- Form for resetting the password -->
    <form method="post" action="update_password.php" onsubmit="return validateForm()">
        <div class="ring">
            <i style="--clr:#00ff0a;"></i>
            <i style="--clr:#ff0057;"></i>
            <i style="--clr:#fffd44;"></i>
            <div class="login">
                <h2>Reset Password</h2>

                <!-- Display error message if there is one -->
                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <!-- Hidden input to store the user's email -->
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">

            <!-- Input field for the new password -->
            <div class="inputBx">
                <input type="password" placeholder="Enter Your New Password" name="password" id="password" required>
                <!-- SVG eye icon to toggle password visibility -->
                <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff">
                        <path d="M12 4.5c4.97 0 9 5.25 9 7.5s-4.03 7.5-9 7.5c-4.97 0-9-5.25-9-7.5s4.03-7.5 9-7.5zm0 1.5c-4.35 0-8 4.35-8 6s3.65 6 8 6c4.35 0 8-4.35 8-6s-3.65-6-8-6zm0 1.5a4.5 4.5 0 110 9 4.5 4.5 0 010-9zm0 1.5a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </span>
            </div>

            <!-- Input field for confirming the new password -->
            <div class="inputBx">
                <input type="password" placeholder="Retype Password" name="confirm_password" id="confirm_password" required>
                <!-- SVG eye icon to toggle password visibility -->
                <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff">
                        <path d="M12 4.5c4.97 0 9 5.25 9 7.5s-4.03 7.5-9 7.5c-4.97 0-9-5.25-9-7.5s4.03-7.5 9-7.5zm0 1.5c-4.35 0-8 4.35-8 6s3.65 6 8 6c4.35 0 8-4.35 8-6s-3.65-6-8-6zm0 1.5a4.5 4.5 0 110 9 4.5 4.5 0 010-9zm0 1.5a3 3 0 100 6 3 3 0 000-6z" />
                    </svg>
                </span>
            </div>

                <!-- Submit button -->
                <div class="inputBx">
                    <input type="submit" value="Submit">
                </div>

                <!-- Link back to the login page -->
                <div class="links">
                    <a href="login.php">Login</a>
                </div>
            </div>
        </div>
        <!-- Ring div ends here -->
    </form>

    <!-- JavaScript for form validation -->
    <script>
                function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Error: Password and confirm password do not match.");
                return false;
            }

            return true;
        }

        function togglePasswordVisibility(inputId) {
            const inputElement = document.getElementById(inputId);
            inputElement.type = inputElement.type === 'password' ? 'text' : 'password';
            const iconElement = inputElement.nextElementSibling.querySelector('path');
            iconElement.setAttribute('fill', inputElement.type === 'text' ? '#fff' : '#fff');
        }
    </script>
</body>

</html>