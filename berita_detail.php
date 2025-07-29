<?php
session_start(); // WAJIB ADA untuk akses session
include 'inc/koneksi.php';

// Cek apakah ada parameter ID
if (!isset($_GET['id'])) {
    echo "Berita tidak ditemukan.";
    exit;
}

$id = intval($_GET['id']); // Amankan input ID

// Ambil data berita berdasarkan ID
$query = "SELECT * FROM berita WHERE id = $id";
$result = mysqli_query($conn, $query);

// Cek data ada atau tidak
if (mysqli_num_rows($result) == 0) {
    echo "Berita tidak ditemukan.";
    exit;
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($data['judul']); ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- Header -->
  <header style="text-align: center; padding: 20px;">
    <a href="index.php" style="text-decoration: none;">← Kembali ke Beranda</a>
    <h1><?php echo htmlspecialchars($data['judul']); ?></h1>
    <p><i><?php echo date("d M Y", strtotime($data['tanggal'])); ?></i></p>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
      <p>
        <a href="admin/edit_berita.php?id=<?php echo $data['id']; ?>" style="color: blue; font-weight: bold;">
          ✏️ Edit Berita
        </a>
      </p>
    <?php endif; ?>
  </header>

  <!-- Konten Berita -->
  <section style="padding: 20px; max-width: 800px; margin: auto;">
    <?php if (!empty($data['gambar'])): ?>
      <img src="img/<?php echo $data['gambar']; ?>" alt="Gambar Berita" style="max-width: 100%; margin-bottom: 20px;">
    <?php endif; ?>

    <p style="text-align: justify;"><?php echo nl2br(htmlspecialchars($data['deskripsi'])); ?></p>
  </section>

  <!-- Footer -->
  <footer style="text-align: center; padding: 10px; font-size: 14px;">
    &copy; <?php echo date('Y'); ?> RT.01/RW.03 Desa Karangtengah
  </footer>

</body>
</html>
