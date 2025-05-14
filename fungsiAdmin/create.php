<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.html");
  exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nim = $_POST['nim'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];
  $nama = $_POST['nama'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];
  $kesukaan = $_POST['kesukaan'];

  if ($password !== $confirm) {
    $error = "Password dan konfirmasi tidak cocok.";
  } else {
    $hashed = hash("sha256", $password);

    $query = "INSERT INTO mahasiswa (nim, password, nama, tanggal_lahir, alamat, telepon, kesukaan)
              VALUES ('$nim', '$hashed', '$nama', '$tanggal_lahir', '$alamat', '$telepon', '$kesukaan')";

    if (mysqli_query($conn, $query)) {
      mysqli_query($conn, "INSERT INTO history (user_nim, aktivitas) VALUES ('{$_SESSION['user']['nim']}', 'Tambah mahasiswa NIM $nim')");
      header("Location: ../fungsiAdmin/dashboard_admin.php");
      exit();
    } else {
      $error = "Gagal menambahkan mahasiswa. Cek NIM unik?";
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Mahasiswa</title>
  <link rel="stylesheet" href="../Asset/css/style-dashboardadmin.css">
  <style>
    .form-container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }
    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    form button {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    .error {
      color: red;
      margin-bottom: 15px;
    }
    .back-btn {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #333;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Tambah Data Mahasiswa</h2>
  <?php if ($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <label>NIM</label>
    <input type="text" name="nim" required>

    <label>Password</label>
    <input type="password" name="password" id="password" required>

    <label>Ulangi Password</label>
    <input type="password" name="confirm_password" id="confirm_password" required>

    <label>Nama</label>
    <input type="text" name="nama" required>

    <label>Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" required>

    <label>Alamat</label>
    <textarea name="alamat" required></textarea>

    <label>Telepon</label>
    <input type="text" name="telepon" required>

    <label>Kesukaan</label>
    <input type="text" name="kesukaan" required>

    <button type="submit">Simpan Mahasiswa</button>
    <div id="matchMsg" class="error"</div>
  </form>

  <a href="../fungsiAdmin/dashboard_admin.php" class="back-btn">← Kembali ke Dashboard</a>
</div>

<script>
const pass = document.getElementById("password");
const confirm = document.getElementById("confirm_password");
const msg = document.getElementById("matchMsg");
const submit = document.getElementById("submitBtn");

function checkMatch() {
  if (pass.value !== confirm.value) {
    msg.textContent = "Password tidak cocok.";
    submit.disabled = true;
  } else {
    msg.textContent = "";
    submit.disabled = false;
  }
}

pass.addEventListener("input", checkMatch);
confirm.addEventListener("input", checkMatch);
</script>


</body>
</html>
