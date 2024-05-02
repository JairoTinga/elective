<?php
session_start();
include_once "config.php"; // Include your database connection file

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $number = $_POST['number'];

    // Check if customer exists
    $sqlCheck = "SELECT customerID, fullName, mobile, points FROM customer WHERE fullName = ? AND mobile = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$name, $number]);
    $existingCustomer = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingCustomer) {
        // Update points for existing customer
        $sqlUpdatePoints = "UPDATE customer SET points = points + 10 WHERE customerID = ?";
        $stmtUpdatePoints = $pdo->prepare($sqlUpdatePoints);
        $stmtUpdatePoints->execute([$existingCustomer['customerID']]);

        // Show popup notification for points added
        echo '<script>alert("Points added for existing customer!");</script>';
    } else {
        // Insert new customer with points
        $sqlInsertCustomer = "INSERT INTO customer (fullName, mobile, points) VALUES (?, ?, 10)";
        $stmtInsertCustomer = $pdo->prepare($sqlInsertCustomer);
        $stmtInsertCustomer->execute([$name, $number]);

        // Show popup notification for new customer added
        echo '<script>alert("New customer added with points!");</script>';
    }

    // Redirect after processing
    header("Location: test3.php?upload=success");
    exit();
}

// Fetch data from the customer table
$sqlFetch = "SELECT customerID, fullName, mobile, points FROM customer";
$loyaltyPointsData = [];
if ($stmtFetch = $pdo->query($sqlFetch)) {
    $loyaltyPointsData = $stmtFetch->fetchAll(PDO::FETCH_ASSOC);
}

// HTML form for inputting customer data
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test 3</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 50px;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="test.php">Test</a></li>
                <li><a href="test3.php">Test 3</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Input Name and Number</h2>
        <form id="customerForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="number">Phone/Card/ID Number:</label>
                <input type="text" class="form-control" id="number" name="number" required autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary">Add Points</button>
        </form>

        <hr>

        <h2>Loyalty Points Table</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Customer ID</th>
                        <th>Name</th>
                        <th>Phone/Card/ID Number</th>
                        <th>Points</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display loyalty points table from fetched data
                    foreach ($loyaltyPointsData as $data) {
                        echo "<tr>";
                        echo "<td>" . $data['customerID'] . "</td>";
                        echo "<td>" . $data['fullName'] . "</td>";
                        echo "<td>" . $data['mobile'] . "</td>";
                        echo "<td>" . $data['points'] . "</td>"; // Display points
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        // JavaScript to autofill form fields based on selected customer
        $(document).ready(function() {
            $('#name').on('input', function() {
                var inputName = $(this).val();
                <?php
                // Convert PHP array to JavaScript for easier processing
                $loyaltyPointsDataJson = json_encode($loyaltyPointsData);
                echo "var loyaltyPointsData = " . $loyaltyPointsDataJson . ";\n";
                ?>
                var matchingCustomer = loyaltyPointsData.find(function(customer) {
                    return customer.fullName === inputName;
                });
                if (matchingCustomer) {
                    $('#number').val(matchingCustomer.mobile);
                } else {
                    $('#number').val('');
                }
            });
        });
    </script>
</body>

</html>
