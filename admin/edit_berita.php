<?php
session_start();
include '../inc/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "Akses ditolak.";
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM berita WHERE id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Berita tidak ditemukan.";
    exit;
}

// Proses simpan perubahan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];

    // Gambar lama
    $gambar_lama = $data['gambar'];

    // Cek apakah ada gambar baru diupload
    if ($_FILES['gambar']['name']) {
        $gambar_baru = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "../img/$gambar_baru");
    } else {
        $gambar_baru = $gambar_lama;
    }

    $update = "UPDATE berita SET judul='$judul', tanggal='$tanggal', deskripsi='$deskripsi', gambar='$gambar_baru' WHERE id=$id";
    mysqli_query($conn, $update);

    echo "<script>alert('Berita berhasil diupdate!'); window.location.href='../berita_detail.php?id=$id';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Berita</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<header style="text-align: center; background-color: #003366; color: white; padding: 20px;">
  <h2>Edit Berita</h2>
</header>

<section style="padding: 20px; max-width: 700px; margin: auto;">
  <form method="POST" enctype="multipart/form-data">
    <label>Judul:</label><br>
    <input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required style="width: 100%; padding: 8px;"><br><br>

    <label>Tanggal:</label><br>
    <input type="date" name="tanggal" value="<?php echo $data['tanggal']; ?>" required style="width: 100%; padding: 8px;"><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi" rows="5" style="width: 100%; padding: 8px;" required><?php echo htmlspecialchars($data['deskripsi']); ?></textarea><br><br>

    <label>Gambar Saat Ini:</label><br>
    <?php if (!empty($data['gambar'])): ?>
      <img src="../img/<?php echo $data['gambar']; ?>" alt="Gambar Berita" style="max-width: 100px;"><br>
    <?php endif; ?>
    <small>Upload gambar baru jika ingin mengganti</small><br>
    <input type="file" name="gambar" accept="image/*"><br><br>

    <button type="submit">Simpan Perubahan</button>
  </form>
</section>

</body>
</html>
