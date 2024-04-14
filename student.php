<?php 
// Start the session
session_start();

// Check if user is not logged in, redirect to logout.php
if (!isset($_SESSION["email"])) {
    header("Location: /session/logout.php");
    exit();
}

include "include/header.php";
// Include database connection
include 'dbconnect/dbconn.php';

// Student Add New Successful Message
$new_success_message = '';
if (isset($_GET['new_success']) && $_GET['new_success'] == 'true') {
    $new_success_message = "New student added successfully.";
}

// Student Data Update Successful Message
$edit_success_message = '';
if (isset($_GET['edit_success']) && $_GET['edit_success'] == 'true') {
    $edit_success_message = "Student record edited successfully.";
}

// CStudent Delete Successful Message
$delete_success_message = '';
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    $delete_success_message = "Student record deleted successfully.";
}

// Query to fetch student list
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<body>
    <div class="container-fulid mx-4">
        <h3 class="py-4 text-center">Students List</h3>
        <a href="/action/add/student.php" class="btn btn-primary col-auto mb-3"><i class="fa-duotone fa-plus"></i> Add New</a>
        <?php if (!empty($new_success_message)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $new_success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($edit_success_message)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $edit_success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($delete_success_message)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $delete_success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <table class="table table-striped table-hover text-center table-bordered table-sm" id="sortTable">
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
                    <th scope="col">Action</th>
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
                    <a href='action/edit/student.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm my-3'><i class='fas fa-edit'></i> Edit</a>
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
                            Are you sure you want to delect this student? The student's name is " . $row['name'] . "
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <a href='action/delete/student.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
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
</body>