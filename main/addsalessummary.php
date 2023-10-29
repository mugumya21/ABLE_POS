<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savesalessummary.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add sales summary</h4></center>
    <hr>
    <div id="ac">
  
        <span>Sales Type : </span>
        <select name="sales_type" style="width:265px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            include('../connect.php');

            // Prepare and execute the query
            $result = $conn->prepare("SELECT sales_type FROM salescategory");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($sales_type);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $sales_type . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>
            <span>Date: </span><input type="date" style="width:265px; height:30px;" name="date" /><br>
            <span>Amount: </span><input type="text" id="txt1" style="width:265px; height:30px;" name="amount" Required><br>
            <span>Comment: </span><input type="text" style="width:265px; height:30px;" name="comment" placeholder="Comment"/><br>        <div style="float:right; margin-right:10px;">
            <button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Save</button>
        </div>
    </div>
</form>





