<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savecustomersledger.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Customers Ledger</h4></center>
    <hr>
    <div id="ac">
    <span>Date: </span><input type="date" style="width:260px; height:30px;" name="date" /><br>
        <span>Customer : </span>
        <select name="customer_name" style="width:265px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT customer_name FROM customer");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($customer_name);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $customer_name . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
        
       
            <span>DR_Amount: </span><input type="text" id="txt1" style="width:260px; height:30px;" name="dr_amount"><br>
            <span>Cr_Amount: </span><input type="text" style="width:260px; height:30px;" name="cr_amount" placeholder=""/><br>        <div style="float:right; margin-right:10px;">
            <span>Details: </span><input type="text" style="width:260px; height:30px;" name="details" placeholder=""/><br>        <div style="float:right; margin-right:10px;">

            <span>&nbsp;</span><input id="btn" type="submit" value="save" />
        </div>
    </div>
</form>





