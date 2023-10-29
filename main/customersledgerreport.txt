<!DOCTYPE html>
<html>
<?php
require_once('auth.php');
include('../connect.php'); // Include your database connection file here
?>
<head>
    <title>Customers Ledger Report</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Include other CSS and JS libraries as needed -->
</head>
<body>
<?php include('navfixed.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="contentheader">
                <i class="icon-bar-chart"></i> Customers Ledger Report
            </div>
            <ul class="breadcrumb">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Customers Ledger Report</li>
            </ul>

            <!-- Add these buttons inside the form -->
            <div style="margin-top: 20px;">
                <center>
                    <form action="customersledgerreport.php" method="POST">
                        <span for="d1">From:
                            <input type="date" name="d1" id="d1" required></span>
                        <span for="d2">To:
                            <input type="date" name="d2" id="d2" required></span>

                        <!-- Dropdown menu to select customer name -->
                        <select name="customer_name" required>
                            <option value="">Select Customer Name</option>
                            <?php
                            // Query the database for customer names
                            $query = "SELECT DISTINCT customer_name FROM customersledger";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['customer_name'] . '">' . $row['customer_name'] . '</option>';
                                }
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-info">Search</button>

                        <!-- Button to get today's Customers Ledger -->
                        <button type="button" class="btn btn-success" onclick="getTodaysCustomersledger()">Today</button>

                        <!-- Button to get weekly Customers Ledger -->
                        <button type="button" class="btn btn-primary" onclick="getWeeklyCustomersledger()">This Week</button>

                        <!-- Button to get monthly Customers Ledger -->
                        <button type="button" class="btn btn-warning" onclick="getMonthlyCustomersledger()">Monthly</button>

                        <!-- Button to get yearly Customers Ledger -->
                        <button type="button" class="btn btn-danger" onclick="getYearlyCustomersledger()">Yearly</button>
                    </form>
                </center>
            </div>

            <div class="content" id="content">
                <?php
                if (isset($_POST['d1']) && isset($_POST['d2'])) {
                    $d1 = $_POST['d1'];
                    $d2 = $_POST['d2'];
                    $customerName = $_POST['customer_name'];

                    // If no customer is selected, set the customer name to an empty string to fetch data for all customers
                    if ($customerName === '') {
                        $customerName = '';
                    }

                    $query = "SELECT * FROM customersledger WHERE date BETWEEN ? AND ?";
                    if (!empty($customerName)) {
                        $query .= " AND customer_name = ?";
                    }

                    $stmt = $conn->prepare($query);

                    if ($stmt) {
                        // Define the data types for the bind_param function
                        if (!empty($customerName)) {
                            $types = 'sss';
                        } else {
                            $types = 'ss';
                        }

                        // Define the parameters array with values
                        if (!empty($customerName)) {
                            $params = [&$types, &$d1, &$d2, &$customerName];
                        } else {
                            $params = [&$types, &$d1, &$d2];
                        }

                        // Use call_user_func_array to bind parameters dynamically
                        call_user_func_array([$stmt, 'bind_param'], $params);

                        $stmt->execute();
                        $result = $stmt->get_result();
                        $totalDebit = 0;
                        $totalCredit = 0;


                        if ($result->num_rows > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Date</th>';
                            echo '<th>Customer Name</th>';
                            echo '<th>Debit (DR)</th>';
                            echo '<th>Credit (CR)</th>';
                            echo '<th>Details</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . $row['customer_name'] . '</td>';
                                echo '<td>' . $row['dr_amount'] . '</td>';
                                echo '<td>' . $row['cr_amount'] . '</td>';
                                echo '<td>' . $row['details'] . '</td>';
                                echo '</tr>';

                                // Update total amounts
                                $totalDebit += $row['dr_amount'];
                                $totalCredit += $row['cr_amount'];
                            }

                            echo '</tbody>';
                            echo '</table>';

                            // Display total amounts
                            echo '<div>Total Debit Amount (UGX): <b>' . $totalDebit . '</b></div>';
                            echo '<div>Total Credit Amount (UGX):<b>' . $totalCredit . '</b></div>';
                            echo '<div> Total Balance(Dr - Cr) UGX: <b>' . ($totalDebit - $totalCredit) . '</b></div>';

                        } else {
                            echo 'No results found.';
                        }

                        $stmt->close();
                    } else {
                        echo 'Error: ' . $conn->error;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>

<!-- JavaScript functions for handling button clicks -->
<script>
    function getTodaysCustomersledger() {
        // Get today's date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Set the date inputs to today
        document.getElementById('d1').value = today;
        document.getElementById('d2').value = today;

       
        // Submit the form to fetch today's Customers Ledger
        document.querySelector('form').submit();
    }

    function getWeeklyCustomersledger() {
        // Get the first and last day of the current week
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay());
        var lastDay = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay() + 6);

        // Format the dates as yyyy-mm-dd
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);

        // Set the date inputs to the first and last day of the week
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;

       
        // Submit the form to fetch weekly Customers Ledger
        document.querySelector('form').submit();
    }

    function getMonthlyCustomersledger() {
        // Get the first and last day of the current month
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);

        // Format the dates as yyyy-mm-dd
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);

        // Set the date inputs to the first and last day of the month
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;

      
        // Submit the form to fetch monthly Customers Ledger
        document.querySelector('form').submit();
    }

    function getYearlyCustomersledger() {
        // Get the first and last day of the current year
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), 0, 1);
        var lastDay = new Date(today.getFullYear(), 11, 31);

        // Format the dates as yyyy-mm-dd
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);

        // Set the date inputs to the first and last day of the year
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;

      
        // Submit the form to fetch yearly Customers Ledger
        document.querySelector('form').submit();
    }

    function formatDate(date) {
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = date.getFullYear();
        return yyyy + '-' + mm + '-' + dd;
    }
</script>
</html>