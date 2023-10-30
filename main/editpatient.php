<?php
// Include your database connection script
include('../connect.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
$result = $conn->prepare("SELECT * FROM patient WHERE patient_id= ?");
$result->bind_param('i', $id);
$result->execute();
$row = $result->get_result()->fetch_assoc(); // Fetch a single row

if ($row) {
?>
<!DOCTYPE html>
<html>
<head>
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
    <form action="saveeditpatient.php" method="post">
        <center><h4><i class="icon-edit icon-large"></i> Edit Patient</h4></center>
        <hr>
        <div id="ac">
            <input type="hidden" name="memi" value="<?php echo $id; ?>" />
            <span>Full Name : </span><input type="text" style="width:265px; height:30px;" name="name" value="<?php echo $row['patient_name']; ?>" /><br>
            <span>Address : </span><input type="text" style="width:265px; height:30px;" name="address" value="<?php echo $row['address']; ?>" /><br>
            <span>Contact : </span><input type="text" style="width:265px; height:30px;" name="contact" value="<?php echo $row['contact']; ?>" /><br>
           
            <div style="float:right; margin-right:10px;">
                <button class="btn btn-success btn-block btn-large" style="width:267px;">
                    <i class="icon icon-save icon-large"></i> Save Changes
                </button>
            </div>
        </div>
    </form>
</body>
</html>
<?php
} else {
    echo 'No patient found.';
}

// Close the database connection
$conn->close();
?>
