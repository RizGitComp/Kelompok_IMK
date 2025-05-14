<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="../Asset/css/style-dashboardadmin.css">
</head>

<body>
<!-- Navbar -->
<nav class="navbar">
  <div class="navbar-left">
    <div class="navbar-title">Aplikasi Data Mahasiswa</div>
    <a href="create.php" class="btn-nav">+ Tambah Mahasiswa</a>
    <a href="log.php" class="btn-nav">Lihat Aktivitas Sistem</a>
  </div>
  <div class="navbar-right">
    <a href="logout.php" class="btn-logout" onclick="return confirm('Yakin ingin logout?')">Logout</a>
  </div>
</nav>

<!-- Main content -->
<div class="container">
  <h2>Selamat datang, Admin</h2>

  <!-- Toolbar -->
  <div class="toolbar">
  <button class="btn" id="editBtn" disabled>✏️ Edit Data</button>
  <button class="btn" id="deleteBtn" disabled>🗑️ Hapus Data</button>
  <button class="btn" id="routeBtn" disabled>📍 Tunjukkan Rute</button>
  <input type="text" class="input-search" id="searchInput" placeholder="Cari ..." />
  </div>

  <!-- Table Mahasiswa -->
  <table id="mahasiswaTable">
    <thead>
      <tr>
        <th>No</th><th>Nama</th><th>NIM</th><th>Tanggal Lahir</th><th>Alamat</th><th>Telepon</th><th>Kesukaan</th>
      </tr>
    </thead>
    
    <tbody>
      <?php
      $query = "SELECT * FROM mahasiswa";
      $result = mysqli_query($conn, $query);
      $no = 1;

while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr data-nim='{$row['nim']}' data-alamat='{$row['alamat']}'>
    <td>{$no}</td>
    <td>{$row['nama']}</td>
    <td>{$row['nim']}</td>
    <td>" . date('d-m-Y', strtotime($row['tanggal_lahir'])) . "</td>
    <td>{$row['alamat']}</td>
    <td>{$row['telepon']}</td>
    <td>{$row['kesukaan']}</td>
  </tr>";
  $no++;
}
?>
    </tbody>
  </table>

  <script src="../Asset/js/js-admin.js"></script>

</body>
</html>
