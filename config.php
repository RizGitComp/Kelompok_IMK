<?php
$host = "localhost";
$user = "root";         // default XAMPP user
$pass = "";             // kosong (default) jika belum diubah
$db   = "mahasiswa_app"; // harus sama persis dengan nama database di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
