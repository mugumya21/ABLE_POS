<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />

<script>
function sum() {
    var txt1 = parseFloat(document.getElementById('txt1').value) || 0;
    var txt2 = parseFloat(document.getElementById('txt2').value) || 0;
    var txt11 = parseFloat(document.getElementById('txt11').value) || 0;

    // Calculate the profit
    var profit = txt1 - txt2;
    document.getElementById('txt3').value = profit.toFixed(2);
}
</script>

<form action="saveproduct.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Product</h4></center>
    <hr>
    <div id="ac">
        <span>Name : </span><input type="text" name="name" style="width: 260px; height: 30px;" required/><br>
        <span>Qty unit : </span><input type="text" name="qty_unit" style="width: 260px; height: 30px;" placeholder="kg,dozen,pc,bag,box,roll,bundles,cnt" required/><br>
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
        <span>Expiration Date: </span><input type="date" style="width:260px; height:30px;" name="exdate" /><br>
        <span>Date Arrival: </span><input type="date" style="width:260px; height:30px;" name="date_arrival" /><br>
        <span>Selling Price: </span><input type="text" id="txt1" style="width:260px; height:30px;" name="price" onkeyup="sum();" Required><br>
        <span>Original Price : </span><input type="text" id="txt2" style="width:260px; height:30px;" name="o_price" onkeyup="sum();" Required><br>
        <span>Supplier : </span>
        <select name="supplier" style="width:260px; height:30px; margin-left:-5px;">
        <option value="">Select a Supplier</option> <!-- Add an initial empty option -->
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT suplier_name FROM supliers");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($supplierName);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $supplierName . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
        <span>Quantity : </span><input type="number" style="width:260px; height:30px;" min="0" id="txt11" onkeyup="sum();" name="qty" Required ><br>
        <div style="float:right; margin-right:10px;">
            <button class="btn btn-success btn-block btn-large" style="width:260px;"><i class="icon icon-save icon-large"></i> Save</button>
        </div>
    </div>
</form>
