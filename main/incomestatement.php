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
                        <li class="active"><a href="cashaccounts.php"><i class="icon-list-alt icon-2x"></i>Statement</a></li>   
                        <li><a href="#"><i class="icon-list-alt icon-2x"></i> Cash Transfer</a></li>             
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
                 <center> <i class="icon-table"></i> Income Statement </center></strong>
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

// Calculate total cost (totalNetAmount) as before
$sqlTotalNetAmount = "SELECT SUM(qty * o_price) AS total_net_amount FROM products";
$resultTotalNetAmount = $conn->query($sqlTotalNetAmount);
if (!$resultTotalNetAmount) {
    die("Query failed: " . $conn->error);
}

$rowTotalNetAmount = $resultTotalNetAmount->fetch_assoc();
$totalNetAmount = $rowTotalNetAmount['total_net_amount'];

// Calculate total selling price
$sqlTotalSellingPrice = "SELECT SUM(price * qty_sold) AS total_selling_price FROM products";
$resultTotalSellingPrice = $conn->query($sqlTotalSellingPrice);
if (!$resultTotalSellingPrice) {
    die("Query failed: " . $conn->error);
}

$rowTotalSellingPrice = $resultTotalSellingPrice->fetch_assoc();
$totalSellingPrice = $rowTotalSellingPrice['total_selling_price'];

// Calculate profit or loss
$profitOrLoss = $totalSellingPrice - $totalNetAmount;

// Close the database connection
$conn->close();
?>

<!-- HTML Output -->
<a href="#">Total net worth in business<br><br><strong>Ugx <?php echo number_format($totalNetAmount, 2); ?></strong></a>



</body>
</html>
