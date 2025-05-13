<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'mahasiswa') {
  header("Location: index.html");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Beranda Mahasiswa</title>
  <style>
    body { font-family: sans-serif; margin: 0; background: #f9f9f9; }
    nav { background: white; padding: 15px 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; gap: 20px; }
    nav a { text-decoration: none; font-weight: bold; color: #333; }

    .container { padding: 30px; }
    .top-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
    .top-bar input[type="text"] { padding: 8px; width: 200px; }

    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    tr:hover { background: #f1f1f1; cursor: pointer; }

    .route-btn {
      margin-top: 15px;
      display: none;
      padding: 10px 20px;
      background: #2196F3;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

<nav>
  <a href="#">Beranda</a>
  <a href="#">Profil Saya</a>
</nav>

<div class="container">
  <h2>Selamat datang, <?= htmlspecialchars($_SESSION['user']['email']) ?></h2>

  <div class="top-bar">
    <button onclick="searchMahasiswa()">🔍 Cari Mahasiswa</button>
    <input type="text" id="searchInput" placeholder="Cari alamat..." />
  </div>

  <table id="mahasiswaTable">
    <thead>
      <tr>
        <th>No</th><th>Nama</th><th>NIM</th><th>Alamat</th><th>Telepon</th>
      </tr>
    </thead>
    <tbody>
      <tr onclick="selectMahasiswa(this)">
        <td>1</td><td>Andi</td><td>123</td><td>Jakarta</td><td>08123xxx</td>
      </tr>
      <tr onclick="selectMahasiswa(this)">
        <td>2</td><td>Budi</td><td>124</td><td>Bandung</td><td>08123xxx</td>
      </tr>
    </tbody>
  </table>

  <button id="routeBtn" class="route-btn" onclick="showRoute()">Tunjukkan Rute</button>
</div>

<script>
  let selectedRow = null;

  function selectMahasiswa(row) {
    // reset
    if (selectedRow) selectedRow.style.backgroundColor = '';
    selectedRow = row;
    row.style.backgroundColor = '#e3f2fd';
    document.getElementById("routeBtn").style.display = "inline-block";
  }

  function showRoute() {
    if (!selectedRow) return;
    const alamat = selectedRow.cells[3].textContent;
    const url = "https://www.google.com/maps?q=" + encodeURIComponent(alamat);
    window.open(url, "_blank");
  }

  function searchMahasiswa() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("#mahasiswaTable tbody tr");
    rows.forEach(row => {
      const alamat = row.cells[3].textContent.toLowerCase();
      row.style.display = alamat.includes(input) ? "" : "none";
    });
  }
</script>

</body>
</html>
