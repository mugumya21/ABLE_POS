<!DOCTYPE html>
<html>
<?php
require_once('auth.php');
include('../connect.php'); // Include your database connection file here
?>
<head>
    <title>Receipts Summary Report</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Include other CSS and JS libraries as needed -->
</head>
<body>
<?php include('navfixed.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="contentheader">
                <i class="icon-bar-chart"></i> Invoices Summary Report
            </div>
            <ul class="breadcrumb">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Invoices Summary Report</li>
            </ul>

            <!-- Form to search receipts summary -->
            <div style="margin-top: 20px;">
                <center>
                    <form action="invoicessummaryreport.php" method="POST">
                        <span for="d1">From:
                            <input type="date" name="d1" id="d1" required></span>
                        <span for="d2">To:
                            <input type="date" name="d2" id="d2" required></span>
                        
                        <button type="submit" class="btn btn-info">Search</button>

                        <!-- Buttons for predefined date ranges -->
                        <button type="button" class="btn btn-success" onclick="getTodaysReceiptsSummary()">Today</button>
                        <button type="button" class="btn btn-primary" onclick="getWeeklyReceiptsSummary()">This Week</button>
                        <button type="button" class="btn btn-warning" onclick="getMonthlyReceiptsSummary()">Monthly</button>
                        <button type="button" class="btn btn-danger" onclick="getYearlyReceiptsSummary()">Yearly</button>
                    </form>
                </center>
            </div>

            <!-- Display receipts summary results here -->
            <div class="content" id="content">
                <?php
                if (isset($_POST['d1']) && isset($_POST['d2'])) {
                    $d1 = $_POST['d1'];
                    $d2 = $_POST['d2'];

                    $query = "SELECT * FROM invoices WHERE invoice_date BETWEEN ? AND ?";
                    $stmt = $conn->prepare($query);

                    if ($stmt) {
                        $stmt->bind_param("ss", $d1, $d2);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Receipt No</th>';
                            echo '<th>Date</th>';
                            echo '<th>Amount (UGX)</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            $totalReceiptsSummary = 0;

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['receipt_id'] . '</td>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . number_format($row['amount']) . '</td>';
                                echo '</tr>';

                                $totalReceiptsSummary += (float)$row['amount'];
                            }

                            echo '</tbody>';
                            echo '</table>';

                            // Display the total Receipts Summary
                            $dateRange = 'from ' . $d1 . ' to ' . $d2;
                            echo '<div>Total Amount ' . $dateRange . ': <strong>UGX ' . number_format($totalReceiptsSummary) . '</strong></div>';
                        } else {
                            echo 'No receipts found.';
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
    function getTodaysReceiptsSummary() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById('d1').value = today;
        document.getElementById('d2').value = today;
        document.querySelector('form').submit();
    }

    function getWeeklyReceiptsSummary() {
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay());
        var lastDay = new Date(today.getFullYear(), today.getMonth(), today.getDate() - today.getDay() + 6);
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;
        document.querySelector('form').submit();
    }

    function getMonthlyReceiptsSummary() {
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;
        document.querySelector('form').submit();
    }

    function getYearlyReceiptsSummary() {
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), 0, 1);
        var lastDay = new Date(today.getFullYear(), 11, 31);
        var firstDayFormatted = formatDate(firstDay);
        var lastDayFormatted = formatDate(lastDay);
        document.getElementById('d1').value = firstDayFormatted;
        document.getElementById('d2').value = lastDayFormatted;
        document.querySelector('form').submit();
    }

    function formatDate(date) {
        var dd = String(date.getDate()).padStart(2, '0');
        var mm = String(date.getMonth() + 1).padStart(2, '0');
        var yyyy = date.getFullYear();
        return yyyy + '-' + mm + '-' + dd;
    }
</script>
</html>
