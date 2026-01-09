<?php
// Koneksi ke MySQL
$servername = "localhost:8111";
$username = "root";
$password = "";
$dbname = "photo_storage;";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek jika ID foto dikirim via GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan integer untuk keamanan

    // Ambil filename dari database
    $stmt = $conn->prepare("SELECT filename FROM photos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filename = $row['filename'];

        // Hapus file dari folder uploads
        $file_path = "uploads/" . $filename;
        if (file_exists($file_path)) {
            unlink($file_path); // Hapus file
        }


        // Hapus record dari database
        $stmt_delete = $conn->prepare("DELETE FROM photos WHERE id = ?");
        $stmt_delete->bind_param("i", $id);
        if ($stmt_delete->execute()) {
            echo "Foto berhasil dihapus!";
        } 
        else {
            echo "Error menghapus dari database: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    } else {
        echo "Foto tidak ditemukan.";
    }
    $stmt->close();
} else {
    echo "ID foto tidak valid.";
}
$conn->close();

// Redirect kembali ke index.php setelah 2 detik
header("refresh:2;url=index.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>
        <a href=index.php> kembali <a>
    </h1>
</body>
</html>