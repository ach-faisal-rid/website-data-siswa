<?php
header('Content-Type: application/json');
include 'koneksi.php';

// Ambil dan decode input JSON
$input = json_decode(file_get_contents('php://input'), true);

// Validasi input
if (!isset($input['id']) || trim($input['id']) === '') {
  echo json_encode([
    "status" => "gagal",
    "error" => "Field 'id' wajib diisi."
  ]);
  exit;
}

// Bersihkan input
$id = intval($input['id']); // Ubah ke integer untuk keamanan

// Cek apakah data dengan ID tersebut ada
$cek = mysqli_query($conn, "SELECT * FROM siswa WHERE id = $id");
if (mysqli_num_rows($cek) === 0) {
  echo json_encode([
    "status" => "gagal",
    "error" => "Data dengan ID $id tidak ditemukan."
  ]);
  exit;
}

// Jalankan query hapus
$sql = "DELETE FROM siswa WHERE id = $id";

if (mysqli_query($conn, $sql)) {
  echo json_encode([
    "status" => "berhasil",
    "message" => "Data siswa dengan ID $id berhasil dihapus."
  ]);
} else {
  echo json_encode([
    "status" => "gagal",
    "error" => mysqli_error($conn)
  ]);
}
?>
