<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Function to check if the modal should appear based on a random chance
function shouldShowModal()
{
    // Generate a random number between 1 and 10
    $randomNumber = rand(1, 10);

    // Set the chance of the modal appearing (e.g., 30% chance)
    $chanceToShow = 3; // 30% chance

    // Check if the random number is within the chanceToShow range
    return $randomNumber <= $chanceToShow;
}

// Check if the modal should appear
$showModal = shouldShowModal();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Varela Round', sans-serif;
            text-align: center;
        }

        /* Popup styles */
        .modal-confirm {
            color: #636363;
            width: 90%;
            margin: 30px auto;
            max-width: 500px;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -15px;
        }

        .modal-confirm .modal-body img {
            max-width: 100%;
            height: auto;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: right;
            /* Align buttons to the right */
            border-radius: 5px;
            font-size: 13px;
        }

        .modal-confirm .btn {
            color: #fff;
            border-radius: 4px;
            background: #82ce34;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            border: none;
        }

        .modal-confirm .btn:hover,
        .modal-confirm .btn:focus {
            background: #6fb32b;
            outline: none;
        }

        /* Close button */
        .close-modal {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #000;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
        }

        /* Background brightness adjustment */
        .modal-backdrop.in {
            filter: brightness(100%);
            /* Adjust brightness as needed */
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

    <!-- Your page content here -->
    <div class="container">
        <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        <p>
            <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
            <a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
        </p>

        <!-- Modal HTML -->
        <?php if ($showModal) : ?>
            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-confirm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!-- Display the uploaded GIF here -->
                            <?php
                            if (isset($_SESSION["uploadedGIF"])) {
                                echo '<img src="' . $_SESSION["uploadedGIF"] . '" alt="Uploaded GIF">';
                            }
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" data-dismiss="modal">X</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            <?php if ($showModal) : ?>
                $('#myModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>

</html>
