<?php
include('../connect.php'); // Use the correct relative path

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['memi'];
    $purchases_type = $_POST['purchases_type'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $suplier_name = $_POST['suplier_name'];
  
    // Update the product in the database
    $updateQuery = "UPDATE purchasesreport SET purchases_type=?,  date=?, amount=?, suplier_name=? WHERE purchasesreport_id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssi", $purchases_type, $date, $amount, $suplier_name,  $id);
    
    if ($stmt->execute()) {
        // Redirect back to the products page after successful update
        header("Location: purchaseslist.php");
        exit();
    } else {
        echo "Error updating purchases summary: " . $stmt->error;
    }
}
?>
