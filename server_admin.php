<?php
// Start the session
session_start();

// Only Access For Role is Founder and Server Admin
if (
    !isset($_SESSION['email']) ||
    $_SESSION['status'] !== 'active' ||
    ($_SESSION['role'] !== 'server admin' && $_SESSION['role'] !== 'founder')
) {
    // Set an error message in the session
    $_SESSION['error_message'] = 'You do not have permission to access this page.';

    // Display a JavaScript alert and then redirect back to the previous page
    echo "<script>";
    echo "alert('You do not have permission to access this page.');";
    echo "window.history.back();";
    echo "</script>";
    exit();
}

include "include/header.php";
// Include database connection
include 'dbconnect/dbconn.php';

// Student Add New Successful Message
$new_success_message = '';
if (isset($_GET['new_success']) && $_GET['new_success'] == 'true') {
    $new_success_message = "New List added successfully.";
}

// Student Data Update Successful Message
$edit_success_message = '';
if (isset($_GET['edit_success']) && $_GET['edit_success'] == 'true') {
    $edit_success_message = "Access List edited successfully.";
}

// CStudent Delete Successful Message
$delete_success_message = '';
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    $delete_success_message = "Access List deleted successfully.";
}

// Query to fetch student list
$sql = "SELECT * FROM server_admin_access";
$result = $conn->query($sql);
?>


<div class="container-fulid mx-4">
    <h3 class="py-4 text-center">Server Access List</h3>
    <a href="/action/add/server_admin.php" class="btn btn-primary col-auto mb-3"><i class="fa-duotone fa-plus"></i> Add New</a>
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
        <div style='overflow-x: auto;'>
            <table class="table table-striped table-hover table-bordered table-sm" id="sortTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Class Name</th>
                        <th scope="col" class="text-center">Host</th>
                        <th scope="col" class="text-center">Username</th>
                        <th scope="col" class="text-center">Passowrd</th>
                        <th scope="col" class="text-center">Ip Address v_4</th>
                        <th scope="col" class="text-center">Ip Address v_6</th>
                        <th scope="col" class="text-center">Port</th>
                        <th scope="col" class="text-center">Database</th>
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
                <td class='text-center'>" . $row["name"] . "</td>
                <td class='text-center'>" . $row["host"] . "</td>
                <td class='text-center'>" . $row["username"] . "</td>
                <td class='text-center'>" . $row["password"] . "</td>
                <td class='text-center'>" . $row["ip_address_4"] . "</td>
                <td class='text-center'>" . $row["ip_address_6"] . "</td>
                <td class='text-center'>" . $row["port"] . "</td>
                <td class='text-center'>" . $row["database_name"] . "</td>
                <td class='text-center'>" . $row["remark"] . "</td>
                <td>
                    <div class='d-flex justify-content-center justify-content-md-start'>
                    <a href='action/edit/server_admin.php?id=" . $row['id'] . "' class='btn btn-sm btn-primary me-2' title='Edit'><i class='fa-duotone fa-pen-to-square'></i></a>  
                    <a href='#' class='btn btn-sm btn-danger' title='Delete' data-bs-toggle='modal' data-bs-target='#deleteModal_" . $row['id'] . "'><i class='fa-duotone fa-trash'></i></a>
                    </div>
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
                            Are you sure you want to delect this Batch? The Batch name is " . $row['name'] . "
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancel</button>
                            <a href='action/delete/server_admin.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                        </div>
                    </div>
                </div>
            </div>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No Access found</td></tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>

    <script src="/include/loader.js"></script>
    <?php include "include/footer.php"; ?>
</div>