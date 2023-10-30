<?php
include("../connect.php");

// Fetch invoice data, assuming you have already fetched invoice items
if (isset($_GET['invoice_id'])) {
    $invoiceId = $_GET['invoice_id'];

    // Query to fetch invoice data (including items) based on invoice_id
    $query = "SELECT * FROM invoices WHERE invoice_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $invoiceId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $patientName = $row['patient_name'];
            $totalAmount = $row['total_amount'];

            // Fetch invoice items based on invoice_id
            $queryItems = "SELECT * FROM invoice_items WHERE invoice_item_id = ?";
            $stmtItems = $conn->prepare($queryItems);
            $stmtItems->bind_param("i", $invoiceId);

            if ($stmtItems->execute()) {
                $resultItems = $stmtItems->get_result();

                // Initialize an empty array to store invoice items
                $invoice_items = array();

                while ($item = $resultItems->fetch_assoc()) {
                    $productName = $item['product_name'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $total = $item['total'];

                    $invoice_items[] = array(
                        'product_name' => $productName,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $total
                    );
                }
            }
        } else {
            // Handle case where no invoice with the specified ID was found
            echo "Invoice not found.";
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
    echo "Invalid invoice ID.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
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

        .invoice-links {
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


.invoice-links {
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

    </style></head>
<body>
    <div class="invoice-container">
    <div class="invoice-links">
            <a href="javascript:window.print()" class="print-link">Print Invoice</a>
             <a href="invoiceslist.php" class="back-link">Back</a>
        </div>
        <h1>Invoice No <?php echo $invoiceId; ?></h1>
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
                // Iterate through invoice_items to generate table rows
                foreach ($invoice_items as $item) {
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
