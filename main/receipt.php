<?php
include("../connect.php");

// Fetch receipt data, assuming you have already fetched receipt items
if (isset($_GET['receipt_id'])) {
    $receiptId = $_GET['receipt_id'];

    // Query to fetch receipt data (including items) based on receipt_id
    $query = "SELECT * FROM receipts WHERE receipt_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $receiptId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $row['patient_name'];
            $totalAmount = $row['total_amount'];

            // Fetch receipt items based on receipt_id
            $queryItems = "SELECT * FROM receipt_items WHERE receipt_id = ?";
            $stmtItems = $conn->prepare($queryItems);
            $stmtItems->bind_param("i", $receiptId);

            if ($stmtItems->execute()) {
                $resultItems = $stmtItems->get_result();

                // Initialize an empty array to store receipt items
                $receipt_items = array();

                while ($item = $resultItems->fetch_assoc()) {
                    $receipt_items[] = $item;
                }
            }
        } else {
            // Handle case where no receipt with the specified ID was found
            echo "Receipt not found.";
        }
    } else {
        // Handle database query error
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $stmtItems->close();
    $conn->close();
} else {
    echo "Invalid receipt ID.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            margin: 0;
            line-height: 1.5;
        }

        .patient-info {
            margin-top: 20px;
        }

        h2 {
            font-size: 18px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        strong {
            font-weight: bold;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            text-decoration: none;
            color: #007bff;
        }

        a:hover {
            text-decoration: underline;
        }

        .receipt-links {
    text-align: center; /* Center-align the links */
    margin-top: 20px; /* Adjust the margin as needed */
}

.print-link,
.back-link {
    display: inline-block; /* Display the links in a line */
    margin-right: 20px; /* Adjust the spacing between the links */
    font-size: 18px;
    text-decoration: none;
    color: #007bff;
}

.print-link:hover,
.back-link:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-links">
            <a href="javascript:window.print()" class="print-link">Print Receipt</a>
             <a href="receiptslist.php" class="back-link">Back</a>
        </div>
  
        <h1>Receipt No <?php echo $receiptId; ?></h1>
        <p><strong>Patient Name:</strong> <?php echo $patientName; ?></p>
        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Iterate through receipt_items to generate table rows
                foreach ($receipt_items as $item) {
                    $productName = $item['product_name'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $total = $item['total'];

                    echo "<tr>
                            <td>$productName</td>
                            <td>$quantity</td>
                            <td>$price</td>
                            <td>$total</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <p><strong>Total Amount:</strong> <?php echo $totalAmount; ?></p>
        
    </div>
</body>
</html>
