<?php
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "db_siswa";

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// echo "Koneksi berhasil!";
?>
