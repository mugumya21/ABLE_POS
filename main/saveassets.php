<?php
session_start();
include('../connect.php');
$a = $_POST['name'];
$b = $_POST['date'];
$c = $_POST['price'];
$d = $_POST['description'];


// query
$sql = "INSERT INTO assets (name,  date, price, Description) VALUES (?, ?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("ssss", $a, $b, $c, $d) && $q->execute()) {
    header("location: assets.php");
} else {
    die("Execute failed: " . $q->error);
}
?>
