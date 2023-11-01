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
                        <li class="active"><a href="cashaccounts.php"><i class="icon-list-alt icon-2x"></i> Cash Book</a></li>   
                        <li><a href="cashtransfer.php"><i class="icon-list-alt icon-2x"></i> Cash Transfer</a></li>             
                        <li ><a href="sales.php"><i class="icon-list-alt icon-2x"></i> Sales</a></li>
                        <li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a></li>
                        <li><a href="customer.php"><i class="icon-group icon-2x"></i> Customers</a></li>
         	
                        <li>
                            <div class="hero-unit-clock">
                             
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->            </div><!--/span-->
            <div class="span10">
                 <div class="contentheader">
                 <center> <i class="icon-table"></i> Cash Book </center></strong>
                </div>
            <?php 
    // Check for error message and display it
    if(isset($_SESSION['error_message'])) {
        echo '<h4><center>' . $_SESSION['error_message'] . '</center></h4>';
        // Unset the error message to prevent displaying it again on page reload
        unset($_SESSION['error_message']);
    }
    ?>
                <div id="mainmain">
     
                <?php
include('../connect.php');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get total cash sales from cashathand table
$sqlCashAtHand = "SELECT SUM(amount) AS total_cash_collections FROM cashathand";

// SQL query to get total cash sales from receipts table
$sqlReceipts = "SELECT SUM(total_amount) AS total_cash_collections FROM receipts";

// Combine the results using UNION
$sqlTotalCashSales = "SELECT SUM(total_cash_collections) AS total_cash_sales FROM (($sqlCashAtHand) UNION ($sqlReceipts)) AS combined_sales";

$resultTotalCashSales = $conn->query($sqlTotalCashSales);

// Check if the query was successful
if (!$resultTotalCashSales) {
    die("Error executing the query: " . $conn->error);
}

$rowTotalCashSales = $resultTotalCashSales->fetch_assoc();

// Check if a row was fetched
if ($rowTotalCashSales === null || $rowTotalCashSales['total_cash_sales'] === null) {
    $totalCashSales = 0; // Set a default value if no data is found
} else {
    $totalCashSales = $rowTotalCashSales['total_cash_sales'];
}

// Close the database connection
$conn->close();
?>
<a href="#">Total Cash collections <br><br><strong>Ugx <?php echo number_format($totalCashSales, 2); ?></strong></a>

                    <?php
                    include('../connect.php');

                    // Check if the connection is successful
                    if (!$conn) {
                        die("Connection failed: " . $conn->connect_error);
                    }
         

                    $sqlTotalCashDeposit = "SELECT SUM(amount) AS total_cash_deposit FROM salessummary WHERE sales_type = 'cash deposit'";
                    $resultTotalCashDeposit = $conn->query($sqlTotalCashDeposit);
                    $rowTotalCashDeposit = $resultTotalCashDeposit->fetch_assoc();
                    $totalCashDeposit = $rowTotalCashDeposit['total_cash_deposit'];
                    
                    // Now $totalCashDeposit contains the total amount for sales with sales_type 'cash deposit'
                    

                    
                    $sqlTotalInvoiceClearance = "SELECT SUM(amount) AS total_invoice_clearance FROM salessummary WHERE sales_type IN ('Credit Clearance Sales', 'credit clearance', 'credit', 'invoice clearance')";
                    $resultTotalInvoiceClearance = $conn->query($sqlTotalInvoiceClearance);
                    $rowTotalInvoiceClearance = $resultTotalInvoiceClearance->fetch_assoc();
                    $totalInvoiceClearance = $rowTotalInvoiceClearance['total_invoice_clearance'];
                    
                    // Now $totalInvoiceClearance contains the total amount for sales with sales_type 'credit' or 'invoice clearance'
                



                    // Close the database connection
                    $conn->close();
                    ?>
                    <a href="#">Cash Deposit <br><br><strong>Ugx <?php echo number_format($totalCashDeposit, 2); ?></strong></a>
                    <a href="#">Credit Clearance <br><br><strong>Ugx <?php echo number_format($totalInvoiceClearance, 2); ?></strong></a>

                <div class="clearfix"></div>
                </div>
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <?php
                        include('../connect.php');
                        // Check if the connection is successful
                        if (!$conn) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to get the counts
                        $sql1 = "SELECT COUNT(*) AS count1 FROM cashtransfers";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
                        $rowcount = $row1['count1'];

                        $sql2 = "SELECT COUNT(*) AS count2 FROM cashtransfers WHERE amount < 10";
                        $result2 = $conn->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        $rowcount123 = $row2['count2'];
                    ?>
              


</body>
</html>
