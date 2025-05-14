<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $nim = $_POST['nim'];
  $tgl = $_POST['tanggal_lahir'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];
  $kesukaan = $_POST['kesukaan'];

  $sql = "INSERT INTO mahasiswa (nama, nim, tanggal_lahir, alamat, telepon, kesukaan)
          VALUES ('$nama', '$nim', '$tgl', '$alamat', '$telepon', '$kesukaan')";
  
  if (mysqli_query($conn, $sql)) {
    header("Location: ../dashboard_admin.php");
  } else {
    echo "Gagal menambah data: " . mysqli_error($conn);
  }
}
?>

<form method="POST" action="">
  <input type="text" name="nama" placeholder="Nama" required />
  <input type="text" name="nim" placeholder="NIM" required />
  <input type="date" name="tanggal_lahir" required />
  <input type="text" name="alamat" placeholder="Alamat" />
  <input type="text" name="telepon" placeholder="Telepon" />
  <input type="text" name="kesukaan" placeholder="Kesukaan" />
  <button type="submit">Tambah</button>
</form>
