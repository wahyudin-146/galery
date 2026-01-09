<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Simpan Foto</title>
    <link rel="stylesheet" href="style.css" />
    <!-- Opsional -->
  </head>
  <body>
    <h1>Upload Foto</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
      <label for="photo">Pilih Foto:</label>
      <input type="file" name="photo" id="photo" required /><br /><br />
      <label for="description">Deskripsi:</label>
      <textarea name="description" id="description"></textarea><br /><br />
      <input type="submit" value="Upload" />
    </form>

    <h2>Foto yang Tersimpan</h2>
    
  <div>
    <ul class="foto">
      <?php 
    // Koneksi dan tampilkan foto dari DB
      $conn = new mysqli("localhost:8111", "root", "", "photo_storage;");
      $result = $conn->query("SELECT * FROM photos ORDER BY upload_date DESC");
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<img src='uploads/" . $row['filename'] . "' alt='Foto' width='200'><br>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<p>Uploaded: " . $row['upload_date'] . "</p>";
            // Tambah tombol hapus
            echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Yakin hapus foto ini?\");'>Hapus Foto</a>";
            echo "</div><hr>";
          }
      } 
      else {
        echo "Belum ada foto.";
      }
      $conn->close();
      ?> 
    </ul>
  </div>
  </body>
</html>
<?php