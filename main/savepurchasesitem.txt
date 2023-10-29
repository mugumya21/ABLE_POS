<?php
session_start();
include('../connect.php');
$suplier_name = $_POST['suplier_name']; // Corrected variable name to 'supplier_name'
$product = $_POST['product'];
$qty = $_POST['qty'];
$cost = $_POST['cost'];

// Check if the product already exists in the products table
$sql_check = "SELECT * FROM products WHERE supplier = ? AND product_name = ?";
$query_check = $conn->prepare($sql_check);

if ($query_check) {
    // Bind parameters
    $query_check->bind_param("ss", $suplier_name, $product);

    // Execute the query
    $query_check->execute();

    // Fetch the result
    $result = $query_check->get_result();

    if ($result->num_rows > 0) {
        // The product already exists, so update the quantity and price
        $sql_update = "UPDATE products SET qty = qty + ?, price = ? WHERE supplier = ? AND product_name = ?";
        $query_update = $conn->prepare($sql_update);

        if ($query_update) {
            // Bind parameters for the update
            $query_update->bind_param("dsss", $qty, $cost, $suplier_name, $product);

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
        // The product does not exist, so insert it
        $sql_insert = "INSERT INTO products (supplier, product_name, qty, price) VALUES (?, ?, ?, ?)";
        $query_insert = $conn->prepare($sql_insert);

        if ($query_insert) {
            // Bind parameters for the insert
            $query_insert->bind_param("sssd", $suplier_name, $product, $qty, $cost);

            // Execute the insert query
            if ($query_insert->execute()) {
                // Redirect to a success page or display a success message
                header("location: purchaseslist.php");
                exit(); // Stop further execution
            } else {
                // Log the error and handle it gracefully
                error_log("Error inserting data into the database: " . implode(" | ", $query_insert->errorInfo()));
                echo "An error occurred while processing your request. Please try again later.";
            }
        } else {
            echo "Error in preparing the insert SQL statement: " . $conn->error;
        }
    }
} else {
    echo "Error in preparing the SQL statement for checking product existence: " . $conn->error;
}

// Close the database connection (if needed)
$conn->close();
?>
