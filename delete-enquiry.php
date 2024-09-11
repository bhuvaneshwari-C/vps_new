<?php
session_start();

include './database_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the product list with a success message
        echo "<script>
                alert('Record deleted successfully');
                window.location.href='enquiry-list.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting record: " . $stmt->error . "');
                window.location.href='enquiry-list.php';
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
