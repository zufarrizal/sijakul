<?php
include 'db_connection.php';

$id = $_GET['id'];

$sql = "SELECT * FROM kelas WHERE id_kelas = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
