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

// Student Add New Successful Message
$new_success_message = '';
if (isset($_GET['new_success']) && $_GET['new_success'] == 'true') {
    $new_success_message = "New Btach added successfully.";
}

// Student Data Update Successful Message
$edit_success_message = '';
if (isset($_GET['edit_success']) && $_GET['edit_success'] == 'true') {
    $edit_success_message = "Batch record edited successfully.";
}

// CStudent Delete Successful Message
$delete_success_message = '';
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    $delete_success_message = "Batch record deleted successfully.";
}

// Query to fetch student list
$sql = "SELECT * FROM batch";
$result = $conn->query($sql);
?>


<div class="container-fulid mx-4">
    <h3 class="py-4 text-center">Batchs List</h3>
    <a href="/action/add/batch.php" class="btn btn-primary col-auto mb-3"><i class="fa-duotone fa-plus"></i> Add New</a>
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
    <table class="table table-striped table-hover table-bordered" id="sortTable">
        <thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Start Date</th>
                <th scope="col" class="text-center">Class</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">End Date</th>
                <th scope="col" class="text-center">Remark</th>
                <th scope="col" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                <td class='text-center'>" . $row["id"] . "</td>
                <td class='text-center'>" . $row["start_date"] . "</td>
                <td class='text-center'>" . $row["class"] . "</td>
                <td class='text-center'>" . $row["batch_name"] . "</td>
                <td class='text-center'>" . $row["end_date"] . "</td>
                <td class='text-center'>" . $row["remark"] . "</td>
                <td>
                    <a href='action/edit/batch.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
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
                            Are you sure you want to delect this Batch? The Batch name is " . $row['batch_name'] . "
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <a href='action/delete/batch.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
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

    <script src="/include/loader.js"></script>
    <?php include "include/footer.php"; ?>
</div>