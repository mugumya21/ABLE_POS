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
    <script src="argiepolicarpio.js" type="text/javascript" charset="utf-8"></script>
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
<?php include('navfixed.php');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li ><a href="index.php"><i class="icon-dashboard icon-large"></i> Dashboard <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li> 
                    <li class="active"><a href="purchaseslist.php"><i class="icon-table icon-large"></i> Purchases <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li>
                    <li><a href="addpurchases_item.php"><i class="icon-table icon-large"></i> Add Purchases <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li>
                    <li><a href="products.php"><i class="icon-table icon-large"></i> Products <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li>
                    <li><a href="customer.php"><i class="icon-group icon-large"></i> Customers <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li>
                    <li><a href="supplier.php"><i class="icon-group icon-large"></i> Suppliers <div class="pull-right"><i class="icon-circle-arrow-right icon-large"></i></div></a></li>
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
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <a  href="index.php"><button class="btn btn-default btn-large" style="float: none;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
                </div>
				<input type="text" style="padding: 15px;" name="filter" value="" id="filter" placeholder="Search date..." autocomplete="off" onkeyup="searchdate()" />
                <a rel="facebox" href="addpurchasescategory.php"><button type="button" class="btn btn-info" style="float:right; width:230px; height:35px;"><i class="icon-plus-sign icon-large"></i> Add Purchases Category</button></a><br><br>

                <a rel="facebox" href="addpurchases.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Purchase Summary</button></a><br><br>
                <?php
                        include('../connect.php');
                        // Check if the connection is successful
                        if (!$conn) {
                            die("Connection failed: " . $conn->connect_error);
                        }

						// Query to get the counts
						$sql1 = "SELECT COUNT(*) AS count1 FROM purchasesreport";
						$result1 = $conn->query($sql1);
						$row1 = $result1->fetch_assoc();
						$rowcount = $row1['count1'];

						$sql2 = "SELECT COUNT(*) AS count2 FROM purchasesreport WHERE amount < 10";
						$result2 = $conn->query($sql2);
						$row2 = $result2->fetch_assoc();
						$rowcount123 = $row2['count2'];
                    ?>
                <table class="table table-bordered" id="resultTable" data-responsive="table" style="text-align: left;">
                    <thead>
                        <tr>
                            <th width="15%"> Date </th>
                            <th width="15%"> Purchase Type </th>
                            <th width="15%"> Supplier </th>
                            <th width="15%"> Amount </th>
                            <th width="15%"> Action </th>
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

                    // Assume you have a variable $position to store the user's role

                     // Query to retrieve purchasesreport data with paging for every 5 records
                     $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                     $recordsPerPage = 5;
                     $offset = ($currentPage - 1) * $recordsPerPage;
                     $sql = "SELECT * FROM purchasesreport ORDER BY purchasesreport_id  DESC LIMIT $offset, $recordsPerPage";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Check if $row['purchasesreport_id'] is defined and has a valid value
                            if (isset($row['purchasesreport_id'])) {
                                $purchasesreport_id = $row['purchasesreport_id'];
                            } else {
                                $purchasesreport_id = ''; // Set a default value or leave it empty if it's not defined
                            }
                            ?>
                            <tr>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['purchases_type']; ?></td>
                                <td><?php echo isset($row['suplier_name']) ? $row['suplier_name'] : ''; ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td>
    <?php
    // Check if the user is a 'SuperAdmin' or 'Admin' to display action buttons
    if ($position == 'SuperAdmin' || $position == 'Admin') {
        ?>
        <div style="display: flex; flex-direction: row;">
        <!-- <a rel="facebox" href="editpurchasesummary.php?id=' . $row['purchasesreport_id'] . '"><button class="btn btn-warning btn-mini"><i class="icon-edit icon-white"></i> Edit</button></a> -->
            <form method="POST" action="deletepp.php" style="margin-left: 5px;">
                <input type="hidden" name="id" value="<?php echo $purchasesreport_id; ?>">
                <button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure want to delete? There is NO undo!')">
                    <i class="icon-trash"></i> Delete
                </button>
            </form>
        </div>
        <?php
    } else {
        // Display "No Edit/Delete" for cashiers
        echo "No Edit/Delete";
    }
    ?>
</td>

                            </tr>
                            <?php
                        }
                    } else {
                        echo '<tr><td colspan="5">No products found.</td></tr>';
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
                                echo '<li><a href="purchaseslist.php?page=' . $i . '">' . $i . '</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
     <script type="text/javascript">
                function searchdate() {
                    var filter = document.getElementById('filter').value.toUpperCase();
                    var table = document.getElementById('resultTable');
                    var rows = table.getElementsByTagName('tr');

                    for (var i = 0; i < rows.length; i++) {
                        var td = rows[i].getElementsByTagName('td')[0]; 
                        if (td) {
                            var purchaseType = td.textContent || td.innerText;

                            if (purchaseType.toUpperCase().indexOf(filter) > -1) {
                                rows[i].style.display = '';
                            } else {
                                rows[i].style.display = 'none';
                            }
                        }
                    }
                }
    </script>

</body>
</html>
