<?php
session_start();
include 'config.php'; // tetap ambil koneksi dari folder Koneksi

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nim = $_POST['nim'];
  $password = $_POST['password'];

  // Cek ke tabel users (admin)
  $query_admin = "SELECT * FROM users WHERE nim = '$nim' AND password = SHA2('$password', 256)";
  $result_admin = mysqli_query($conn, $query_admin);

  if ($result_admin && mysqli_num_rows($result_admin) === 1) {
    $admin = mysqli_fetch_assoc($result_admin);
    $_SESSION['user'] = [
      'nim' => $admin['nim'],
      'role' => 'admin'
    ];

    // Log aktivitas
    $log = "INSERT INTO history (user_nim, aktivitas) VALUES ('$nim', 'Login sebagai admin')";
    mysqli_query($conn, $log);

    header("Location: fungsiAdmin/dashboard_admin.php");
    exit();
  }

  // Cek ke tabel mahasiswa
  $query_mhs = "SELECT * FROM mahasiswa WHERE nim = '$nim' AND password = SHA2('$password', 256)";
  $result_mhs = mysqli_query($conn, $query_mhs);

  if ($result_mhs && mysqli_num_rows($result_mhs) === 1) {
    $_SESSION['user'] = [
      'nim' => $nim,
      'role' => 'mahasiswa'
    ];

    // Log aktivitas
    $log = "INSERT INTO history (user_nim, aktivitas) VALUES ('$nim', 'Login sebagai mahasiswa')";
    mysqli_query($conn, $log);

    header("Location: fungsiMahasiswa/dashboard_mahasiswa.php");
    exit();
  }

  echo "<script>alert('Login gagal! NIM atau password salah.'); window.location.href='index.html';</script>";
}
?>
