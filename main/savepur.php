<?php
session_start();
include('../connect.php');
$a = $_POST['iv'];
$b = $_POST['date'];
$c = $_POST['supplier'];
$d = $_POST['remarks'];

// query
$sql = "INSERT INTO purchases (invoice_number,date,suplier,remarks) VALUES (?,?,?,?)";
$q = $conn->prepare($sql);
if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("ssss", $a, $b, $c, $d) && $q->execute()) {
    header("location: purchaseslist.php");
} else {
    die("Execute failed: " . $q->error);
}

?>