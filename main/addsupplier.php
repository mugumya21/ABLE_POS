<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="savesupplier.php" method="post">
    <center><h4><i class="icon-plus-sign icon-large"></i> Add Supplier</h4></center>
    <hr>
    <div id="ac">
        <span>Supplier Name:</span>
        <input type="text" name="name" style="width: 265px; height: 30px;" required /><br>
        <span>Address:</span>
        <input type="text" name="address" style="width: 265px; height: 30px;" /><br>
        <span>Contact Person:</span>
        <input type="text" name="cperson" style="width: 265px; height: 30px;" /><br>
        <span>Contact No.:</span>
        <input type="text" maxlength="11" name="contact" style="width: 265px; height: 30px;" /><br>
        <div style="float: right; margin-right: 10px;">
            <button class="btn btn-success btn-block btn-large" style="width: 267px;">
                <i class="icon icon-save icon-large"></i> Save
            </button>
        </div>
    </div>
</form>
