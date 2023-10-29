<?php
// // Establish a database connection (replace these values with your database credentials)
// include('../connect.php');

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// // Fetch installation timestamp and subscription period from the database based on the ID
// $id = 1; // You can change this value as per your requirement
// $sql = "SELECT installation_timestamp, subscription_period FROM installation_info_table WHERE id = $id";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $installationTimestamp = strtotime($row["installation_timestamp"]);
//         $subscriptionPeriod = $row["subscription_period"]; // 1 for week, 2 for 6 months, 3 for year
//     }
// } else {
//     // Default installation timestamp and subscription period if not found in the database
//     $installationTimestamp = strtotime("2023-10-01");
//     $subscriptionPeriod = 1; // Default to 1 week
// }

// $conn->close();

// $currentTimestamp = time();
// $oneWeekInSeconds = 7 * 24 * 60 * 60; // One week in seconds
// $sixMonthsInSeconds = 6 * 30.44 * 24 * 60 * 60;
// $oneYearInSeconds = 365.25 * 24 * 60 * 60;

// // Check for subscription period based on the retrieved value
// if ($subscriptionPeriod == 1 && $currentTimestamp - $installationTimestamp > $oneWeekInSeconds) {
//     // One week has passed, show a message and restrict access
//     echo "<div><span><center><strong>Your one-week testing period has ended. </span></center></strong><br>
// 	<span><center><strong>Please make a payment to continue using this PoS</center/></strong><br>
// 	<span><center><strong>Call for help: +256783021733/ +256700523830</center/></strong></div>";
//     exit(); // Stop further execution of the code
// } elseif ($subscriptionPeriod == 2 && $currentTimestamp - $installationTimestamp > $sixMonthsInSeconds) {
//     // 6 months have passed, show a message and restrict access
//     echo "<div><span><center><strong>Your 6-month subscription has ended. </span></center></strong><br>
// 	<span><center><strong>Please renew your subscription to continue using this PoS</center/></strong><br>
// 	<span><center><strong>Call for help: +256783021733/ +256700523830</center/></strong></div>";
//     exit(); // Stop further execution of the code
// } elseif ($subscriptionPeriod == 3 && $currentTimestamp - $installationTimestamp > $oneYearInSeconds) {
//     // 1 year has passed, show a message and restrict access
//     echo "<div><span><center><strong>Your 1-year subscription has ended. </span></center></strong><br>
// 	<span><center><strong>Please renew your subscription to continue using this PoS</center/></strong><br>
// 	<span><center><strong>Call for help: +256783021733/ +256700523830</center/></strong></div>";
//     exit(); // Stop further execution of the code
// }


?>




<!DOCTYPE html>
<html>
<head>
<title>
SYS
</title>
 <link href="css/bootstrap.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
  
  <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
    
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
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
<?php
	require_once('auth.php');
?>
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
</head>
<body>
<?php include('navfixed.php');?>
	<?php
$position=$_SESSION['SESS_LAST_NAME'];
if($position=='cashier') {
?>

<a href="../index.php">Logout</a>
<?php
}
if ($position == 'Admin' || $position == 'SuperAdmin') {
?>
	
	<div class="container-fluid">
      <div class="row-fluid">
	<div class="span2">
          <div class="well sidebar-nav">
                     <ul class="nav nav-list">
              <li class="active"><a href="#"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
			<li><a href="sales.php"><i class="icon-shopping-cart icon-2x"></i> Sales</a>  </li>             
			<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>
			<li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a>  </li>
			<li> <a href="expenses.php"><i class="icon-list-alt icon-2x"></i>Expenses</a></li>
			<li><a href="customer.php"><i class="icon-group icon-2x"></i> Patients</a>                                    </li>
			<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a>                                    </li>
		<br>
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
			<i class="icon-dashboard"></i> Dashboard
			</div>
			<ul class="breadcrumb">
			<li class="active">Dashboard</li>
			</ul>




<div id="mainmain">
 
    <a href="salessummaryreport.php" style="background-color: #16a085;">
        <span style="color: white;"><i class="icon-shopping-cart icon-2x"></i><br> Sales Summary Report</span>
    </a>               
    <a href="purchasesreport.php" style="background-color: #2ecc71;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Purchases Summary Report</span>
    </a>  
    <a href="expensesreport.php" style="background-color: #3498db;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Expenses Summary Report</span>
    </a>                                
	<a href="#" style="background-color: rgba(84, 24, 217, 0.7);">
    <span style="color: white;"><i class="icon-bar-chart icon-2x"></i><br> Income Statement Report</span>
</a>

   
    <a href="graphicalreport.php" style="background-color: #15a485;">
        <span style="color: white;"><i class="icon-bar-chart icon-2x"></i><br> Graphical Analysis Report</span>
    </a>   
    <a href="cashaccounts.php" style="background-color:  #8e44ad;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Cash Records</span>
    </a>


<?php
}


if ($position == 'Cashier') {

	?>
		
		<div class="container-fluid">
		  <div class="row-fluid">
		<div class="span2">
			  <div class="well sidebar-nav">
						 <ul class="nav nav-list">
				  <li class="active"><a href="#"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
				<li><a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>"><i class="icon-shopping-cart icon-2x"></i> Sales</a>  </li> 
				<li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>
				<li><a href="purchaseslist.php"><i class="icon-list-alt icon-2x"></i> Purchases</a>  </li>
				<li><a href="expenses.php"><i class="icon-list-alt icon-2x"></i>Expenses</a></li>                                          
				<li><a href="customer.php"><i class="icon-group icon-2x"></i> Patients</a>                                    </li>
				<li><a href="supplier.php"><i class="icon-group icon-2x"></i> Suppliers</a>  
                                              </li>
			
				<br><br><br>		
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
				<i class="icon-dashboard"></i> Dashboard
				</div>
				<ul class="breadcrumb">
				<li class="active">Dashboard</li>
				</ul>
				<div id="mainmain">
    <a href="sales.php?id=cash&invoice=<?php echo $finalcode ?>" style="background-color: #3498db;">
        <span style="color: white;"><i class="icon-shopping-cart icon-2x"></i><br> Sales</span>
    </a>   
    <a href="products.php" style="background-color: #27ae60;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Products</span>
    </a>  
    <a href="purchaseslist.php" style="background-color: #2980b9;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Purchases</span>
    </a>

    <a href="expenses.php" style="background-color: #e67e22;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Expenses</span>
    </a>
    <a href="customer.php" style="background-color: #e74c3c;">
        <span style="color: white;"><i class="icon-group icon-2x"></i><br> Customers</span>
    </a>

    <a href="supplier.php" style="background-color: #d35400;">
        <span style="color: white;"><i class="icon-group icon-2x"></i><br> Suppliers</span>
    </a>
    <a href="cashaccounts.php" style="background-color: #8e44ad;">
        <span style="color: white;"><i class="icon-list-alt icon-2x"></i><br> Cash Book</span>
    </a>
</div>

    <!-- Add more <a> elements with different background colors as needed -->
    <div class="clearfix"></div>
<?php
}
?>

</div>
</body>
</html>


