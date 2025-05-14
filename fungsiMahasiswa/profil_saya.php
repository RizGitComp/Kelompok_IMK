<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mahasiswa') {
  header("Location: index.html");
  exit();
}

$nim = $_SESSION['user']['nim'];

// Ambil data mahasiswa
$query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Proses update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
    // Catat aktivitas
    $log = "INSERT INTO history (user_nim, aktivitas) VALUES ('$nim', 'Update profil')";
    mysqli_query($conn, $log);
    header("Location: profil_saya.php?success=1");
    exit();
  } else {
    $error = "Gagal menyimpan perubahan.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Profil Saya</title>
  <style>
    body { font-family: sans-serif; background: #f7f7f7; margin: 0; padding: 20px; }
    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    .alert {
      padding: 10px;
      background-color: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
      margin-bottom: 20px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Profil Saya</h2>

  <?php if (isset($_GET['success'])): ?>
    <div class="alert">Profil berhasil diperbarui.</div>
  <?php endif; ?>

  <form method="POST">
    <label>NIM</label>
    <input type="text" value="<?= htmlspecialchars($nim) ?>" readonly />

    <label>Nama</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required />

    <label>Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" required />

    <label>Alamat</label>
    <textarea name="alamat" required><?= htmlspecialchars($data['alamat']) ?></textarea>

    <label>Telepon</label>
    <input type="text" name="telepon" value="<?= htmlspecialchars($data['telepon']) ?>" required />

    <label>Kesukaan</label>
    <input type="text" name="kesukaan" value="<?= htmlspecialchars($data['kesukaan']) ?>" required />

    <div style="display: flex; justify-content: space-between; gap: 10px; margin-top: 20px;">
  <button type="submit" style="flex: 1;">Simpan Perubahan</button>
  <button type="button" onclick="window.location.href='dashboard_mahasiswa.php';"
          style="flex: 0; background-color: #ccc; color: #333; border: none; border-radius: 6px; cursor: pointer;">
    Kembali
  </button>
</div>


</body>
</html>
