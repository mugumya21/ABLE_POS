<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savecashtransfers.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Cash Transfer</h4></center>
    <hr>
    <div id="ac">
        <?php
        include('../connect.php');

        // Prepare and execute the query to get cash_at_hand from salessummary
        $result = $conn->prepare("SELECT   amount FROM cashathand");
        $result->execute();

        // Bind the result to a variable
        $result->bind_result($cash_at_hand);

        // Fetch the cash_at_hand value
        $result->fetch();

        // Close the result set
        $result->close();
        ?>

        <span><b>From</b> Cash_at_hand: </span>
        <?php echo "<strong>$cash_at_hand</strong>"; ?>
    <br>
        <span>Date: </span><input type="date" style="width:265px; height:30px;" name="date" /><br>
        <span>Amount: </span><input type="text" id="txt1" style="width:265px; height:30px;" name="amount" Required><br>
        <span><b>To</b> Bank Account : </span>
        <select name="to_account" style="width:265px; height:30px; margin-left:-5px;">
            <option></option>
            <?php
            // Prepare and execute the query to get account names from bankaccounts
            $result = $conn->prepare("SELECT account_name FROM bankaccounts");
            $result->execute();

            // Bind the result to a variable
            $result->bind_result($account_name);

            // Create the dropdown options
            while ($result->fetch()) {
                echo '<option>' . $account_name . '</option>';
            }

            // Close the result set
            $result->close();
            ?>
        </select><br>

        <span>Comment: </span><input type="text" style="width:265px; height:30px;" name="comment" placeholder="Comment"/><br>
        <div style="float:right; margin-right:10px;">
            <button class="btn btn-success btn-block btn-large" style="width:267px;"><i class="icon icon-save icon-large"></i> Save</button>
        </div>
    </div>
</form>
