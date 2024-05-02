<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Handle file upload for the modal GIF
if(isset($_FILES["gifToUpload"])){
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["gifToUpload"]["name"]);

    // Check if the uploaded file is a GIF
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($imageFileType != "gif") {
        echo "Only GIF files are allowed.";
    } else {
        // Move the uploaded GIF to the target directory
        if(move_uploaded_file($_FILES["gifToUpload"]["tmp_name"], $target_file)) {
            // Store the uploaded GIF file path in a session variable
            $_SESSION["uploadedGIF"] = $target_file;
            echo "GIF uploaded successfully.";
        } else {
            echo "Error uploading GIF.";
        }
    }
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="test.css"> <!-- Link to your custom CSS file -->
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

    <!-- Modal HTML for uploading GIF -->
    <div id="uploadModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    Select GIF to upload:
                    <input type="file" name="gifToUpload" id="gifToUpload">
                    <input type="submit" value="Upload GIF" name="submit">
                </form>
            </div>
        </div>
    </div>

    <!-- Your page content here -->
    <div class="container">
        <h1 class="my-5">Test Page</h1>
        <p>This is the test page where you can upload a GIF for the modal.</p>
        <!-- Button to open the modal for uploading GIF -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
            Upload GIF
        </button>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>