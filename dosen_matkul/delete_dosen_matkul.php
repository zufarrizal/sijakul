<?php
include 'db_connection.php'; // Menghubungkan ke database

$id_dosenmatkul = $_POST['id'];

$query = "DELETE FROM dosen_matkul WHERE id_dosenmatkul = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_dosenmatkul);
$stmt->execute();

$stmt->close();
$conn->close();
