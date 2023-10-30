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
                        <li ><a href="cashaccounts.php"><i class="icon-list-alt icon-2x"></i> Cash Records</a></li>   
                        <li class="active"><a href="cashtransfer.php"><i class="icon-list-alt icon-2x"></i> Cash Transfer</a></li>             
                        <li ><a href="sales.php"><i class="icon-list-alt icon-2x"></i> Sales</a></li>
                        <li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a></li>
                        <li><a href="patient.php"><i class="icon-group icon-2x"></i> Patients</a></li>
         	
                        <li>
                            <div class="hero-unit-clock">
                             
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->            </div><!--/span-->
            <div class="span10">
            <div class="contentheader">
            <center>  <i class="icon-table"></i>Today's Cash Transfer</center></strong>

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

$sqlTotalCashInHand = "SELECT  amount FROM cashathand";
$resultTotalCashInHand = $conn->query($sqlTotalCashInHand);

// Check if the query was successful
if (!$resultTotalCashInHand) {
    die("Error executing the query: " . $conn->error);
}

$rowTotalCashInHand = $resultTotalCashInHand->fetch_assoc();

// Check if a row was fetched
if ($rowTotalCashInHand === null) {
    $totalCashInHand = 0; // Set a default value if no data is found
} else {
    $totalCashInHand = $rowTotalCashInHand['amount'];
}

// Close the database connection
$conn->close();
?>

                            <!-- Display Total Cash in Hand -->
                            <a href="cashathand.php">Total Cash Collection <br><br><strong>Ugx <?php echo number_format($totalCashInHand, 2); ?></strong></a>

                    <!-- Display Total Cash in Banks -->
                    <?php
                    include('../connect.php');

                    // Check if the connection is successful
                    if (!$conn) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to calculate the total cash in banks from bank accounts
                    $sqlTotalCashInBanks = "SELECT SUM(amount) AS total_cash_in_banks FROM bankaccounts";
                    $resultTotalCashInBanks = $conn->query($sqlTotalCashInBanks);
                    $rowTotalCashInBanks = $resultTotalCashInBanks->fetch_assoc();
                    $totalCashInBanks = $rowTotalCashInBanks['total_cash_in_banks'];

                    // Close the database connection
                    $conn->close();
                    ?>
                    <a href="cashatbank.php">Cash at Bank <br><br><strong>Ugx <?php echo number_format($totalCashInBanks, 2); ?></strong></a>

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
              
                <a rel="facebox" href="addcashaccounts.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Bank Account</button></a><br><br>
                <a rel="facebox" href="addcashtransfers.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Cash Transfer</button></a><br><br>


                <table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
                    <thead>
                        <tr>
                            <th width="10%"> Date </th>
                            <th width="10%"> Amount </th>
                            <th width="10%"> To Account </th>
                            <th width="10%"> Comment </th>

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

                        // Query to retrieve product data with paging for every 5 records
                        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $recordsPerPage = 5;
                        $offset = ($currentPage - 1) * $recordsPerPage;
                        $sql = "SELECT * FROM cashtransfers ORDER BY date DESC LIMIT $offset, $recordsPerPage";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . $row['amount'] . '</td>';
                                echo '<td>' . $row['to_account'] . '</td>';
                                echo '<td>' . $row['comment'] . '</td>';

                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5">No cash transfers found.</td></tr>';
                        }

                        // Close the database connection
                        $conn->close();
                    ?>
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div class="pagination">
                    <ul>
                        <?php
                            // Calculate the total number of pages
                            $totalPages = ceil($rowcount / $recordsPerPage);

                            // Generate pagination links
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li><a href="cashaccounts.php?page=' . $i . '">' . $i . '</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        // Your JavaScript code here
    </script>
</body>
</html>
