<?php
session_start();
include('../connect.php');
$product = $_POST['product'];
$qty = $_POST['qty'];
$cost = $_POST['cost'];

// Check if the product already exists in the products table
$sql_check = "SELECT * FROM products WHERE product_name = ?";
$query_check = $conn->prepare($sql_check);

if ($query_check) {
    // Bind parameters
    $query_check->bind_param("s", $product);

    // Execute the query
    $query_check->execute();

    // Fetch the result
    $result = $query_check->get_result();

    if ($result->num_rows > 0) {
        // The product already exists, so update the quantity and qty_left
        $sql_update = "UPDATE products SET qty = qty + ?, qty_left = qty_left + ? WHERE product_name = ?";
        $query_update = $conn->prepare($sql_update);

        if ($query_update) {
            // Bind parameters for the update
            $query_update->bind_param("dss", $qty, $qty, $product);

            // Execute the update query
            if ($query_update->execute()) {
                // Redirect to a success page or display a success message
                header("location: purchaseslist.php");
                exit(); // Stop further execution
            } else {
                // Log the error and handle it gracefully
                error_log("Error updating data in the database: " . implode(" | ", $query_update->errorInfo()));
                echo "An error occurred while processing your request. Please try again later.";
            }
        } else {
            echo "Error in preparing the update SQL statement: " . $conn->error;
        }
    } else {
        // The product does not exist, so show an error message or handle it as per your requirement
        echo "Product does not exist.";
    }
} else {
    echo "Error in preparing the SQL statement for checking product existence: " . $conn->error;
}

// Close the database connection (if needed)
$conn->close();
?>
