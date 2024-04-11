<?php
// Include database connection
include '../../dbconnect/dbconn.php';

// Check if ID parameter is provided in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute SQL statement to delete the student record
    $sql = "DELETE FROM batch WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the student list page after successful deletion
        header("Location: /batch.php?delete_success=true");
        exit();
    } else {
        // Display error message if deletion fails
        echo "Error: " . $conn->error;
    }
} else {
    // Redirect to the student list page if ID parameter is not provided
    header("Location: /index.php");
    exit();
}

// Close the database connection
$conn->close();
?>
