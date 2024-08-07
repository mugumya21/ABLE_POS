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
                        <li class="active"><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a></li>
                        <li><a href="#.php"><i class="icon-list-alt icon-2x"></i> Convert Qty Unit</a></li>
                        <li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a></li>
                        <li><a href="customer.php"><i class="icon-group icon-2x"></i> Customers</a></li>
                        <li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a></li>
                        <br><br><br>		
                        <li>
                            <div class="hero-unit-clock">
                             
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->            </div><!--/span-->
            <div class="span10">
                <div class="contentheader">
                    <i class="icon-table"></i> Products
                </div>
                <ul class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li> /
                    <li class="active">Products</li>
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
                        $sql1 = "SELECT COUNT(*) AS count1 FROM products";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
                        $rowcount = $row1['count1'];

                        $sql2 = "SELECT COUNT(*) AS count2 FROM products WHERE qty < 10";
                        $result2 = $conn->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        $rowcount123 = $row2['count2'];
                    ?>
                    <div style="text-align:center;">
                        Total Number of Products:  <font color="green" style="font:bold 22px 'Aleo';">[<?php echo $rowcount;?>]</font>
                    </div>
                    <div style="text-align:center;">
                        <font style="color:rgb(255, 95, 66);; font:bold 22px 'Aleo';">[<?php echo $rowcount123;?>]</font> Products are below QTY of 10 
                    </div>
                </div>
                <input type="text" style="padding:15px;" name="filter" value="" id="filter" placeholder="Search Product..." autocomplete="off" />
                <a rel="facebox" href="addproductcategory.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Product Category</button></a><br><br>
                <a rel="facebox" href="addproduct.php"><button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Product</button></a><br><br>
                <table class="hoverTable" id="resultTable" data-responsive="table" style="text-align: left;">
                    <thead>
                        <tr>
                            <th width="15%"> Product Name </th>
                            <th width="10%"> Qty Unit</th>
                            <th width="10%"> QTY </th>
                            <th width="10%"> Qty Sold </th>
                            <th width="10%"> Qty Left </th>
                            <th width="10%"> Action </th>
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

                        // Query to retrieve product data with paging for every 20 records
                        $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $recordsPerPage = 20;
                        $offset = ($currentPage - 1) * $recordsPerPage;
                        $sql = "SELECT * FROM products LIMIT $offset, $recordsPerPage";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['product_name'] . '</td>';
                                echo '<td>' . $row['qty_unit'] . '</td>';
                                echo '<td>' . $row['qty'] . '</td>';
                                echo '<td>' . $row['qty_sold'] . '</td>';
                                echo '<td>' . ($row['qty'] - $row['qty_sold']) . '</td>';
                                echo '<td>';

                                // Check if the user is a 'SuperAdmin' or 'Admin' to display action buttons
                                if ($position == 'SuperAdmin' || $position == 'Admin') {
                                    echo '<div style="display: flex; flex-direction: row;">';
                                    echo '<a rel="facebox" href="editproduct.php?id=' . $row['product_id'] . '"><button class="btn btn-warning btn-mini"><i class="icon-edit icon-white"></i> Edit</button></a>';
                                    echo '<form method="POST" action="deleteproduct.php" style="margin-left: 5px;">';
                                    echo '<input type="hidden" name="id" value="' . $row['product_id'] . '">';
                                    echo '<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm(\'Are you sure want to delete? There is NO undo!\')">';
                                    echo '<i class="icon-trash"></i> Delete';
                                    echo '</button>';
                                    echo '</form>';
                                    echo '</div>';
                                } else {
                                    echo 'No actions available.';
                                }
                                echo '</td>';
                                echo '</tr>';
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
                                echo '<li><a href="products.php?page=' . $i . '">' . $i . '</a></li>';
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
    // $(document).ready(function() {
    //     // Check the qty_left for each product row and display alert if qty_left is 3 or less
    //     $('#resultTable tbody tr').each(function() {
    //         var qtyLeft = parseInt($(this).find('td:eq(1)').text()); // Assuming the column index for qty_left is 3
    //         if (qtyLeft <=1) {
    //             alert('Alert: Qty Left for product ' + $(this).find('td:eq(0)').text() + ' is ' + qtyLeft);
    //         }
    //     });
    // });
</script>
</body>
</html>
