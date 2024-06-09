<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kapasitas = $_POST['kapasitas'];

    // Periksa duplikasi nama_kelas
    $check_sql = "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas' AND id_kelas != $id_kelas";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Nama kelas sudah ada']);
    } else {
        $sql = "UPDATE kelas SET nama_kelas = '$nama_kelas', kapasitas = $kapasitas WHERE id_kelas = $id_kelas";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil diupdate']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate kelas']);
        }
    }
}
