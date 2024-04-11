// Function to track page loading progress
function trackPageLoadProgress() {
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Add event listeners to track progress
    xhr.addEventListener('loadstart', function () {
        // Page loading has started
        console.log('Page loading started...');
    });

    xhr.addEventListener('progress', function (event) {
        if (event.lengthComputable) {
            // Calculate loading percentage
            var percentage = (event.loaded / event.total) * 100;
            // Update progress bar
            updateProgressBar(percentage);
        }
    });

    xhr.addEventListener('load', function () {
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