<?php
require_once('auth.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
    <!-- Include your CSS and JavaScript resources here -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Add your custom CSS styles if needed -->
</head>
<body>
<?php include('navfixed.php');?>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="active"><a href="index.php"><i class="icon-dashboard icon-large"></i> Dashboard <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li> 
                    <!-- Add other menu items as needed -->
                </ul>
            </div><!--/.well -->
        </div><!--/span-->
        <div class="span10">
            <div class="contentheader">
                <i class="icon-dashboard"></i> Dashboard
            </div>
            <ul class="breadcrumb">
                <a href="index.php"><li>Dashboard</li></a> /
                <li class="active">Purchase Lists</li>
            </ul>
            <div id="maintable">
                <!-- Add your content here -->
                <!-- Example form and table -->
                <form action="savepurchasesitem.php" method="post">
                    <input type="hidden" name="invoice" value="<?php echo $_GET['iv']; ?>" />
                    <select name="product" style="width: 600px;">
                        <?php
                        $conn = new mysqli("localhost", "root", "", "sales"); // Replace with your database credentials
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        $sql = "SELECT * FROM products";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['product_name'] . '">' . $row['product_code'] . ' - ' . $row['product_name'] . '</option>';
                            }
                        }
                        $conn->close();
                        ?>
                    </select>
                    <input type="text" name="qty" value="" placeholder="Qty" autocomplete="off" style="width: 68px; height:30px; padding-top: 6px; padding-bottom: 6px; margin-right: 4px;" />
                    <button type="submit" class="btn btn-info" style="width: 123px; height:35px; margin-top:-5px;"><i class="icon-save icon-large"></i> Save</button>
                </form>
                <!-- Add your table and other content here -->
            </div>
        </div>
    </div>
</div>

<!-- Include your JavaScript code here -->
<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<!-- Add your custom JavaScript code if needed -->

</body>
</html>
