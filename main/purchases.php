<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savepur.php" method="post">
<center><h4><i class="icon-plus-sign icon-large"></i> Add Purchase Invoices</h4></center>
<hr>
<div style="text-align:left;">
<div id="ac">

<span>Date: <br></span><input type="date" style="width:260px; height:30px;" name="date" placeholder="MM/DD/YYYY" /><br>

        <span>Invoice Number: </span><input type="text" style="width:260px; height:30px;" name="iv" /><br>
        <span>Supplier : </span>
        <select name="supplier" style="width:260px; height:30px; margin-left:-5px;">
            <option></option>
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
     
<span>Remarks:<br> </span><input type="text" style="width:260px; height:30px;" name="remarks" /><br>
<span>&nbsp;</span><input id="btn" type="submit" value="save" />

</div>
</div>
</form>