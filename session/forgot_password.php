<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="bs/style.css">
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
</head>

<body>
    <form method="post" action="send_otp.php">
        <!--ring div starts here-->
        <div class="ring">
            <i style="--clr:#00ff0a;"></i>
            <i style="--clr:#ff0057;"></i>
            <i style="--clr:#fffd44;"></i>
            <div class="login">
                <h2>Reset Password</h2>
                <div id="loading-overlay">
                    <span class="loader"></span>
                </div>
                <?php if (isset($error)) { ?>
                    <div class="alertt-danger"><?php echo $error; ?></div>
                <?php } ?>
                <div class="inputBx">
                    <input type="text" placeholder="Email" name="email">
                </div>
                <div class="inputBx">
                    <input type="submit" value="Sent Otp">
                </div>
                <div class="links">
                    <a href="login.php">Go to Login Page</a>
                </div>
            </div>
        </div>
        <!--ring div ends here-->
    </form>
</body>

</html>