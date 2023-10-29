<!DOCTYPE html>
<html>
<?php
require_once('auth.php');
include('../connect.php'); // Include your database connection file here
?>
<head>
    <title>Purchases Report</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Include other CSS and JS libraries as needed -->
</head>
<body>
<?php include('navfixed.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="contentheader">
                <i class="icon-bar-chart"></i> Purchases Report
            </div>
            <ul class="breadcrumb">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Purchases Report</li>
            </ul>

            <!-- Add these buttons inside the form -->
            <div style="margin-top: 20px;">
                <center>
                    <form action="purchasesreport.php" method="POST">
                        <span for="d1">From:
                            <input type="date" name="d1" id="d1" required></span>
                        <span for="d2">To:
                            <input type="date" name="d2" id="d2" required></span>
                        
                        <!-- Add a dropdown for selecting the expense category -->
                        <select name="purchases_category">
                            <option value="">Select Purchases Category</option>
                            <?php
                            // Fetch unique  categories from your Purchases table
                            $categoriesQuery = "SELECT DISTINCT purchases_type FROM purchasescategory";
                            $categoriesResult = $conn->query($categoriesQuery);
                            if ($categoriesResult->num_rows > 0) {
                                while ($row = $categoriesResult->fetch_assoc()) {
                                    echo '<option value="' . $row['purchases_type'] . '">' . $row['purchases_type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        
                        <button type="submit" class="btn btn-info">Search</button>

                        <!-- Button to get today's Purchases -->
                        <button type="button" class="btn btn-success" onclick="getTodaysPurchases()">Today</button>

                        <!-- Button to get weekly Purchases -->
                        <button type="button" class="btn btn-primary" onclick="getWeeklyPurchases()">This Week</button>

                        <!-- Button to get monthly Purchases -->
                        <button type="button" class="btn btn-warning" onclick="getMonthlyPurchases()">Monthly</button>

                        <!-- Button to get yearly Purchases -->
                        <button type="button" class="btn btn-danger" onclick="getYearlyPurchases()">Yearly</button>
                    </form>
                </center>
            </div>

            <div class="content" id="content">
                <?php
                if (isset($_POST['d1']) && isset($_POST['d2'])) {
                    $d1 = $_POST['d1'];
                    $d2 = $_POST['d2'];
                    $purchasesCategory = $_POST['purchases_category'];

                    $query = "SELECT * FROM purchasesreport WHERE date BETWEEN ? AND ?";
                    
                    // Append category filter if a category is selected
                    if (!empty($purchasesCategory)) {
                        $query .= " AND purchases_type = ?";
                    }

                    $stmt = $conn->prepare($query);

                    if ($stmt) {
                        // Define the data types for the bind_param function
                        $types = 'ss';

                        // Define the parameters array with values
                        $params = [&$types, &$d1, &$d2];

                        // Bind category parameter if selected
                        if (!empty($purchasesCategory)) {
                            $query .= " AND purchases_type = ?";
                            $types .= 's'; // Add 's' for string type
                            $params[] = &$purchasesCategory;
                        }

                        // Use call_user_func_array to bind parameters dynamically
                        call_user_func_array([$stmt, 'bind_param'], $params);

                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Purchases Type</th>';
                            echo '<th>Supplier</th>';
                            echo '<th>Date</th>';
                            echo '<th>Amount (UGX)</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            $totalPurchases = 0;

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['purchases_type'] . '</td>';
                                echo '<td>' . $row['suplier_name'] . '</td>';                           
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . number_format($row['amount']) . '</td>';
                                echo '</tr>';

                                $totalPurchases += (float)$row['amount'];
                            }

                            echo '</tbody>';
                            echo '</table>';

                            // Display the total Purchases
                            $dateRange = 'from ' . $d1 . ' to ' . $d2;
                            if (!empty($purchasesCategory)) {
                                $dateRange .= ' for Category ' . $purchasesCategory;
                            }
                            echo '<div>Total Purchases ' . $dateRange . ': <strong>UGX ' . number_format($totalPurchases) . '</strong></div>';
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
    function getTodaysPurchases() {
        // Get today's date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Set the date inputs to today
        document.getElementById('d1').value = today;
        document.getElementById('d2').value = today;

        // Submit the form to fetch today's purchases report
        document.querySelector('form').submit();
    }

    function getWeeklyPurchases() {
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

        // Submit the form to fetch weekly Purchases
        document.querySelector('form').submit();
    }

    function getMonthlyPurchases() {
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

        // Submit the form to fetch monthly Purchases
        document.querySelector('form').submit();
    }

    function getYearlyPurchases() {
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

        // Submit the form to fetch yearly Purchases
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
