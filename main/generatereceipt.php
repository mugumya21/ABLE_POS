<?php
// Include the database connection script
include('../connect.php');

// Check if the receipt content is received
if (isset($_POST['receipt-content'])) {
    // Get the receipt content from the POST request
    $receiptContent = $_POST['receipt-content'];

    // Parse the receipt content into an array (assuming it's in a structured format)
    $receiptData = json_decode($receiptContent, true);

    if ($receiptData) {
        // Extract receipt information and receipt items
        $patientName = $receiptData['patientName'];
        $totalAmount = $receiptData['totalAmount'];
        $receiptItems = $receiptData['items'];

        // Insert receipt information into the database
        $insertReceiptQuery = "INSERT INTO receipts (patient_name, total_amount) VALUES (?, ?)";
        
        $stmt = $conn->prepare($insertReceiptQuery);

        if ($stmt === false) {
            die("Error: Failed to prepare the receipt insertion query: " . $conn->error);
        }

        if ($stmt->bind_param("sd", $patientName, $totalAmount) === false) {
            die("Error: Failed to bind parameters: " . $stmt->error);
        }

        if ($stmt->execute()) {
            $receiptId = $stmt->insert_id;

            // Update product quantities for each receipt item
            foreach ($receiptItems as $item) {
                if (isset($item['productName'])) {
                    $productName = $item['productName'];
                    $quantity = $item['quantity'];

                    // Update the product table with the new quantity
                    $updateProductQuery = "UPDATE products SET qty_left = qty - ?, qty_sold = qty_sold + ? WHERE product_name = ?";
                    $stmtUpdateProduct = $conn->prepare($updateProductQuery);
                    $stmtUpdateProduct->bind_param("iis", $quantity, $quantity, $productName);

                    if ($stmtUpdateProduct->execute()) {
                        // Quantity updated successfully
                    } else {
                        // Handle error updating product quantity
                        echo "Error updating product quantity: " . $stmtUpdateProduct->error;
                    }
                }
            }

            // Generate HTML receipt
            $htmlReceipt = "
            <!DOCTYPE html>
            <html>
            <head>
                <title>Receipt</title>
                <style type=\"text/css\">
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
    </style>
            </head>
            <body>
                <div class=\"receipt-container\">
                <h1>Receipt</h1>
                <p><strong>Patient Name:</strong> $patientName</p>
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
                    <tbody>";
        
        foreach ($receiptItems as $item) {
            if (isset($item['productName'])) {
                $productName = $item['productName']; // Extract productName
                $quantity = $item['quantity'];
                $price = $item['price'];
                $total = $item['total'];
                $htmlReceipt .= "
                    <tr>
                        <td>$productName</td>
                        <td>$quantity</td>
                        <td>$price</td>
                        <td>$total</td>
                    </tr>";
            }
        }
        
        $htmlReceipt .= "
                    </tbody>
                </table>
                <p><strong>Total Amount:</strong> $totalAmount</p>
            </div>
        </body>
        </html>";
            // Output a link to print the receipt
            echo "<a href=\"javascript:window.print()\">Print Receipt</a>";

            // Output the HTML receipt for preview
            echo $htmlReceipt;

        } else {
            // Handle database insertion error
            echo "Error: Failed to store receipt information in the database.";
        }
    } else {
        // Handle invalid receipt content
        echo "Error: Invalid receipt content.";
    }
} else {
    // Handle the case where no receipt content is received
    echo "Error: Receipt content not received.";
}

// Close the database connection
$conn->close();
?>








