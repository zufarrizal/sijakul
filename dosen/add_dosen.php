<?php
include 'db_connection.php';

$nama_dosen = strtoupper($_POST['nama_dosen']);
$nid = $_POST['nid'];

if (empty($nama_dosen) || empty($nid)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit();
}

// Check if NID already exists
$check_query = "SELECT * FROM dosen WHERE nid = '$nid'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'NID sudah ada']);
    exit();
}

$query = "INSERT INTO dosen (nama_dosen, nid) VALUES ('$nama_dosen', '$nid')";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Dosen berhasil ditambahkan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan dosen']);
}
