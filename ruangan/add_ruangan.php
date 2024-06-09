<?php
include 'db_connection.php';

$nama_ruangan = strtoupper($_POST['nama_ruangan']);
$kapasitas = $_POST['kapasitas'];

// Cek apakah nama_ruangan sudah ada
$sql_check = "SELECT COUNT(*) as count FROM ruangan WHERE nama_ruangan = '$nama_ruangan'";
$result = mysqli_query($conn, $sql_check);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    echo json_encode(array('status' => 'error', 'message' => 'Nama ruangan sudah ada!'));
    exit;
}

// Jika tidak ada, lanjutkan dengan insert
$sql = "INSERT INTO ruangan (nama_ruangan, kapasitas) VALUES ('$nama_ruangan', '$kapasitas')";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('status' => 'success', 'message' => 'Ruangan berhasil ditambah'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Gagal menambah ruangan'));
}

mysqli_close($conn);
