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
                        <li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>
			<li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a>  </li>
			<li class="active"> <a href="expenses.php"><i class="icon-list-alt icon-2x"></i>Expenses</a></li>
			<li><a href="patient.php"><i class="icon-group icon-2x"></i> Patients</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a>                                    </li>

                        <br><br><br>		
                        <li>
                            <div class="hero-unit-clock">
                               
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->
            </div><!--/span-->
            <div class="span10">
                <div class="contentheader">
                    <i class="icon-table"></i> Expenses (Cash Payout)
                </div>
                <ul class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li> /
                    <li class="active">Expenses</li>
                </ul>
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <a  href="index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
                    <?php
                        include('../connect.php');
                        // Check if the connection is successful
                        if (!$conn) {
                            die("Connection failed: " . $conn->connect_error);
                        }

						// Query to get the counts
						$sql1 = "SELECT COUNT(*) AS count1 FROM expenses";
						$result1 = $conn->query($sql1);
						$row1 = $result1->fetch_assoc();
						$rowcount = $row1['count1'];

						$sql2 = "SELECT COUNT(*) AS count2 FROM expenses WHERE amount_spent < 10";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$rowcount123 = $row2['count2'];
                    ?>
                   
                </div>
				<input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Search Expense Name..." autocomplete="off" />
                <a rel="facebox" href="addexpensescategory.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Expense Category</button></a><br><br>
                <a rel="facebox" href="addexpenses.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Expense</button></a><br><br>
                <table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
                    <thead>
                        <tr>
                            <th width="12%"> Expense Name </th>
                            <th width="10%">  Date </th>        
                            <th width="5%">  Amount spent </th>
                            <th width="8%"> Comment</th>
                            <th width="8%"> Action</th>

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

                    // Query to retrieve expenses data with paging for every 5 records
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    $recordsPerPage = 5;
                    $offset = ($currentPage - 1) * $recordsPerPage;
                    $sql = "SELECT * FROM expenses ORDER BY expenses_id  DESC LIMIT $offset, $recordsPerPage";
                   $result = $conn->query($sql);    // Query to retrieve product data
                
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['expense_type'] . '</td>';
                            echo '<td>' . $row['date'] . '</td>';
                            echo '<td>' . $row['amount_spent'] . '</td>';
                            echo '<td>' . $row['comment'] . '</td>';
                            echo '<td>';

                            // Check if the user is a 'SuperAdmin' or 'Admin' to display action buttons
                            if ($position == 'SuperAdmin' || $position == 'Admin') {
                                echo '<div style="display: flex; flex-direction: row;">';
                                echo '<a rel="facebox" href="editexpenses.php?id=' . $row['expenses_id'] . '"><button class="btn btn-warning btn-mini"><i class="icon-edit icon-white"></i> Edit</button></a>';
                                echo '<form method="POST" action="deleteexpenses.php" style="margin-left: 5px;">';
                                echo '<input type="hidden" name="id" value="' . $row['expenses_id'] . '">';
                                echo '<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm(\'Are you sure want to delete? There is NO undo!\')">';
                                echo '<i class="icon-trash"></i> Delete';
                                echo '</button>';
                                echo '</form>';
                                echo '</div>';
          
                        }else {
                            echo 'No actions available.';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5">No Records found.</td></tr>';
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
                                echo '<li><a href="expenses.php?page=' . $i . '">' . $i . '</a></li>';
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

</script>


</body>
</html>
