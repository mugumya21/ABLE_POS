<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveaccounts.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Account </h4></center>
    <hr>
    <div id="ac">
        <span>Account: </span>
        <select name="account_type" style="width: 265px; height: 30px;" required>
            <option value="Bank">Bank Account</option>
        </select><br>
        <span>Bank Name:<strong>*</strong> </span>
        <input type="text" style="width: 265px; height: 30px;" name="account_name" required /><br>
 
        <div style="float: right; margin-right: 10px;">
            <button class="btn btn-success btn-block btn-large" style="width: 267px;"><i class="icon icon-save icon-large"></i> Save</button>
        </div>
    </div>
</form>
