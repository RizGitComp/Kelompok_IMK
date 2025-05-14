<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.html");
  exit();
}

$nim = $_GET['nim'] ?? null;
if (!$nim) {
  die("NIM tidak ditemukan.");
}

$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = '$nim'");
if (!$result || mysqli_num_rows($result) !== 1) {
  die("Mahasiswa tidak ditemukan.");
}
$data = mysqli_fetch_assoc($result);
$error = "";

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
              kesukaan='$kesukaan'";

  // Password logic
  $new_pass = $_POST['new_password'];
  $confirm = $_POST['confirm_password'];

  if (!empty($new_pass)) {
    if ($new_pass !== $confirm) {
      $error = "Password baru tidak cocok.";
    } else {
      $hashed = hash("sha256", $new_pass);
      $update .= ", password = '$hashed'";
    }
  }

  $update .= " WHERE nim = '$nim'";

  if (!$error && mysqli_query($conn, $update)) {
    mysqli_query($conn, "INSERT INTO history (user_nim, aktivitas) VALUES ('{$_SESSION['user']['nim']}', 'Edit data mahasiswa NIM $nim')");
    header("Location: dashboard_admin.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Mahasiswa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      font-family: sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 0;
    }
    .form-container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    form input, form textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 14px;
    }
    form button {
      background-color: #007bff;
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
      color: #007bff;
    }
    .input-group {
      position: relative;
    }
    .input-group i {
      position: absolute;
      right: 10px;
      top: 12px;
      cursor: pointer;
      color: #888;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h2>Edit Data Mahasiswa</h2>
  <?php if ($error): ?>
    <div class="error"><?= $error ?></div>
  <?php endif; ?>
  <form method="POST">
    <label>NIM</label>
    <input type="text" name="nim" value="<?= htmlspecialchars($nim) ?>" readonly>

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

    <label>Password Baru (Opsional)</label>
    <div class="input-group">
      <input type="password" name="new_password" id="new_password">
      <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('new_password', this)"></i>
    </div>

    <label>Ulangi Password</label>
    <div class="input-group">
      <input type="password" name="confirm_password" id="confirm_password">
      <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('confirm_password', this)"></i>
    </div>

    <div id="matchMsg" class="error"></div>
    <button type="submit">Simpan Perubahan</button>
  </form>

  <a href="dashboard_admin.php" class="back-btn">← Kembali ke Dashboard</a>
</div>

<script>
function togglePassword(fieldId, icon) {
  const input = document.getElementById(fieldId);
  const isHidden = input.type === "password";
  input.type = isHidden ? "text" : "password";
  icon.classList.toggle("fa-eye");
  icon.classList.toggle("fa-eye-slash");
}

// Validasi password real-time
const newPass = document.getElementById("new_password");
const confirmPass = document.getElementById("confirm_password");
const msg = document.getElementById("matchMsg");
const submitBtn = document.getElementById("submitBtn");

function validatePasswordMatch() {
  if (newPass.value || confirmPass.value) {
    if (newPass.value !== confirmPass.value) {
      msg.textContent = "Password tidak cocok.";
      submitBtn.disabled = true;
    } else {
      msg.textContent = "";
      submitBtn.disabled = false;
    }
  } else {
    msg.textContent = "";
    submitBtn.disabled = false;
  }
}

newPass.addEventListener("input", validatePasswordMatch);
confirmPass.addEventListener("input", validatePasswordMatch);

</script>

</body>
</html>