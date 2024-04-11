<?php
session_start();

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    // Clear the error message from the session
    unset($_SESSION['error_message']);
} else {
    $error_message = '';
}
?>

<script>
<?php if ($error_message): ?>
    alert('<?php echo $error_message; ?>');
<?php endif; ?>
</script>