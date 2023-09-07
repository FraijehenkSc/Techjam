<?php
// SQLite database file path
$dbFile = "C:/Users/Ninor/Downloads/SD1DUHU-main/SD1DUHU-main/empty - kopie.db";

try {
    // Create a new PDO instance
    $pdo = new PDO("sqlite:$dbFile");

    // Set PDO to throw exceptions on error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the SQLite database.";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $targetDirectory = "uploads/"; // Specify the directory where you want to save the images

    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Image successfully uploaded
        // Now, you can save the reference to the image file in your database
    } else {
        echo "Error uploading the image.";
    }
}
?>
