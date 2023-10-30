<?php
include("../connect.php"); // Include your database connection script with the correct path



// Check if the order content is received
if (isset($_POST['order-content'])) {
    // Get the order content from the POST request
    $orderContent = $_POST['order-content'];

    // Parse the order content into an array (assuming it's in a structured format)
    $orderData = json_decode($orderContent, true);

    if ($orderData) {
        // Extract order information and order items
        $patientName = $orderData['patientName'];
        $totalAmount = $orderData['totalAmount'];
        $orderItems = $orderData['items'];




// Insert data into the 'orders' table
$insertOrderQuery = "INSERT INTO orders (patient_name, total_amount) VALUES (?, ?)";
$stmt = $conn->prepare($insertOrderQuery);


if ($stmt === false) {
    die("Error: Failed to prepare order insertion query: " . $conn->error);
}

if ($stmt->bind_param("sd", $patientName, $totalAmount) === false) {
    die("Error: Failed to bind parameters: " . $stmt->error);
}

if ($stmt->execute()) {
    $orderId = $stmt->insert_id;

    // Insert order items into the database
    foreach ($orderItems as $item) {
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



        $insertOrderItemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price, total, product_name) VALUES (?, ?, ?, ?, ?, ?)";
                // Use a different variable for the second prepared statement
                $stmtItems = $conn->prepare($insertOrderItemQuery);
                $stmtItems->bind_param("iiddss", $orderId, $productId, $quantity, $price, $total, $productName);

                if ($stmtItems === false) {
                    die("Error: Failed to prepare the order item insertion query: " . $conn->error);
                }

                if ($stmtItems->execute() === false) {
                    die("Error: Failed to execute the order item insertion query: " . $stmtItems->error);
                }
            }
        
// Generate HTML order
$htmlOrder = "
<!DOCTYPE html>
<html>
<head>
    <title>Order</title>
    <style type=\"text/css\">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .order-container {
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

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
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
    <div class=\"order-container\">
        <h1>Order</h1>
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

foreach ($orderItems as $item) {
    if (isset($item['productName'])) {
        $productName = $item['productName']; // Extract productName
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total = $item['total'];
        $htmlOrder .= "
            <tr>
                <td>$productName</td>
                <td>$quantity</td>
                <td>$price</td>
                <td>$total</td>
            </tr>";
    }
}

$htmlOrder .= "
            </tbody>
        </table>
        <p><strong>Total Amount:</strong> $totalAmount</p>
    </div>
</body>
</html>";

            
                        // Output a link to print the order
                        echo "<a href=\"javascript:window.print()\">Print Order </a>";
                        echo "<a href=\"sales.php\">Back to Sales</a>" ;

                        // Output the HTML order for preview
                        echo $htmlOrder;
            
                    } else {
                        // Handle database insertion error
                        echo "Error: Failed to store order information in the database.";
                    }
                } else {
                    // Handle invalid order content
                    echo "Error: Invalid order content.";
                }
            } else {
                // Handle the case where no order content is received
                echo "Error: order content not received.";
            }
            
            // Close the database connection
            $conn->close();
            ?>
            