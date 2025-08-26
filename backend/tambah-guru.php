<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

include 'koneksi.php';

// Ambil input dari JSON body
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['nama']) || !isset($input['mata_pelajaran']) || 
    trim($input['nama']) === '' || trim($input['mata_pelajaran']) === '') {
  echo json_encode([
    "status" => "gagal",
    "error" => "Field 'nama' dan 'mata_pelajaran' wajib diisi."
  ]);
  exit;
}

// Bersihkan input
$nama = mysqli_real_escape_string($conn, trim($input['nama']));
$mata_pelajaran = mysqli_real_escape_string($conn, trim($input['mata_pelajaran']));

// Query simpan
$sql = "INSERT INTO guru (nama, mata_pelajaran) VALUES ('$nama', '$mata_pelajaran')";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "status" => "berhasil",
    "message" => "Data guru berhasil ditambahkan.",
    "data" => [
      "id" => mysqli_insert_id($conn),
      "nama" => $nama,
      "mata_pelajaran" => $mata_pelajaran
    ]
  ]);
} else {
  echo json_encode([
    "status" => "gagal",
    "error" => mysqli_error($conn)
  ]);
}
?>
