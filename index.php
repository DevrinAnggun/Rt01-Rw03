<?php include 'inc/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>RT.01/RW.03 Karangtengah</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header style="text-align: center; padding: 20px;">
  <img src="img/rt1.png" alt="Logo RT" style="height: 200px;">
  <h1>Selamat Datang di Website RT.01/RW.03 Desa Karangtengah</h1>
  <p>Melayani warga dengan digitalisasi informasi</p>

  <div style="display: flex; justify-content: center; gap: 20px; align-items: center; margin-top: 10px;">
    <a href="admin/tambah_berita.php" style="color: yellow; text-decoration: underline;">+ Tambah Berita</a>
    
    <?php if (!isset($_SESSION)) session_start(); ?>
    <?php if (isset($_SESSION['login'])): ?>
      <span style="color: white;">Halo, <?php echo $_SESSION['username']; ?> | 
        <a href="logout.php" style="color: red;">Logout</a>
      </span>
    <?php else: ?>
      <a href="admin/login.php" style="color: white; text-decoration: underline;">Login</a>
    <?php endif; ?>
  </div>
</header>


  <hr>

  <!-- Ringkasan Kegiatan Terbaru -->
  <section style="padding: 20px;">
    <h2>Kegiatan Terbaru</h2>

    <?php
    $query = "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 3";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0):
      while ($row = mysqli_fetch_assoc($result)):
    ?>
      <div style="margin-bottom: 20px;">
        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
        <small><i><?php echo date("d M Y", strtotime($row['tanggal'])); ?></i></small><br>
        <p><?php echo substr(strip_tags($row['deskripsi']), 0, 100); ?>...</p>
        <a href="berita_detail.php?id=<?php echo $row['id']; ?>">Baca selengkapnya</a>
      </div>
      <hr>
    <?php
      endwhile;
    else:
      echo "<p>Belum ada berita terbaru.</p>";
    endif;
    ?>
  </section>
  <div style="text-align: center; margin-top: 30px;">
  <a href="berita.php">📄 Lihat Semua Berita</a>
</div>

  <footer style="text-align: center; padding: 10px; font-size: 14px;">
    &copy; <?php echo date('Y'); ?> RT.01/RW.03 Desa Karangtengah
  </footer>

</body>
</html>
