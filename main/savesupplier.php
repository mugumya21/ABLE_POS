<?php
session_start();
include('../connect.php');
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['contact'];
$d = $_POST['cperson'];

// query
$sql = "INSERT INTO supliers (suplier_name, suplier_address, suplier_contact, contact_person) VALUES (?, ?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("ssss", $a, $b, $c, $d) && $q->execute()) {
    header("location: supplier.php");
} else {
    die("Execute failed: " . $q->error);
}
?>

