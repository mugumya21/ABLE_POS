<!DOCTYPE html>
<html>
<head>
    <title>Cash at Bank</title>
    <style>
        /* Include your CSS styles here */
        .card {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 0 auto; /* Center-align the table horizontally */

        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center-content {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="center-content">
    <h1>Cash at Bank</h1>

        <?php
        include('../connect.php');
        $totalCashAtBank = 0;
        // Query to retrieve data from bankaccounts table
        $bankAccountsQuery = "SELECT * FROM bankaccounts";
        $bankAccountsResult = $conn->query($bankAccountsQuery);

        if ($bankAccountsResult->num_rows > 0) {
            echo '<table>';
            echo '<tr><th>Account Name</th><th>Amount</th></tr>';
            while ($row = $bankAccountsResult->fetch_assoc()) {
                $accountName = $row['account_name'];
                $amount = $row['amount'];

                // Calculate the total cash at hand
                $totalCashAtBank += $amount;

                echo '<tr>';
                echo '<td>' . $row['account_name'] . '</td>';
                echo '<td>' . $row['amount'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }

        // Display the total cash at hand
        echo '<h2>Total Cash at Banks: ' . $totalCashAtBank . '</h2>';
        // Close the database connection
        $conn->close();
        ?>
    </div>

    <!-- Include your JavaScript code here -->
</body>
</html>
