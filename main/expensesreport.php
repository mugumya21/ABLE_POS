<!DOCTYPE html>
<html>
<?php
require_once('auth.php');
include('../connect.php'); // Include your database connection file here
?>
<head>
    <title>Expenses Report</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Include other CSS and JS libraries as needed -->
</head>
<body>
<?php include('navfixed.php'); ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="contentheader">
                <i class="icon-bar-chart"></i> Expenses Report
            </div>
            <ul class="breadcrumb">
                <li><a href="index.php">Dashboard</a></li>
                <li class="active">Expenses Report</li>
            </ul>

            <!-- Add these buttons inside the form -->
            <div style="margin-top: 20px;">
                <center>
                    <form action="expensesreport.php" method="POST">
                        <span for="d1">From:
                            <input type="date" name="d1" id="d1" required></span>
                        <span for="d2">To:
                            <input type="date" name="d2" id="d2" required></span>
                        
                        <!-- Add a dropdown for selecting the expense category -->
                        <select name="expense_category">
                            <option value="">Select Expense Category</option>
                            <?php
                            // Fetch unique expense categories from your expenses table
                            $categoriesQuery = "SELECT DISTINCT expense_type FROM expenses";
                            $categoriesResult = $conn->query($categoriesQuery);
                            if ($categoriesResult->num_rows > 0) {
                                while ($row = $categoriesResult->fetch_assoc()) {
                                    echo '<option value="' . $row['expense_type'] . '">' . $row['expense_type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        
                        <button type="submit" class="btn btn-info">Search</button>

                        <!-- Button to get today's expenses -->
                        <button type="button" class="btn btn-success" onclick="getTodaysExpenses()">Today</button>

                        <!-- Button to get weekly expenses -->
                        <button type="button" class="btn btn-primary" onclick="getWeeklyExpenses()">This Week</button>

                        <!-- Button to get monthly expenses -->
                        <button type="button" class="btn btn-warning" onclick="getMonthlyExpenses()">Monthly</button>

                        <!-- Button to get yearly expenses -->
                        <button type="button" class="btn btn-danger" onclick="getYearlyExpenses()">Yearly</button>
                    </form>
                </center>
            </div>

            <div class="content" id="content">
                <?php
                if (isset($_POST['d1']) && isset($_POST['d2'])) {
                    $d1 = $_POST['d1'];
                    $d2 = $_POST['d2'];
                    $expenseCategory = $_POST['expense_category'];

                    $query = "SELECT * FROM expenses WHERE date BETWEEN ? AND ?";
                    
                    // Append category filter if a category is selected
                    if (!empty($expenseCategory)) {
                        $query .= " AND expense_type = ?";
                    }

                    $stmt = $conn->prepare($query);

                    if ($stmt) {
                        // Define the data types for the bind_param function
                        $types = 'ss';

                        // Define the parameters array with values
                        $params = [&$types, &$d1, &$d2];

                        // Bind category parameter if selected
                        if (!empty($expenseCategory)) {
                            $query .= " AND expense_type = ?";
                            $types .= 's'; // Add 's' for string type
                            $params[] = &$expenseCategory;
                        }

                        // Use call_user_func_array to bind parameters dynamically
                        call_user_func_array([$stmt, 'bind_param'], $params);

                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            echo '<table class="table">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Expense Name</th>';
                            echo '<th>Date</th>';
                            echo '<th>Amount spent (UGX)</th>';
                            echo '<th>Comment</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            $totalExpenses = 0;

                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['expense_type'] . '</td>';
                                echo '<td>' . $row['date'] . '</td>';
                                echo '<td>' . number_format($row['amount_spent']) . '</td>';
                                echo '<td>' . $row['comment'] . '</td>';
                                echo '</tr>';

                                $totalExpenses += (float)$row['amount_spent'];
                            }

                            echo '</tbody>';
                            echo '</table>';

                            // Display the total expenses
                            $dateRange = 'from ' . $d1 . ' to ' . $d2;
                            if (!empty($expenseCategory)) {
                                $dateRange .= ' for Category ' . $expenseCategory;
                            }
                            echo '<div>Total Expenses ' . $dateRange . ': <strong>UGX ' . number_format($totalExpenses) . '</strong></div>';
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
    function getTodaysExpenses() {
        // Get today's date
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;

        // Set the date inputs to today
        document.getElementById('d1').value = today;
        document.getElementById('d2').value = today;

        // Submit the form to fetch today's expenses
        document.querySelector('form').submit();
    }

    function getWeeklyExpenses() {
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

        // Submit the form to fetch weekly expenses
        document.querySelector('form').submit();
    }

    function getMonthlyExpenses() {
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

        // Submit the form to fetch monthly expenses
        document.querySelector('form').submit();
    }

    function getYearlyExpenses() {
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

        // Submit the form to fetch yearly expenses
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
