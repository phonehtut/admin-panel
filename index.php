<?php 
// Start the session
session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

// Check if the user status is not active, redirect to login.php with error message
if ($_SESSION['status'] !== 'active') {
    // Set an error message in the session
    $_SESSION['error_message'] = 'Your account status is not active.';
    
    // Redirect to login.php
    header("Location: /session/login.php");
    exit();
}

include "include/header.php";
// Include database connection
include 'dbconnect/dbconn.php';

// Query to fetch student list
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<div class="container-fulid mx-4">
    <h3 class="py-4 text-center">Students List</h3>
    <a href="#" class="btn btn-primary btn-sm col-auto float-end mb-3">Add New</a>
    <?php if(isset($_GET['success']) && $_GET['success'] == 'true'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Student record deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <table class="table table-striped table-hover text-center table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Registion Date</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">birth_date</th>
                <th scope="col">Age</th>
                <th scope="col">Gender</th>
                <th scope="col">Class</th>
                <th scope="col">Batch</th>
                <th scope="col">Os</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["start_date"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["email"] . "</td>
                <td>" . $row["phone_number"] . "</td>
                <td>" . $row["birth_date"] . "</td>
                <td>" . $row["age"] . "</td>
                <td>" . $row["gender"] . "</td>
                <td>" . $row["Class"] . "</td>
                <td>" . $row["Batch"] . "</td>  
                <td>" . $row["os_version"] . "</td>
                <td>
                    <a href='#' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                </td>
                <td>
                    <a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal_" . $row['id'] . "'>
                        <i class='fas fa-trash'></i> Delete
                    </a>
                </td>
            </tr>";

        // Modal for delete confirmation
        echo "<div class='modal fade' id='deleteModal_" . $row['id'] . "' tabindex='-1' aria-labelledby='deleteModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title' id='deleteModalLabel'>Confirm Delete</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to delete this student?
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <a href='action/std_delete.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>";
    }
} else {
    echo "<tr><td colspan='12'>No students found</td></tr>";
}
?>

        </tbody>
    </table>

    <?php include "include/footer.php"; ?>
</div>