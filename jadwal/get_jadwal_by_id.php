<?php
include 'db_connection.php';

$id_jadwal = $_GET['id'];

$query = "SELECT * FROM jadwal WHERE id_jadwal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_jadwal);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode($row);

$stmt->close();
$conn->close();
