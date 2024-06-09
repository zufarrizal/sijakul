<?php
include 'db_connection.php';

$nama_matkul = strtoupper($_POST['nama_matkul']);
$sks = $_POST['sks'];

if (empty($nama_matkul) || empty($sks)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit();
}

// Check if nama_matkul already exists
$check_query = "SELECT * FROM matkul WHERE nama_matkul = '$nama_matkul'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Nama Matkul sudah ada']);
    exit();
}

$query = "INSERT INTO matkul (nama_matkul, sks) VALUES ('$nama_matkul', '$sks')";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Matkul berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan matkul']);
}

mysqli_close($conn);
