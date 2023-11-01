<?php
// Include your database connection script
include('../connect.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$result = $conn->prepare("SELECT customersledger_id, customer_name, date, dr_amount, cr_amount, details FROM customersledger WHERE customersledger_id = ?");
$result->bind_param('i', $id);
$result->execute();
$result->store_result(); // Store the result set

// Check if a row is found
if ($result->num_rows > 0) {
    // Bind the result columns to variables
    $result->bind_result($customersledger_id, $customer_name, $date, $dr_amount, $cr_amount, $details);

    // Fetch the first (and only) row
    $result->fetch();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
<form action="saveeditcustomersledger.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Edit Customers Ledger</h4></center>
    <hr>
    <div id="ac">
    <input type="hidden" name="memi" value="<?php echo $customersledger_id; ?>" />

    <span>Date: </span><input type="date" style="width:260px; height:30px;" name="date" value="<?php echo $date; ?>"/><br>
    <span>Customer : </span><input type="text" style="width:265px; height:30px;" name="customer_name" value="<?php echo $customer_name; ?>"/><br>
    <span>DR_Amount: </span><input type="text" id="txt1" style="width:260px; height:30px;" name="dr_amount" value="<?php echo $dr_amount; ?>"/><br>
    <span>Cr_Amount: </span><input type="text" style="width:260px; height:30px;" name="cr_amount" value="<?php echo $cr_amount; ?>"/><br>
    <span>Details: </span><input type="text" style="width:260px; height:30px;" name="details"  value="<?php echo $details; ?>"/><br>
    <div style="float:right; margin-right:10px;">
        <button class="btn btn-success btn-block btn-large" style="width:267px;">
            <i class="icon icon-save icon-large"></i> Save Changes
        </button>
    </div>
    </div>
</form>
</body>
</html>
