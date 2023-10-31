<html>
<head>
<title>
POS
</title>
<?php
	require_once('auth.php');
?>

 
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
<?php
function createRandomPassword() {
	$chars = "003232303232023232023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pass = '' ;
	while ($i <= 7) {

		$num = rand() % 33;

		$tmp = substr($chars, $num, 1);

		$pass = $pass . $tmp;

		$i++;

	}
	return $pass;
}
$finalcode='RS-'.createRandomPassword();
?>



 <script language="javascript" type="text/javascript">
/* Visit http://www.yaldex.com/ for full source code
and get more free JavaScript, CSS and DHTML scripts! */
<!-- Begin
var timerID = null;
var timerRunning = false;
function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;
}
function showtime () {
var now = new Date();
var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" + ((hours >12) ? hours -12 :hours)
if (timeValue == "0") timeValue = 12;
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
timeValue += (hours >= 12) ? " P.M." : " A.M."
document.clock.face.value = timeValue;
timerID = setTimeout("showtime()",1000);
timerRunning = true;
}
function startclock() {
stopclock();
showtime();
}
window.onload=startclock;
// End -->
</SCRIPT>
<body>
<?php include('navfixed.php');?>
<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
          <div class="well sidebar-nav">
              <ul class="nav nav-list">
              <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
			<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales</a>  </li>             
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Customers</a>                                    </li>
			<li class="active"><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a>                                    </li>
			<li><a href="salesreport.php?d1=0&d2=0"><i class="icon-bar-chart icon-2x"></i> Sales Report</a>                </li>

			
					<br><br><br><br><br><br>		
			<li>
			 <div class="hero-unit-clock">
		
			<form name="clock">
			<font color="white">Time: <br></font>&nbsp;<input style="width:150px;" type="submit" class="trans" name="face" value="">
			</form>
			  </div>
			</li>
				
				</ul>     
          </div><!--/.well -->
        </div><!--/span-->
	<div class="span10">
	<div class="contentheader">
			<i class="icon-group"></i> Suppliers
			</div>
			<ul class="breadcrumb">
			<li><a href="index.php">Dashboard</a></li> /
			<li class="active">Suppliers</li>
			</ul>


<div style="margin-top: -19px; margin-bottom: 21px;">
<a  href="index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
			<?php
			include('../connect.php');

			// Check if the connection is successful
			if (!$conn) {
				die("Connection failed: " . $conn->connect_error);
			}

			// Create a prepared statement
			$query = "SELECT * FROM supliers ORDER BY suplier_id DESC";
			if ($result = $conn->prepare($query)) {
				$result->execute();

				// Get the number of rows
				$result->store_result();
				$rowcount = $result->num_rows;

				// Process the results here

				// Don't forget to close the result set when you're done
				$result->close();
			} else {
				die("Query failed: " . $conn->error);
			}

			// Close the database connection when you're done
			$conn->close();
			?>

			<div style="text-align:center;">
			Total Number of Suppliers: <font color="green" style="font:bold 22px 'Aleo';"><?php echo $rowcount;?></font>
			</div>
</div>
<input type="text" name="filter" style="height:35px; margin-top: -1px;" value="" id="filter" placeholder="Search Supplier..." autocomplete="off" />
<a rel="facebox" href="addsupplier.php"><Button type="submit" class="btn btn-info" style="float:right; width:230px; height:35px;" /><i class="icon-plus-sign icon-large"></i> Add Supplier</button></a><br><br>


<table class="table table-bordered" id="resultTable" data-responsive="table" style="text-align: left;">
	<thead>
		<tr>
			<th> Supplier </th>
			<th> Contact Person </th>
			<th> Address </th>
			<th> Contact No.</th>
			<th> Action </th>
			<!-- <th width="120"> Action </th> -->
		</tr>
	</thead>
	<tbody>
		
			<?php
		include('../connect.php');

		// Check if the connection is successful
		if (!$conn) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Create a prepared statement
		$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$recordsPerPage = 5;
		$offset = ($currentPage - 1) * $recordsPerPage;
		$sql = "SELECT * FROM supliers ORDER BY suplier_id  DESC LIMIT $offset, $recordsPerPage";
	   $result = $conn->query($sql);


		if ($result -> num_rows >0) {
			while ($row = $result->fetch_assoc()) {
				echo '<tr class="record">';
				echo '<td>' . $row['suplier_name'] . '</td>';
				echo '<td>' . $row['contact_person'] . '</td>';
				echo '<td>' . $row['suplier_address'] . '</td>';
				echo '<td>' . $row['suplier_contact'] . '</td>';
				echo '<td>';
		   // Check if the user is a 'SuperAdmin' or 'Admin' to display action buttons
		   if ($position == 'SuperAdmin' || $position == 'Admin') {
			echo '<div style="display: flex; flex-direction: row;">';
			echo '<a rel="facebox" href="editsupplier.php?id=' . $row['suplier_id'] . '"><button class="btn btn-warning btn-mini"><i class="icon-edit icon-white"></i> Edit</button></a>';
			echo '<form method="POST" action="deletesupplier.php" style="margin-left: 5px;">';
			echo '<input type="hidden" name="id" value="' . $row['suplier_id'] . '">';
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
	echo '<tr><td colspan="5">No supplier found.</td></tr>';
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
                                echo '<li><a href="supplier.php?page=' . $i . '">' . $i . '</a></li>';
                            }
                        ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

<script src="js/jquery.js"></script>
  <script type="text/javascript">

</script>
</body>

</html>