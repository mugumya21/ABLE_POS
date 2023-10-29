<?php
include('../connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['memi'];
    $product_name = $_POST['name'];
    $qty_unit = $_POST['qty_unit'];
    $product_type = $_POST['product_type'];
    $date_arrival = $_POST['date_arrival'];
    $expiry_date = $_POST['exdate'];
    $price = $_POST['price'];
    $o_price = $_POST['o_price'];
    $supplier = $_POST['supplier'];
    $qty = $_POST['qty'];

    // Update the product in the database
    $updateQuery = "UPDATE products SET product_name=?, qty_unit=?, product_type=?, date_arrival=?, expiry_date=?, price=?, o_price=?, supplier=?, qty=? WHERE product_id=?";
    $stmt = $conn->prepare($updateQuery);

    // Bind parameters
    $stmt->bind_param("sssssssssi", $product_name, $qty_unit, $product_type, $date_arrival, $expiry_date, $price, $o_price, $supplier, $qty, $id);
    
    if ($stmt->execute()) {
        // Redirect back to the products page after successful update
        header("Location: products.php");
        exit();
    } else {
        echo "Error updating product: " . $stmt->error;
    }
    
    // Close the statement and the connection if necessary
    $stmt->close();
    $conn->close();
}
?>
