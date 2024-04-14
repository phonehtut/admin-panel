<?php require "include/header.php"; ?>


<style>
        /* CSS for styling the chart container */
        .container {
            width: 1000px;
            height: 500px;
            margin: 50px auto;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>


<ul class="nav nav-tabs my-5">
    <li class="nav-item">
        <a class="nav-link" href="/">Home</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/graph.php">Graph View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/monthstd.php">Monthly List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
    </li>
</ul>

<div class="container mt-5">
    <h2>Graph View</h2>
    <canvas id="registrationChart" width="20" height="0"></canvas>
</div>

<?php include "include/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Fetch the data from monthlycount.php
    fetch('count/monthlycountstd.php')
        .then(response => response.json())
        .then(data => {
            // Extract months and counts from the JSON data
            const months = Object.keys(data);
            const counts = Object.values(data);

            // Define colors for each month
            const colors = [
                'rgba(255, 99, 132, 0.5)', // January - Red
                'rgba(54, 162, 235, 0.5)', // February - Blue
                'rgba(75, 192, 192, 0.5)', // March - Green
                'rgba(255, 206, 86, 0.5)', // April - Yellow
                'rgba(153, 102, 255, 0.5)', // May - Purple
                'rgba(255, 159, 64, 0.5)', // June - Orange
                'rgba(54, 162, 235, 0.5)', // July - Blue
                'rgba(255, 99, 132, 0.5)', // August - Red
                'rgba(75, 192, 192, 0.5)', // September - Green
                'rgba(255, 206, 86, 0.5)', // October - Yellow
                'rgba(153, 102, 255, 0.5)', // November - Purple
                'rgba(255, 159, 64, 0.5)'  // December - Orange
            ];

            // Get the canvas element for the chart
            const ctx = document.getElementById('registrationChart').getContext('2d');

            // Create the bar chart
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months, // Months for the X-axis
                    datasets: [{
                        label: 'User Registrations',
                        data: counts, // Counts for the Y-axis
                        backgroundColor: colors.slice(0, counts.length), // Assign colors for each bar
                        borderColor: 'rgba(0, 0, 0, 0.5)', // Border color
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true // Start y-axis at zero
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>

</body>
</html>
