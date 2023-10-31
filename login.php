<?php
	//Start session
	session_start();
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	/* Database config */
// Database configuration
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "sales";

// $db_host = "localhost";
// $db_username = "root";
// $db_password = "";
// $db_name = "sales";

// Create database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


	
	// Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
    	$str = trim($str);

    // Use MySQLi's real_escape_string for sanitization
    global $conn; // Assuming $conn is your MySQLi connection
    $str = mysqli_real_escape_string($conn, $str);

    return $str;
}

	
	// Sanitize the POST values
if (isset($_POST['username']) && isset($_POST['password'])) {
    $login = clean($_POST['username']);
    $password = clean($_POST['password']);
} else {
    // Handle the case where username or password is not provided
    echo "Username or password not provided.";
    // You may want to redirect or display an error message here
}

	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Enter the correct Username';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Enter the correct Password';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: index.php");
		exit();
	}
	
	// Create query using MySQLi
	$query = "SELECT * FROM user WHERE username='$login' AND password='$password'";
	$result = mysqli_query($conn, $query); // Assuming $conn is your MySQLi connection

	if (!$result) {
    	die("Query failed: " . mysqli_error($conn));
	}

	// Check if any rows were returned
	if (mysqli_num_rows($result) > 0) {
		// Login successful
		// Process the login logic here
	} else {
		// Login failed
		// Handle unsuccessful login here
	}

	// Check whether the query was successful or not
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
			// Login Successful
			session_regenerate_id();
			$member = mysqli_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['name'];
			$_SESSION['SESS_LAST_NAME'] = $member['position'];
			$_SESSION['SESS_PRO_PIC'] = $member['profImage'];
			session_write_close();
			header("location: main/index.php");
			exit();
		} else {
			// Login failed
			header("location: login.php");
			exit();
		}
	} else {
		die("Query failed: " . mysqli_error($conn)); // Assuming $conn is your MySQLi connection
	}

?>