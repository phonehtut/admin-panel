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
        <a class="nav-link active" aria-current="page" href="/graph.php">Graph View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/monthstd.php">Monthly List</a>
    </li>
    <li class="nav-item">
        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
    </li>
</ul>

<div class="container mt-5">
    <h2>Graph View</h2>
    <canvas id="dataChart" width="20" height="0"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Get data counts from your PHP files (you can pass these values to JavaScript variables)
    const studentCount = <?php include "count/student.php"; ?>;
    const reviewCount = <?php include "count/review.php"; ?>;
    const classCount = <?php include "count/class.php"; ?>;
    const batchCount = <?php include "count/batch.php"; ?>;
    const adminCount = <?php include "count/admin.php"; ?>;
    const loginCount = <?php include "count/login.php"; ?>;
    const feedbackCount = <?php include "count/feedback.php"; ?>;
    const contactCount = 0; // Replace with the correct count if necessary

    // Prepare data for the chart
    const labels = ['Student List', 'Review List', 'Class List', 'Batch List', 'Admin List', 'Login List', 'Feedback List', 'Contact List'];
    const dataCounts = [studentCount, reviewCount, classCount, batchCount, adminCount, loginCount, feedbackCount, contactCount];

    // Create the bar chart
    const ctx = document.getElementById('dataChart').getContext('2d');
    const dataChart = new Chart(ctx, {
        type: 'line', // Use 'bar' for a bar chart
        data: {
            labels: labels,
            datasets: [{
                label: 'Data Counts',
                data: dataCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.6)', // Set the background color for the bars
                borderColor: 'rgba(75, 192, 192, 1)', // Set the border color for the bars
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php include "include/footer.php"; ?>