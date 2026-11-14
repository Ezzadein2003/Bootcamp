
<?php

$upload_dir = "uploads/";
$max_size = 2 * 1024 * 1024; // 2 MB

$allowed_types = [
    "image/jpeg" => "jpg",
    "image/png"  => "png",
    "application/pdf" => "pdf"
];

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_FILES["file"]) ||
        $_FILES["file"]["error"] !== UPLOAD_ERR_OK) {

        $message = "File upload failed.";

    } else {

        $file = $_FILES["file"];

        // Check file size
        if ($file["size"] > $max_size) {

            $message = "File is too large. Maximum size is 2 MB.";

        } else {

            // Detect actual file MIME type
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($file["tmp_name"]);

            // Check allowed file type
            if (!isset($allowed_types[$mime_type])) {

                $message = "File type is not allowed.";

            } else {

                // Create upload directory
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                // Generate random file name
                $new_name = bin2hex(random_bytes(16))
                          . "." . $allowed_types[$mime_type];

                $destination = $upload_dir . $new_name;

                // Move uploaded file
                if (move_uploaded_file(
                    $file["tmp_name"],
                    $destination
                )) {

                    $message = "File uploaded successfully.";

                } else {

                    $message = "Unable to save file.";

                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure File Upload</title>
</head>
<body>

    <h2>Secure File Upload System</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="file" name="file" required>

        <button type="submit">Upload File</button>

    </form>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

</body>
</html>
