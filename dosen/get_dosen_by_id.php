<?php
include 'db_connection.php';

$id = $_GET['id'];

$query = "SELECT * FROM dosen WHERE id_dosen = $id";
$result = mysqli_query($conn, $query);

$dosen = mysqli_fetch_assoc($result);

echo json_encode($dosen);
