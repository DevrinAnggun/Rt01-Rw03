<?php include 'inc/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Berita | RT.01/RW.03 Karangtengah</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <header style="text-align: center; padding: 20px;">
    <a href="index.php" style="text-decoration: none;">← Kembali ke Beranda</a>
    <h1>Daftar Berita RT.01/RW.03</h1>
    <p>Kumpulan informasi kegiatan & pengumuman warga</p>
  </header>

  <section style="padding: 20px; max-width: 800px; margin: auto;">
    <?php
    $query = "SELECT * FROM berita ORDER BY tanggal DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0):
      while ($row = mysqli_fetch_assoc($result)):
    ?>
      <div style="margin-bottom: 30px;">
        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
        <small><i><?php echo date("d M Y", strtotime($row['tanggal'])); ?></i></small><br>
        <p><?php echo substr(strip_tags($row['deskripsi']), 0, 150); ?>...</p>
        <a href="berita_detail.php?id=<?php echo $row['id']; ?>">Baca selengkapnya</a>
      </div>
      <hr>
    <?php endwhile; else: ?>
      <p>Belum ada berita.</p>
    <?php endif; ?>
  </section>

  <footer style="text-align: center; padding: 10px; font-size: 14px;">
    &copy; <?php echo date('Y'); ?> RT.01/RW.03 Desa Karangtengah
  </footer>

</body>
</html>
