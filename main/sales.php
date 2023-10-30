<!DOCTYPE html>
<html>
<head>
    <title>POS</title>
    <?php require_once('auth.php'); ?>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }
        /* Add CSS to highlight editable fields */
        .editable-field {
            background-color: #ffffcc;
            border: 1px solid #ccc;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
    <!--sa poip up-->
    <script src="jeffartagame.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/application.js" type="text/javascript" charset="utf-8"></script>
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
                loadingImage : 'src/loading.gif',
                closeImage   : 'src/closelabel.png'
            })
        })
    </script>
</head>
<body>
    <?php include('navfixed.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span2">
                <div class="well sidebar-nav">
                    <ul class="nav nav-list">
                    <li><a href="index.php"><i class="icon-dashboard icon-2x"></i> Dashboard </a></li> 
                        <li class="active"><a href="sales.php"><i class="icon-shopping-cart icon-2x"></i> Sales</a></li>  
                        <li><a href="salessummary.php"><i class="icon-shopping-cart icon-2x"></i> Sales Summary</a></li>                        
                        <li><a href="receiptslist.php"><i class="icon-list-alt icon-2x"></i> Receipts</a>                                     </li>
                        <li><a href="invoiceslist.php"><i class="icon-list-alt icon-2x"></i> Invoices</a>  </li>
                        <li>	<a href="#"><i class="icon-list-alt icon-2x"></i>Orders</a> </li> 
                        <li><a href="products.php"><i class="icon-list-alt icon-2x"></i> Products</a>                                     </li>                              
                        
                        <br>	
                        <li>
                            <div class="hero-unit-clock">
                            
                            </div>
                        </li>
                    </ul>             
                </div><!--/.well -->
            </div><!--/span-->
            <div class="span4">
                <div class="contentheader">
                    <i class="icon-table"></i> Sales POS
                </div>
                <ul class="breadcrumb">
                    <li><a href="index.php">Dashboard</a></li> /
                    <li class="active">Sales</li>
                </ul>
                <div style="margin-top: -19px; margin-bottom: 21px;">
                    <a  href="index.php"><button class="btn btn-default btn-large" style="float: left;"><i class="icon icon-circle-arrow-left icon-large"></i> Back</button></a>
                </div><br><br><br><br>
                <!-- patient name input field -->
                <div class="form-group">
                    <label for="patient-name">Patient Name:</label>
                    <input type="text" class="form-control" id="patient-name" placeholder="Enter Patient Name">
                </div>
               <!-- Dropdown list of products -->
               <select id="product-dropdown">
    <option value="">Select a Product</option>
    <?php
        // Include your database connection script
        include('../connect.php');

        // Query to retrieve product data
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['product_id'] . '" data-price="' . $row['price'] . '" data-product-name="' . $row['product_name'] . '">' . $row['product_name'] . '</option>';
            }
        }
    ?>
</select>


                <!-- Quantity input -->
                <input type="number" id="quantity-input" placeholder="Quantity" min="1">

                <button id="add-to-cart-btn" class="btn btn-info" style="height: 35px;">Add to Cart</button><br><br>
                <div id="cart-container">
                    <table class="hoverTable" id="cartTable" data-responsive="table" style="text-align: left;">
                        <thead>
                            <tr>
                                <th width="20%"> Product </th>
                                <th width="10%"> Quantity </th>
                                <th width="10%"> Price </th>
                                <th width="10%"> Total </th>
                                <th width="10%"> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Cart items will be displayed here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Additional table for payment mode and print receipt button -->
            <div class="span6">
                <br><br>
                <!-- Add a div to display the grand total -->
                <div id="grand-total">Grand Total: Ugx 0.00</div><br><br>
                <h4> Payment mode </h4>
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn">
                        <input type="radio" name="payment-mode" id="payment-cash" value="cash" autocomplete="off" checked> Cash
                    </label>
                    <label class="btn">
                        <input type="radio" name="payment-mode" id="payment-order" value="order" autocomplete="off"> Order
                    </label>
                    <label class="btn">
                        <input type="radio" name="payment-mode" id="payment-invoice" value="invoice" autocomplete="off"> Invoice
                    </label>
                </div>
                <br><br>
                <form id="receipt-form" action="" method="post" target="_blank">
                    <button type="submit" id="generate-receipt-btn" class="btn btn-success">Generate Receipt</button>
                    <input type="hidden" name="receipt-content" id="receipt-content">
                    <input type="hidden" name="invoice-content" id="invoice-content">
                    <input type="hidden" name="order-content" id="order-content">

                </form>
            </div>
        </div>
    </div>
    <!-- Include the JavaScript code below -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var cartData = []; // Array to store cart items

            // Attach a click event handler to the "Add to Cart" button
            $("#add-to-cart-btn").click(function() {
                var productId = $("#product-dropdown").val();
    var quantity = parseInt($("#quantity-input").val(), 10);
    var price = parseFloat($("#product-dropdown option:selected").data("price"));
    var productName = $("#product-dropdown option:selected").data("product-name"); // Get the product name


                if (productId && !isNaN(quantity) && quantity > 0 && !isNaN(price) && price > 0) {
                    // Find the product by ID
                    var product = cartData.find(function(item) {
                        return item.productId == productId;
                    });

                    if (product) {
                        // Update quantity and total if the product is already in the cart
                        product.quantity += quantity;
                        product.total = product.quantity * product.price;
                    } else {
                        // Add the product to the cart if not already present
                        cartData.push({
                            productId: productId,
                            quantity: quantity,
                            price: price,
                            total: quantity * price,
                            productName: productName // Include productName
                        });
                    }

                    // Refresh the cart table and calculate the grand total
                    refreshCartTable();
                } else {
                    alert("Please select a product, enter a valid quantity, and ensure the price is available.");
                }
            });

            // Function to refresh the cart table and calculate the grand total
            function refreshCartTable() {
                var cartTable = $("#cartTable tbody");
                cartTable.empty();

                var grandTotal = 0; // Initialize the grand total

                cartData.forEach(function(item) {
                    cartTable.append(
                        '<tr>' +
                        '<td>' + item.productName + '</td>' + // Display productName
                        '<td contenteditable="true" class="editable-field quantity">' + item.quantity + '</td>' +
                        '<td contenteditable="true" class="editable-field price">' + item.price.toFixed(2) + '</td>' +
                        '<td>' + item.total.toFixed(2) + '</td>' +
                        '<td><button class="btn btn-danger btn-mini remove-item" data-product-id="' + item.productId + '">Remove</button></td>' +
                        '</tr>'
                    );

                    // Update the grand total
                    grandTotal += item.total;
                });

                // Update the content of the grand total div
                $("#grand-total").text('Grand Total: Ugx ' + grandTotal.toFixed(2));

                // Attach click event handler for removing items
                $(".remove-item").click(function() {
                    var productId = $(this).data("product-id");
                    var index = cartData.findIndex(function(item) {
                        return item.productId == productId;
                    });

                    if (index !== -1) {
                        cartData.splice(index, 1);
                        refreshCartTable();
                    }
                });

                // Attach input event handler for editable fields
                $(".editable-field").on("input", function() {
                    var row = $(this).closest("tr");
                    var productId = row.find(".remove-item").data("product-id");
                    var quantity = parseFloat(row.find(".quantity").text());
                    var price = parseFloat(row.find(".price").text());

                    // Update the corresponding item in the cartData array
                    var itemIndex = cartData.findIndex(function(item) {
                        return item.productId == productId;
                    });

                    if (itemIndex !== -1) {
                        cartData[itemIndex].quantity = quantity;
                        cartData[itemIndex].price = price;
                        cartData[itemIndex].total = quantity * price;
                    }

                    // Refresh the cart table and calculate the grand total
                    refreshCartTable();
                });
            }

            // Function to get product name by ID (you may need to modify this)
            function getProductById(productId) {
                var productOptions = $("#product-dropdown option");
                var productName = "Unknown Product";

                productOptions.each(function() {
                    if ($(this).val() == productId) {
                        productName = $(this).text();
                        return false; // Exit the loop
                    }
                });

                return productName;
            }

            // Attach a change event handler to the payment mode radio buttons
            $('input[name="payment-mode"]').change(function() {
                var selectedPaymentMode = $('input[name="payment-mode"]:checked').val();
                var buttonText = "";

                // Determine the button text based on the selected payment mode
                if (selectedPaymentMode === "cash") {
                    buttonText = "Generate Receipt";
                } else if (selectedPaymentMode === "order") {
                    buttonText = "Generate Order";
                } else if (selectedPaymentMode === "invoice") {
                    buttonText = "Generate Invoice";
                }

                // Update the button text
                $("#generate-receipt-btn").text(buttonText);
            });

            // Attach a submit event handler to the receipt form
            $("#receipt-form").submit(function(event) {
                // Prevent the form from submitting normally
                event.preventDefault();
                var selectedPaymentMode = $('input[name="payment-mode"]:checked').val();
                var actionUrl = "";
                   // Build the content
                 var receiptContent = buildReceiptContent();
                var invoiceContent = buildInvoiceContent();
                var orderContent = buildOrderContent();


                if (selectedPaymentMode === "invoice") {
                    actionUrl = "generateinvoice.php";
                } else if (selectedPaymentMode === "cash") {
                    actionUrl = "generatereceipt.php";
                } else if (selectedPaymentMode === "order") {
                    actionUrl = "generateorder.php";
                }

                // Set the action URL based on the selected payment mode
                $(this).attr("action", actionUrl);


             
                // Set the receipt content as a hidden field value
                $("#receipt-content").val(receiptContent);
                $("#invoice-content").val(invoiceContent);
                $("#order-content").val(orderContent);

                // Submit the form
                this.submit();
            });







            // Function to generate receipt content
            function buildReceiptContent() {
                var receiptContent = {
                    patientName: $("#patient-name").val(), // Get the patient name from the input field
                    totalAmount: calculateGrandTotal(), // Calculate and get the total amount
                    items: cartData // Include the cart items
                };

                // Convert the receipt content to JSON format
                return JSON.stringify(receiptContent);
            }

            // Function to calculate the grand total
            function calculateGrandTotal() {
                var grandTotal = 0;

                cartData.forEach(function(item) {
                    grandTotal += item.total;
                });

                return grandTotal.toFixed(2);
            }

                 // Function to generate invoice content
                 function buildInvoiceContent() {
                var invoiceContent = {
                    patientName: $("#patient-name").val(), // Get the patient name from the input field
                    totalAmount: calculateGrandTotal(), // Calculate and get the total amount
                    items: cartData // Include the cart items
                };

                // Convert the receipt content to JSON format
                return JSON.stringify(invoiceContent);
            }


                 // Function to generate order content
                 function buildOrderContent() {
                var orderContent = {
                    patientName: $("#patient-name").val(), // Get the patient name from the input field
                    totalAmount: calculateGrandTotal(), // Calculate and get the total amount
                    items: cartData // Include the cart items
                };

                // Convert the receipt content to JSON format
                return JSON.stringify(orderContent);
            }



        });
    </script>

</body>
</html>
