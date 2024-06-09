<?php
include 'db_connection.php';

$id = $_GET['id'];

$sql = "SELECT id_ruangan, nama_ruangan, kapasitas FROM ruangan WHERE id_ruangan='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}
$conn->close();
