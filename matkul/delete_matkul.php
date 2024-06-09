<?php
include 'db_connection.php';

$id = $_POST['id'];

$query = "DELETE FROM matkul WHERE id_matkul = $id";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Matkul berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus matkul']);
}
