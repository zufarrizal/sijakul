<?php
include 'db_connection.php';

$id = $_GET['id'];

$query = "SELECT * FROM matkul WHERE id_matkul = $id";
$result = mysqli_query($conn, $query);

$matkul = mysqli_fetch_assoc($result);

echo json_encode($matkul);
