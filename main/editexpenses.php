<?php
// Include your database connection script
include('../connect.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$result = $conn->prepare("SELECT expenses_id, expense_type, date, amount_spent, comment FROM expenses WHERE expenses_id = ?");
$result->bind_param('i', $id);
$result->execute();
$result->store_result(); // Store the result set

// Check if a row is found
if ($result->num_rows > 0) {
    // Bind the result columns to variables
    $result->bind_result($expenses_id, $expense_type, $date, $amount_spent, $comment);

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
<form action="saveeditexpenses.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Edit Expense</h4></center>
    <hr>
    <div id="ac">
    <input type="hidden" name="memi" value="<?php echo $expenses_id; ?>" />

    <span>Date: </span><input type="date" style="width:260px; height:30px;" name="date" value="<?php echo $date; ?>"/><br>
    <span>Expense_type : </span><input type="text" style="width:265px; height:30px;" name="expense_type" value="<?php echo $expense_type; ?>"/><br>
    <span>Amount spent: </span><input type="text" id="txt1" style="width:260px; height:30px;" name="amount_spent" value="<?php echo $amount_spent; ?>"/><br>
    <span>Comment: </span><input type="text" style="width:260px; height:30px;" name="comment"  value="<?php echo $comment; ?>"/><br>
    <div style="float:right; margin-right:10px;">
        <button class="btn btn-success btn-block btn-large" style="width:267px;">
            <i class="icon icon-save icon-large"></i> Save Changes
        </button>
    </div>
    </div>
</form>
</body>
</html>
