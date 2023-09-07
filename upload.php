<?php
// SQLite database file path
$dbFile = "C:/Users/Ninor/Downloads/SD1DUHU-main/SD1DUHU-main/empty - kopie.db"; // Replace with your SQLite database file path

try {
    // Create a new PDO instance to connect to the SQLite database
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted and an image file was selected
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
        $targetDirectory = 'uploads/'; // Specify the directory where you want to save the images

        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

        // Check if the file already exists
        if (file_exists($targetFile)) {
            echo "File already exists.";
        } else {
            // Attempt to move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Image successfully uploaded
                // Now, insert the image reference into the database
                $filename = basename($_FILES["image"]["name"]);
                $description = $_POST["description"]; // Retrieve the image description from the form

                // Insert the image reference into the database
                $sql = "INSERT INTO images (filename, description) VALUES (?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$filename, $description]);

                echo "Image uploaded and database updated successfully.";
            } else {
                echo "Error uploading the image.";
            }
        }
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
