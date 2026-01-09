<?php
// Koneksi ke MySQL (sesuaikan dengan kredensial Anda)
$servername = "localhost:8111";
$username = "root"; // Ganti dengan username Anda
$password = ""; // Ganti dengan password Anda
$dbname = "photo_storage;";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST['description'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi: hanya izinkan gambar
    $allowed_types = array("jpg", "png", "jpeg", "gif");
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        exit;
    }

    // Upload file
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // Simpan ke database dengan error handling
        $stmt = $conn->prepare("INSERT INTO photos (filename, description) VALUES (?, ?)");
        if ($stmt === false) {
            die("Error prepare: " . $conn->error);
        }
        $stmt->bind_param("ss", basename($_FILES["photo"]["name"]), $description);
        if ($stmt->execute()) {
            echo "Foto berhasil diupload!";
        } 
        else {
            echo "Error execute: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> foto berhasil di upload</title>
</head>
<body>
    <h1>
        <a href=index.php> kembali <a>
    </h1>
</body>
</html>