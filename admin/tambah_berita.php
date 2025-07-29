<?php
include '../inc/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $tanggal = $_POST['tanggal'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $path = '../img/' . $gambar;

    if (move_uploaded_file($tmp, $path)) {
        $query = "INSERT INTO berita (judul, deskripsi, tanggal, gambar) 
                  VALUES ('$judul', '$deskripsi', '$tanggal', '$gambar')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Berita berhasil ditambahkan'); window.location.href='../index.php';</script>";
        } else {
            echo "Gagal menambahkan berita: " . mysqli_error($conn);
        }
    } else {
        echo "Upload gambar gagal!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Berita</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header style="background-color: #003366; color: white; text-align: center; padding: 20px;">
  <h2>Tambah Berita Baru</h2>
</header>

<section style="padding: 20px; max-width: 600px; margin: auto;">
  <form method="POST" enctype="multipart/form-data">
    <label>Judul:</label><br>
    <input type="text" name="judul" required style="width: 100%; padding: 8px;"><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" required style="width: 100%; padding: 8px;"><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="5" required style="width: 100%; padding: 8px;"></textarea><br><br>

    <label>Upload Gambar:</label><br>
    <input type="file" name="gambar" accept="image/*" required><br><br>

    <button type="submit">Simpan Berita</button>
  </form>
</section>

</body>
</html>
