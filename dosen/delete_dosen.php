<?php
include 'db_connection.php';

$id = $_POST['id'];

$query = "DELETE FROM dosen WHERE id_dosen = $id";
if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'message' => 'Dosen berhasil dihapus']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus dosen']);
}
