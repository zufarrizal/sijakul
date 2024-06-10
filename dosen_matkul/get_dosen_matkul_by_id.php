<?php
include 'db_connection.php'; // Menghubungkan ke database

$id_dosenmatkul = $_GET['id'];

$query = "
    SELECT * FROM dosen_matkul 
    WHERE id_dosenmatkul = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_dosenmatkul);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);

$stmt->close();
$conn->close();
