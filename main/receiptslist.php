<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
    <?php require_once('auth.php'); ?>

    
    
    <?php
                $position=$_SESSION['SESS_LAST_NAME'];
                if($position=='cashier') {
                ?>

                <a href="../index.php">Logout</a>
                <?php
                }
                ?>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
    <!--sa poip up-->
    <script src="jeffartagame.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/application.js" type="text/javascript" charset="utf-8"></script>
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
                loadingImage : 'src/loading.gif',
                closeImage   : 'src/closelabel.png'
            })
        })
    </script>
</head>
<body>
    <?php include('navfixed.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                        <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
                        <li><a href="sales.php"><i class="icon-shopping-cart icon-2x"></i> Sales</a></li>             
                        <li class="active"><a href="receiptslist.php"><i class="icon-list-alt icon-2x"></i> Receipts</a></li>
                        <li><a href="#"><i class="icon-group icon-2x"></i> Invoices</a></li>
                        <br><br><br>		
                        <li>
                            <div class="hero-unit-clock">
                                <form name="clock">
                                </form>
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->
            </div><!--/span-->
            <div class="span10">
                <div class="contentheader">
                    <i class="icon-table"></i> Receipts
                </div>
                <ul class="breadcrumb">
                    <li><a href="sales.php">Sales</a></li> /
                    <li class="active">Receipts</li>
                </ul>
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <a  href="sales.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon-shopping-cart icon-2x"></i> Back</button></a>
                    <?php
                        include('../connect.php');
                        // Check if the connection is successful
                        if (!$conn) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to get the counts
                        $sql1 = "SELECT COUNT(*) AS count1 FROM receipts";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
                        $rowcount = $row1['count1'];

                        $sql2 = "SELECT COUNT(*) AS count2 FROM receipts WHERE total_amount< 10";
                        $result2 = $conn->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        $rowcount123 = $row2['count2'];
                    ?>
                    <div style="text-align:center;">
                        Total Number of Receipts:  <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $rowcount;?>]</font>
                        <?php
// Calculate total amount from all receipts
$sqlTotalAmount = "SELECT SUM(total_amount) AS totalAmount FROM receipts";
$resultTotalAmount = $conn->query($sqlTotalAmount);
$rowTotalAmount = $resultTotalAmount->fetch_assoc();
$totalAmount = $rowTotalAmount['totalAmount'];
?>
<br><br>
<p>Total amount Ugx <strong><?php echo number_format($totalAmount, 2); ?></strong></p>
            
                    </div>
                    <div style="text-align:center;">
                    </div>
                </div>
                <input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Search Receipt No..." autocomplete="off" />
                
    <table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
                    <thead>
                        <tr>
                        <th width="10%">  Date</th>
                            <th width="10%"> Receipt No </th>
                            <th width="10%"> Total Amount </th>
                  
                        </tr>
                    </thead>
                    <tbody>
                    <?php
// Include your database connection script
include('../connect.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to retrieve product data
$sql = "SELECT * FROM receipts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<td>' . $row['receipt_date'] . '</td>';
        echo '<td><a href="receipt.php?receipt_id=' . $row['receipt_id'] . '" style="color: blue; text-decoration: underline;">' . $row['receipt_id'] . '</a></td>';
        
        echo '<td>' . $row['total_amount'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="5">No Receipts found.</td></tr>';
}

// Close the database connection
$conn->close();
?>


                    </tbody>
                </table>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
   
    </script>
</body>
</html>