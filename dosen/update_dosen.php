<?php
include 'db_connection.php';

$id_dosen = $_POST['id_dosen'];
$nama_dosen = strtoupper($_POST['nama_dosen']);
$nid = $_POST['nid'];

if (empty($nama_dosen) || empty($nid)) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit();
}

// Check if NID already exists
$check_query = "SELECT * FROM dosen WHERE nid = '$nid' AND id_dosen != $id_dosen";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo json_encode(['status' => 'error', 'message' => 'NID sudah ada']);
    exit();
}

$query = "UPDATE dosen SET nama_dosen = '$nama_dosen', nid = '$nid' WHERE id_dosen = $id_dosen";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Dosen berhasil diupdate']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate dosen']);
}
