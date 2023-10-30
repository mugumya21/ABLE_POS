<?php
include("../connect.php"); // Include your database connection script with the correct path

// Check if the invoice content is received
if (isset($_POST['invoice-content'])) {
    // Get the invoice content from the POST request
    $invoiceContent = $_POST['invoice-content'];

    // Parse the invoice content into an array (assuming it's in a structured format)
    $invoiceData = json_decode($invoiceContent, true);

    if ($invoiceData) {
        // Extract invoice information and invoice items
        $patientName = $invoiceData['patientName'];
        $totalAmount = $invoiceData['totalAmount'];
        $invoiceItems = $invoiceData['items'];



// Insert data into the 'invoices' table
$insertInvoiceQuery  = "INSERT INTO invoices (patient_name, total_amount) VALUES (?, ?)";
$stmt = $conn->prepare($insertInvoiceQuery);


if ($stmt === false) {
    die("Error: Failed to prepare the invoice insertion query: " . $conn->error);
}

if ($stmt->bind_param("sd", $patientName, $totalAmount) === false) {
    die("Error: Failed to bind parameters: " . $stmt->error);
}

if ($stmt->execute()) {
    $invoiceId = $stmt->insert_id;

    // Insert invoice items into the database
    foreach ($invoiceItems as $item) {
        $productId = $item['productId'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total = $item['total'];
        
        // Check if "productName" exists in the item, if not, provide a default value or skip insertion
        if (isset($item['productName'])) {
            $productName = $item['productName'];
        } else {
            // Handle the case where "productName" is missing
            continue; // Skip this item
        }

        $insertInvoiceItemQuery = "INSERT INTO invoice_items (invoice_id, product_id, quantity, price, total, product_name) VALUES (?, ?, ?, ?, ?, ?)";
        
        // Use a different variable for the second prepared statement
        $stmtItems = $conn->prepare($insertInvoiceItemQuery);
        $stmtItems->bind_param("iiddss", $invoiceId, $productId, $quantity, $price, $total, $productName);

        if ($stmtItems === false) {
            die("Error: Failed to prepare the invoice item insertion query: " . $conn->error);
        }

        if ($stmtItems->execute() === false) {
            die("Error: Failed to execute the invoice item insertion query: " . $stmtItems->error);
        }
    }


// Generate HTML invoice
$htmlInvoice = "
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style type=\"text/css\">
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
    </style>
</head>
<body>
    <div class=\"invoice-container\">
        <h1>Invoice</h1>
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

foreach ($invoiceItems as $item) {
    if (isset($item['productName'])) {
        $productName = $item['productName']; // Extract productName
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total = $item['total'];
        $htmlInvoice .= "
            <tr>
                <td>$productName</td>
                <td>$quantity</td>
                <td>$price</td>
                <td>$total</td>
            </tr>";
    }
}

$htmlInvoice .= "
            </tbody>
        </table>
        <p><strong>Total Amount:</strong> $totalAmount</p>
    </div>
</body>
</html>";

            
            
                        // Output a link to print the invoice
                        echo "<a href=\"javascript:window.print()\">Print Invoice</a>";
                        echo "<a href=\"sales.php\">Back to Sales</a>" ;

                        // Output the HTML invoice for preview
                        echo $htmlInvoice;
            
                    } else {
                        // Handle database insertion error
                        echo "Error: Failed to store invoice information in the database.";
                    }
                } else {
                    // Handle invalid invoice content
                    echo "Error: Invalid invoice content.";
                }
            } else {
                // Handle the case where no invoice content is received
                echo "Error: invoice content not received.";
            }
            
            // Close the database connection
            $conn->close();
            ?>
            



