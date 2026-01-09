<?php
$servername = "localhost:8111";
$username = "root";
$password = "";
$dbname = "photo_storage;";

$conn = NEW mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
echo "Koneksi berhasil!";

// Test query
$result = $conn->query("SELECT * FROM photos");
if ($result) {
    echo "Tabel ada dan bisa diakses.";
} else {
    echo "Error query: " . $conn->error;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    HALLO
</body>
</html>


