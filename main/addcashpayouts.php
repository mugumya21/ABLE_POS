<!DOCTYPE html>
<html>
<head>
    <title>Cash Payout Form</title>
</head>
<body>
    <form action="savecashpayouts.php" method="post">
        <label>From Account:</label>
        <select name="from_account">
            <option value="cash">Cash</option>
            <option value="bank">Bank</option>
        </select><br>


        <label>Date:</label>
        <input type="date" name="date" required><br>

        <label>Amount:</label>
        <input type="number" name="amount" required><br>
        <label>Expense Type:</label>
        <select name="expense_type" required>
            <option value="">Select Expense Type</option>
            <?php
            include('../connect.php');

            // Fetch expense types from the expensecategory table
            $result = $conn->query("SELECT expense_type FROM expensescategory");

            // Populate dropdown options with expense types
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['expense_type'] . '">' . $row['expense_type'] . '</option>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </select><br>

        <label>Comment:</label>
        <input type="text" name="comment"><br>

        <button type="submit">Save</button>
    </form>

    <script src="script.js"></script>
</body>
</html>
