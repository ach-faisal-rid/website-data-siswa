<?php
header('Content-Type: application/json');

header('Access-Control-Allow-Origin: *'); // Izinkan permintaan dari semua sumber lintas asal
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE'); // Izinkan metode GET, POST, PUT, DELETE
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // Izinkan header Content-Type dan Authorization

include 'koneksi.php';


// Ambil parameter dari URL
$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

// Buat query dasar
$sql = "SELECT * FROM siswa WHERE 1=1";

// Tambahkan filter jika ada parameter
if (!empty($nama)) {
  $sql .= " AND nama LIKE '%$nama%'";
}
if (!empty($kelas)) {
  $sql .= " AND kelas = '$kelas'";
}

$result = mysqli_query($conn, $sql);
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode($data);

?>
