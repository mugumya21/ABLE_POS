<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />


<form action="savepurchasesitem.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Purchased Product</h4>
    <div id="ac">
        <span>Name : </span>
        <select name="product" style="width:260px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT product_name FROM products");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($product_name);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $product_name . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
        
        <span>Qty: </span><input type="number" name="qty" style="width: 260px; height: 30px;" required/><br>
        <span>Cost </span><input type="text" id="txt2" style="width:260px; height:30px;" name="cost" onkeyup="sum();" Required><br>
        <span>Supplier: </span>
        <select name="suplier_name" style="width:260px; height:30px; margin-left:-5px;">
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
       <br>
        <div >
            <button class="btn btn-success btn-block btn-large" ><i class="icon icon-save icon-large"></i> Save</button>
        </div>
    </div>
        </center>
</form>
