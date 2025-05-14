<?php
session_start();
include '../Koneksi/config.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header("Location: ../index.html");
  exit();
}

$nim = $_GET['nim'] ?? null;
if (!$nim) die("NIM tidak ditemukan.");

mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim = '$nim'");
mysqli_query($conn, "INSERT INTO history (user_nim, aktivitas) VALUES ('{$_SESSION['user']['nim']}', 'Hapus data mahasiswa NIM $nim')");

header("Location: ../dashboard_admin.php");
exit();
?>
