<?php
include('../connect.php');
$id = $_GET['id'];
$result = $conn->prepare("SELECT suplier_id, suplier_name, suplier_address, contact_person, suplier_contact FROM supliers WHERE suplier_id = ?");
$result->bind_param('i', $id);
$result->execute();
$result->store_result(); // Store the result set

// Check if a row is found
if ($result->num_rows > 0) {
    $result->bind_result($suplier_id, $suplier_name, $suplier_address, $contact_person, $suplier_contact);

    // Fetch the first (and only) row
    $result->fetch();
}
?>

<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<form action="saveeditsupplier.php" method="post">
    <center><h4><i class="icon-edit icon-large"></i> Edit Supplier</h4></center>
    <hr>
    <div id="ac">
        <input type="hidden" name="memi" value="<?php echo $suplier_id; ?>" />
        <span>Supplier Name:</span>
        <input type="text" style="width:265px; height:30px;" name="name" value="<?php echo $suplier_name; ?>" /><br>
        <span>Address:</span>
        <input type="text" style="width:265px; height:30px;" name="address" value="<?php echo $suplier_address; ?>" /><br>
        <span>Contact Person:</span>
        <input type="text" style="width:265px; height:30px;" name="cperson" value="<?php echo $contact_person; ?>" /><br>
        <span>Contact No.:</span>
        <input type="text" maxlength="11" style="width:265px; height:30px;" name="contact" value="<?php echo $suplier_contact; ?>" /><br>
        <div style="float:right; margin-right:10px;">
            <button class="btn btn-success btn-block btn-large" style="width:267px;">
                <i class="icon icon-save icon-large"></i> Save Changes
            </button>
        </div>
    </div>
</form>
