<?php
// Start a session (if needed)
session_start();

// Include your database connection script
include('../connect.php');

// Initialize variables from the submitted form
$name = $_POST['name'];
$product_type= $_POST['product_type'];
$qty_unit = $_POST['qty_unit'];
$exdate = $_POST['exdate'];
$date_arrival = $_POST['date_arrival'];
$price = $_POST['price'];
$o_price = $_POST['o_price'];
$supplier = $_POST['supplier'];
$qty = $_POST['qty'];

// Prepare SQL query
$sql = "INSERT INTO products (product_name, qty_unit, product_type, expiry_date, date_arrival, price, o_price, supplier, qty)
        VALUES (?, ?, ?, ?, ?, ?, ?,?,?)";

// Prepare the SQL statement
$query = $conn->prepare($sql);

if ($query) {
    // Bind parameters
    $query->bind_param("ssdddsdss", $name,$qty_unit, $product_type ,  $exdate, $date_arrival, $price, $o_price, $supplier, $qty);

    // Execute the query
    if ($query->execute()) {
        // Redirect to a success page or display a success message
        
        header("location: products.php");
        exit(); // Stop further execution
    } else {
        // Log the error and handle it gracefully
        error_log("Error inserting data into the database: " . implode(" | ", $query->errorInfo()));
        echo "An error occurred while processing your request. Please try again later.";
    }
} else {
    echo "Error in preparing the SQL statement: " . $conn->error;
}

// Close the database connection (if needed)
$conn->close();
?>
