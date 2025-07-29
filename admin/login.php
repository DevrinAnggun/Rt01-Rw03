<?php
session_start();
include '../inc/koneksi.php';

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Cocokkan password (tanpa hash)
        if ($password === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Akun tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin/User</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh;">

  <div style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; width: 300px;">
    <h2 style="text-align: center;">Login</h2>

    <?php if (isset($error)): ?>
      <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
      <label>Username</label><br>
      <input type="text" name="username" required style="width: 100%; margin-bottom: 10px;"><br>

      <label>Password</label><br>
      <input type="password" name="password" required style="width: 100%; margin-bottom: 10px;"><br>

      <button type="submit" style="width: 100%; background-color: #003366; color: white; padding: 10px; border: none;">Login</button>
    </form>
  </div>

</body>
</html>
