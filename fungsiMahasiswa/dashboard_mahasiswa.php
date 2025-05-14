<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mahasiswa') {
  header("Location: index.html");
  exit();
}


// Ambil nama mahasiswa
$nim = $_SESSION['user']['nim'];
$query = "SELECT nama FROM mahasiswa WHERE nim = '$nim'";
$result = mysqli_query($conn, $query);
$nama = "Mahasiswa";
if ($result && mysqli_num_rows($result) === 1) {
  $data = mysqli_fetch_assoc($result);
  $nama = $data['nama'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Mahasiswa</title>
  <link rel="stylesheet" href="../Asset/css/style-dashboardmahasiswa.css" />
</head>

<body>
<!-- Navbar -->
<nav class="navbar">
  <div style="display: flex; align-items: center; gap: 30px;">
    <div class="navbar-title">Aplikasi Data Mahasiswa</div>
    <a href="profil_saya.php" class="nav-link">Profil Saya</a>
  </div>
  <form method="post" style="margin: 0;">
    <button type="submit" name="logout" class="logout-btn">Logout</button>
  </form>
</nav>

<!-- Main Content -->
<div class="container">
  <h2>Selamat datang, <?= htmlspecialchars($nama) ?></h2>

  <div class="toolbar">
    <input type="text" class="input-search" id="searchInput" placeholder="Cari alamat mahasiswa..." />
    <button class="btn" onclick="searchMahasiswa()">🔍 Cari Mahasiswa</button>
  </div>

  <table id="mahasiswaTable">
    <thead>
      <tr>
        <th>No</th><th>Nama</th><th>NIM</th><th>Tanggal</th><th>Alamat</th><th>Telepon</th><th>Kesukaan</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr onclick=\"selectMahasiswa(this)\">
                <td>$no</td>
                <td>{$row['nama']}</td>
                <td>{$row['nim']}</td>
                <td>{$row['tanggal_lahir']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['telepon']}</td>
                <td>{$row['kesukaan']}</td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>

  <button id="routeBtn" class="route-btn" style="display:none;" onclick="showRoute()">Tunjukkan Rute</button>
</div>

<script src="../Asset/js/js-mahasiswa.js"></script>

</body>
</html>
