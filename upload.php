<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the file was uploaded without errors
    if (isset($_FILES["gifToUpload"]) && $_FILES["gifToUpload"]["error"] == UPLOAD_ERR_OK) {
        // Specify the upload directory and allowed file types
        $target_dir = "uploads/";
        $allowed_types = array("gif");

        // Get the file name and extension
        $file_name = basename($_FILES["gifToUpload"]["name"]);
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Check if the file type is allowed
        if (in_array($file_extension, $allowed_types)) {
            // Generate a unique name for the uploaded file
            $unique_name = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $unique_name;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["gifToUpload"]["tmp_name"], $target_file)) {
                // Store the uploaded file path in a session variable
                $_SESSION["uploadedGIF"] = $target_file;

                // Redirect back to the page where the upload form is located
                header("Location: test.php?upload=success");
                exit();
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only GIF files are allowed.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
