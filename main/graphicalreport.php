<!DOCTYPE html>
<html>
<head>
    <title>Monthly Analysis</title>
    <!-- Include Bootstrap and other necessary CSS and JS files -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <style type="text/css">
        .sidebar-nav {
            padding: 9px 0;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="../style.css" media="screen" rel="stylesheet" type="text/css">
    <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css">
    <script src="lib/jquery.js" type="text/javascript"></script>
    <script src="src/facebox.js" type="text/javascript"></script>
    <?php
    require_once('auth.php');
    // Include your database connection script (connect.php)
    require_once('../connect.php');

    // Define an array of all months
    $allMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    // Retrieve monthly data from the database and initialize the monthlyData array
    $monthlyData = [];
    $query = "SELECT month, expenses, ledgers, profits FROM tableanalysis";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $month = $row['month'];
            $expenses = $row['expenses'];
            $ledgers = $row['ledgers'];
            $profits = $row['profits'];

            // Populate the monthlyData array with database data
            $monthlyData[$month] = [
                'expenses' => $expenses,
                'ledgers' => $ledgers,
                'profits' => $profits
            ];
        }

        // Fill in missing months with default data (e.g., 0 values)
        foreach ($allMonths as $month) {
            if (!isset($monthlyData[$month])) {
                $monthlyData[$month] = [
                    'expenses' => 0,
                    'ledgers' => 0,
                    'profits' => 0
                ];
            }
        }

        // Sort the monthlyData array by month
        ksort($monthlyData);

        mysqli_free_result($result);
    } else {
        // Handle database query error
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    ?>

    <!-- Include Chart.js and Chart.js-PieceLabel plugin scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script>
</head>
<body>
<?php include('navfixed.php');?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="contentheader">
                <i class="icon-dashboard"></i> Monthly Analysis
            </div>
            <ul class="breadcrumb">
                <li class="active">Dashboard</li>
            </ul>
            <div id="mainmain">
                <p>Monthly Expenses, Ledgers, and Profits:</p>

                <!-- Chart Container -->
                <div style="width: 100%;">
                    <canvas id="monthlyAnalysisChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Processed monthly data from PHP
    const monthlyData = <?php echo json_encode($monthlyData); ?>;

    // Function to create a chart
    function createChart(containerId, data) {
        const ctx = document.getElementById(containerId).getContext('2d');
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($allMonths); ?>, // Use all months as labels
                datasets: [
                    {
                        label: 'Expenses',
                        data: Object.values(data).map(item => item.expenses),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Ledgers',
                        data: Object.values(data).map(item => item.ledgers),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    },
                    {
                        label: 'Profits',
                        data: Object.values(data).map(item => item.profits),
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }

    // Create monthly analysis chart
    const monthlyAnalysisChart = createChart('monthlyAnalysisChart', monthlyData);
</script>
</body>
</html>
