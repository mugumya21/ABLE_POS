<?php
include('../connect.php');

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM invoices WHERE invoice_id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page after deletion
        header("Location: invoiceslist.php");
        exit();
    } else {
        echo "Error deleting record from invoice table: " . $conn->error;
    }
}

$conn->close();
?>
