<?php
include('../connect.php'); // Use the correct relative path

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$id = $_GET['id'];
$result = $conn->prepare("SELECT * FROM purchasesreport WHERE id = ?");
$result->bind_param('i', $id);
$result->execute();
$row = $result->get_result()->fetch_assoc(); // Fetch a single row// Store the result set

if ($row) {

?>

<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditpurchasesummary.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Edit Purchases Summary</h4></center>
    <hr>
    <div id="ac">
    <input type="hidden" name="memi" value="<?php echo $id; ?>" />
        <span>Purchases Type : </span>
        <select name="purchases_type" style="width:265px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT purchases_type FROM purchasescategory");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($purchases_type);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $purchases_type . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
        
        <span>Supplier : </span>
        <select name="suplier_name" style="width:265px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT suplier_name FROM supliers");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($suplier_name);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $suplier_name . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
            <span>Date: </span><input type="date" style="width:260px; height:30px;" name="date"  value="<?php echo $row['date']; ?>"/><br>
            <span>Amount: </span><input type="text" id="txt1" style="width:260px; height:30px;" name="amount"  value="<?php echo $row['amount']; ?>" /><br>
            <span>&nbsp;</span><input id="btn" type="submit" value="save" />
        </div>
    </div>
</form>
<?php
} else {
    echo 'No Purchase summary found.';
}

// Close the database connection
$conn->close();
?>
</body>
</html>





