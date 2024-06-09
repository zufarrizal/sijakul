<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kelas = $_POST['nama_kelas'];
    $kapasitas = $_POST['kapasitas'];

    // Periksa duplikasi nama_kelas
    $check_sql = "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Nama kelas sudah ada']);
    } else {
        $sql = "INSERT INTO kelas (nama_kelas, kapasitas) VALUES ('$nama_kelas', $kapasitas)";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(['status' => 'success', 'message' => 'Kelas berhasil ditambahkan']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan kelas']);
        }
    }
}
