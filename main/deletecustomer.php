<?php
include('../connect.php');


if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // Retrieve the product ID from the AJAX request
    

    $sql = "DELETE FROM customer WHERE customer_id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the page after deletion
        header("Location: customer.php");
        exit();
    } else {
        echo "Error deleting record from product table: " . $conn->error;
    }
}

$conn->close();
?>
