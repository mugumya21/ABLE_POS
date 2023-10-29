<?php
// configuration
include('../connect.php');

// new data
$id = $_POST['memi'];
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['contact'];
$d = $_POST['cperson'];

// query
$sql = "UPDATE supliers 
        SET suplier_name=?, suplier_address=?, suplier_contact=?, contact_person=?
		WHERE suplier_id=?";
$q = $conn->prepare($sql);

// Bind the parameters
$q->bind_param('ssssi', $a, $b, $c, $d, $id);

// Execute the query
if ($q->execute()) {
    header("location: supplier.php");
} else {
    echo "Error updating record: " . $q->error;
}

// Close the prepared statement
$q->close();
?>
