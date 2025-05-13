<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard Admin</title>
  <style>
    body { font-family: sans-serif; margin: 0; background: #f4f6f8; }
    nav { background: white; padding: 15px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; gap: 20px; }
    nav a { text-decoration: none; font-weight: bold; color: #333; }

    .container { padding: 30px; }
    .btn { padding: 8px 14px; background: #f1f1f1; border: 1px solid #ccc; border-radius: 6px; cursor: pointer; margin-right: 10px; }
    .btn:hover { background: #e0e0e0; }
    .input-search { padding: 8px; border: 1px solid #ccc; border-radius: 5px; }

    table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    td a { color: blue; text-decoration: none; }

    .footer-note { margin-top: 20px; font-size: 14px; color: #555; }
  </style>
</head>
<body>

<nav>
  <a href="#">Aplikasi Data Mahasiswa</a>
  <a href="#">Beranda</a>
  <a href="#">Profil Saya</a>
  <a href="#">Data Mahasiswa</a>
  <a href="#">Aktivitas</a>
</nav>

<div class="container">
  <h2>Selamat datang, <?= htmlspecialchars($_SESSION['user']['email']) ?></h2>
  <p>Admin</p>

  <!-- Toolbar -->
  <div>
    <button class="btn">✏️ Edit Data</button>
    <button class="btn">🗑️ Hapus Data</button>
    <button class="btn">🔍 Cari Mahasiswa</button>
    <button class="btn">➕ Lihat Riwayat Aktivitas</button>
    <input type="text" class="input-search" placeholder="Cari..." />
  </div>

  <!-- Table Mahasiswa -->
  <table>
    <thead>
      <tr>
        <th>No</th><th>Nama</th><th>NIM</th><th>Tanggal Lahir</th><th>Alamat</th>
        <th>Telepon</th><th>Kesukaan</th><th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td><td>Andi</td><td>123</td><td>01-01-2000</td><td>Jakarta</td>
        <td>08123xxx</td><td>Musik</td><td><a href="#">Edit</a></td>
      </tr>
      <tr>
        <td>2</td><td>Budi</td><td>124</td><td>02-02-2000</td><td>Bandung</td>
        <td>08123xxx</td><td>Sepak</td><td><a href="#">Edit</a></td>
      </tr>
    </tbody>
  </table>

  <!-- Activity Log Info -->
  <div class="footer-note">
    Login pukul 09.00 &nbsp;&nbsp; Edit data tanggal 08/05/2025
  </div>
</div>

</body>
</html>
