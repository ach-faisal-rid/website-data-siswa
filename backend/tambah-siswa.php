<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil input dari JSON body
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['nama']) || !isset($input['kelas']) || 
    trim($input['nama']) === '' || trim($input['kelas']) === '') {
  echo json_encode([
    "status" => "gagal",
    "error" => "Field 'nama' dan 'kelas' wajib diisi."
  ]);
  exit;
}

// Bersihkan input
$nama = mysqli_real_escape_string($conn, trim($input['nama']));
$kelas = mysqli_real_escape_string($conn, trim($input['kelas']));

// Query simpan
$sql = "INSERT INTO siswa (nama, kelas) VALUES ('$nama', '$kelas')";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "status" => "berhasil",
    "message" => "Data siswa berhasil ditambahkan.",
    "data" => [
      "id" => mysqli_insert_id($conn),
      "nama" => $nama,
      "kelas" => $kelas
    ]
  ]);
} else {
  echo json_encode([
    "status" => "gagal",
    "error" => mysqli_error($conn)
  ]);
}
?>
