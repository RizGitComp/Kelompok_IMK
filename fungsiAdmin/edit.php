<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.html");
  exit();
}

$nim = $_GET['nim'] ?? null;
if (!$nim) die("NIM tidak ditemukan.");

// Ambil data mahasiswa
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
if (mysqli_num_rows($result) !== 1) die("Mahasiswa tidak ditemukan.");
$data = mysqli_fetch_assoc($result);

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];
  $kesukaan = $_POST['kesukaan'];

  $update = "UPDATE mahasiswa SET 
              nama='$nama',
              tanggal_lahir='$tanggal_lahir',
              alamat='$alamat',
              telepon='$telepon',
              kesukaan='$kesukaan'
             WHERE nim = '$nim'";

  if (mysqli_query($conn, $update)) {
    mysqli_query($conn, "INSERT INTO history (user_nim, aktivitas) VALUES ('{$_SESSION['user']['nim']}', 'Edit data mahasiswa NIM $nim')");
    header("Location: dashboard_admin.php");
    exit();
  } else {
    $error = "Gagal memperbarui data.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Mahasiswa</title>
  <style>
    body { font-family: sans-serif; background: #f4f4f4; padding: 30px; }
    .container {
      background: white;
      max-width: 600px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
    }
    button {
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    a.back-btn {
      display: inline-block;
      margin-top: 20px;
      color: #333;
      text-decoration: none;
    }
    
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Data Mahasiswa</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
      <label>NIM</label>
      <input type="text" value="<?= htmlspecialchars($nim) ?>" readonly>

      <label>Nama</label>
      <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

      <label>Tanggal Lahir</label>
      <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required>

      <label>Alamat</label>
      <textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

      <label>Telepon</label>
      <input type="text" name="telepon" value="<?= htmlspecialchars($data['telepon']) ?>" required>

      <label>Kesukaan</label>
      <input type="text" name="kesukaan" value="<?= htmlspecialchars($data['kesukaan']) ?>" required>

      <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="dashboard_admin.php" class="back-btn">← Kembali</a>
  </div>
</body>
</html>
