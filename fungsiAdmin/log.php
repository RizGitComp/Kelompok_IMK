<?php
session_start();
include '../config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.html");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Riwayat Aktivitas</title>
  <link rel="stylesheet" href="../Asset/css/style-dashboardadmin.css">
  <style>
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }

    h2 {
      margin-bottom: 20px;
      font-size: 22px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }

    tr:hover {
      background: #f9f9f9;
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #ccc;
      color: #333;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }

    .back-btn:hover {
      background-color: #bbb;
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="navbar-title">Aplikasi Data Mahasiswa</div>
  <div class="navbar-right">
    <a href="../fungsiAdmin/dashboard_admin.php">Dashboard</a>
  </div>
</nav>

<div class="container">
  <h2>Riwayat Aktivitas Pengguna</h2>

  <table>
    <thead>
      <tr>
        <th>No</th><th>NIM</th><th>Nama</th><th>Aktivitas</th><th>Waktu</th>
      </tr>
    </thead>
    <tbody>
       <?php
      $query = "SELECT * FROM history ORDER BY waktu DESC";
      $result = mysqli_query($conn, $query);
      $no = 1;

      while ($row = mysqli_fetch_assoc($result)) {
        $nim = $row['user_nim'];

        // Coba cari nama di tabel mahasiswa
        $namaQuery = mysqli_query($conn, "SELECT nama FROM mahasiswa WHERE nim = '$nim'");
        if ($namaQuery && mysqli_num_rows($namaQuery) === 1) {
          $namaData = mysqli_fetch_assoc($namaQuery);
          $nama = $namaData['nama'];
        } else {
          $nama = 'Admin';
        }

        echo "<tr>
                <td>{$no}</td>
                <td>{$nim}</td>
                <td>{$nama}</td>
                <td>{$row['aktivitas']}</td>
                <td>{$row['waktu']}</td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>

  <a href="../fungsiAdmin/dashboard_admin.php" class="back-btn">← Kembali ke Dashboard</a>
</div>

</body>
</html>
