<?php
include 'db_connection.php';

$id_jadwal = $_POST['id'];

$query = "DELETE FROM jadwal WHERE id_jadwal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_jadwal);
$stmt->execute();

$stmt->close();
$conn->close();
