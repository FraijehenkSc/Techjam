<?php
// SQLite database file path
$dbFile = "C:/Users/Ninor/Downloads/SD1DUHU-main/SD1DUHU-main/empty - kopie.db"; // Replace with the actual path to your SQLite database file

// Image ID to retrieve (you should get this from the URL or another source)
$imageId = $_GET['image_id']; // Assuming you pass the image ID in the URL

try {
    // Create a new PDO instance to connect to the SQLite database
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch image data from the database based on the image ID
    $sql = "SELECT filename, image_data FROM images WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$imageId]);

    // Check if a record was found
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $filename = $row['filename'];
        $imageData = $row['image_data'];

        // Determine the content type based on the image file format (e.g., JPEG, PNG)
        // You may need to adjust this based on your database setup
        $finfo = new finfo(FILEINFO_MIME);
        $mimeType = $finfo->buffer($imageData);

        // Set the content type header
        header("Content-type: $mimeType");

        // Output the image data
        echo $imageData;
    } else {
        echo "Image not found.";
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
