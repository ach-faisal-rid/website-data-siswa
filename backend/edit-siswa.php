<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil input dari JSON body
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['id']) || !isset($input['nama']) || !isset($input['kelas']) ||
    trim($input['id']) === '' || trim($input['nama']) === '' || trim($input['kelas']) === '') {
  echo json_encode([
    "status" => "gagal",
    "error" => "Field 'id', 'nama', dan 'kelas' wajib diisi."
  ]);
  exit;
}

// Bersihkan input
$id    = mysqli_real_escape_string($conn, trim($input['id']));
$nama  = mysqli_real_escape_string($conn, trim($input['nama']));
$kelas = mysqli_real_escape_string($conn, trim($input['kelas']));

// Update query
$sql = "UPDATE siswa SET nama='$nama', kelas='$kelas' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "status" => "berhasil",
    "message" => "Data siswa berhasil diperbarui.",
    "data" => [
      "id" => $id,
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
