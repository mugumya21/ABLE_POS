<?php
include('../connect.php'); // Use the correct relative path
// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$result = $conn->prepare("SELECT * FROM products WHERE product_id= ?");
$result->bind_param('i', $id);
$result->execute();
$row = $result->get_result()->fetch_assoc(); // Fetch a single row

// Check if a row is found
if ($row) {
?>
<!-- Rest of your code... -->

<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditproduct.php" method="post">
    <center><h4><i class="icon-edit icon-large"></i> Edit Product</h4></center>
    <hr>
    <div id="ac">
        <input type="hidden" name="memi" value="<?php echo $id; ?>" />
        <span>Product Name : </span><input type="text" style="width:260px; height:30px;" name="name"  value="<?php echo $row['product_name']; ?>" Required/><br>
        <span>Qty unit : </span><input type="text" name="qty_unit" style="width: 260px; height: 30px;" placeholder="kg,dozen,pc,bag,box,roll,bundles,cnt"  value="<?php echo $row['qty_unit']; ?>"required/><br>
        <span>Product Type : </span>
        <select name="product_type" style="width:265px; height:30px; margin-left:-5px;">
        <option value="">Select a Product Category</option> <!-- Add an initial empty option -->
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT product_type FROM productcategory");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($product_type);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $product_type . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
        <span>Date Arrival: </span><input type="date" style="width:260px; height:30px;" name="date_arrival" value="<?php echo $row['date_arrival']; ?>" /><br>
        <span>Expiry Date : </span><input type="date" style="width:260px; height:30px;" name="exdate" value="<?php echo $row['expiry_date']; ?>" /><br>
        <span>Selling Price : </span><input type="text" style="width:260px; height:30px;" id="txt1" name="price" value="<?php echo $row['price']; ?>" onkeyup="sum();" Required/><br>
        <span>Original Price : </span><input type="text" style="width:260px; height:30px;" id="txt2" name="o_price" value="<?php echo $row['o_price']; ?>" onkeyup="sum();" Required/><br>
        <span>Supplier : </span>
        <select name="supplier" style="width:260px; height:30px; margin-left:-5px;">
            <option value="">Select a Supplier</option> <!-- Add an initial empty option -->

            <?php
            // Fetch and display supplier options
            $results = $conn->prepare("SELECT suplier_name FROM supliers");
            $results->execute();
            $results->bind_result($supplierName);

            while ($results->fetch()) {
                echo '<option value="' . $supplierName . '">' . $supplierName . '</option>';
            }

            $results->close(); // Close the result set
            ?>
        </select>
        <br>
		<span>Quantity: </span><input type="number" style="width:260px; height:30px;" min="0" name="qty" value="<?php echo $row['qty']; ?>" /><br>

        <div style="float:right; margin-right:10px;">
            <button class="btn btn-success btn-block btn-large" style="width:260px;"><i class="icon icon-save icon-large"></i> Save Changes</button>
        </div>
    </div>
</form>

<?php
} else {
    echo 'No Product found.';
}

// Close the database connection
$conn->close();
?>
</body>
</html>
