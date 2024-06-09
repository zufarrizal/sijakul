<?php
include 'db.php';

$id = $_GET['id'];

$query = "SELECT * FROM kelas_matkul WHERE id_kelasmatkul = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);
