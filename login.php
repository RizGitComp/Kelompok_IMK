<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Ambil data dari form
  $email = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  echo "Email yang dikirim: $email<br>";
  echo "Password (plaintext): $password<br>";

  // Query ke database
  $query = "SELECT * FROM users WHERE email='$email' AND password=SHA2('$password', 256)";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user'] = $user;

    // Arahkan ke dashboard sesuai role
    if ($user['role'] === 'admin') {
      header("Location: dashboard_admin.php");
    } else {
      header("Location: dashboard_mahasiswa.php");
    }
    exit();
  } else {
    echo "<script>alert('Login gagal!'); window.location.href='index.html';</script>";
  }
}
?>
