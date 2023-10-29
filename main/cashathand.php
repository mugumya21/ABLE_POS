<!DOCTYPE html>
<html>
<head>
    <title>Cash at Hand</title>
    <style>
        /* Include your CSS styles here */
        .center-content {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="center-content">
        <h1>Cash at Hand</h1>

        <?php
        include('../connect.php');

        // Check if the connection is successful
        if (!$conn) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to calculate the total cash at hand from salessummary
        $sqlTotalCashAtHand = "SELECT amount FROM cashathand";
        $resultTotalCashAtHand = $conn->query($sqlTotalCashAtHand);

        if ($resultTotalCashAtHand && $resultTotalCashAtHand->num_rows > 0) {
            // Fetch the total cash at hand from the result
            $rowTotalCashAtHand = $resultTotalCashAtHand->fetch_assoc();
            $totalCashAtHand = $rowTotalCashAtHand['amount'];

            // Display Total Cash at Hand
            echo '<h2>Total Cash at Hand: Ugx ' . number_format($totalCashAtHand, 2) . '</h2>';
        } else {
            // Handle the case when there are no rows returned
            echo '<h2>Total Cash at Hand: Ugx 0.00</h2>';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>
</html>
