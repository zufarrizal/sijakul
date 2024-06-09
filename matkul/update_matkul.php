<?php
include 'db_connection.php';

$id_matkul = $_POST['id_matkul'];
$nama_matkul = strtoupper($_POST['nama_matkul']);
$sks = $_POST['sks'];

if (empty($nama_matkul) || empty($sks)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit();
}

// Check if nama_matkul already exists
$check_query = "SELECT * FROM matkul WHERE nama_matkul = '$nama_matkul' AND id_matkul != $id_matkul";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Nama Matkul sudah ada']);
    exit();
}

$query = "UPDATE matkul SET nama_matkul = '$nama_matkul', sks = '$sks' WHERE id_matkul = $id_matkul";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Matkul berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate matkul']);
}

mysqli_close($conn);
