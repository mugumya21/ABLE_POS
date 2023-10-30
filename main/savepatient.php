<?php
session_start();
include('../connect.php');
$a = $_POST['name'];
$b = $_POST['address'];
$c = $_POST['contact'];

// query
$sql = "INSERT INTO patient (patient_name, address, contact) VALUES (?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("sss", $a, $b, $c) && $q->execute()) {
    header("location: patient.php");
} else {
    die("Execute failed: " . $q->error);
}
?>
