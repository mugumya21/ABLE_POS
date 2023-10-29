<?php
session_start();
include('../connect.php');
$a = $_POST['amount'];
$b = $_POST['suplier_name'];
$c = $_POST['date'];
$d= $_POST['purchases_type'];

// query
$sql = "INSERT INTO purchasesreport (amount, suplier_name, date, purchases_type) VALUES (?, ?, ?, ?)";
$q = $conn->prepare($sql);

if (!$q) {
    die("Prepare failed: " . $conn->error);
}

if ($q->bind_param("ssss", $a, $b, $c, $d) && $q->execute()) {
 // Purchase recorded successfully
    $_SESSION['success_message'] = "Purchase recorded successfully.";
    header("location: purchaseslist.php");
} else {
    die("Execute failed: " . $q->error);
}
?>
