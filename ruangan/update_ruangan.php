<?php
include 'db_connection.php';

$id_ruangan = $_POST['id_ruangan'];
$nama_ruangan = strtoupper($_POST['nama_ruangan']);
$kapasitas = $_POST['kapasitas'];

// Cek apakah nama_ruangan sudah ada di ruangan lain
$sql_check = "SELECT COUNT(*) as count FROM ruangan WHERE nama_ruangan = '$nama_ruangan' AND id_ruangan != '$id_ruangan'";
$result = mysqli_query($conn, $sql_check);
$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    echo json_encode(array('status' => 'error', 'message' => 'Nama ruangan sudah ada!'));
    exit;
}

// Jika tidak ada, lanjutkan dengan update
$sql = "UPDATE ruangan SET nama_ruangan = '$nama_ruangan', kapasitas = '$kapasitas' WHERE id_ruangan = '$id_ruangan'";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array('status' => 'success', 'message' => 'Ruangan berhasil diupdate'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Gagal mengupdate ruangan'));
}

mysqli_close($conn);
