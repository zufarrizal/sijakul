<?php
require 'db_connection.php';

$id_matkul = $_GET['id_matkul'];

$query = "SELECT dosen.id_dosen, dosen.nama_dosen 
          FROM dosen 
          JOIN dosen_matkul ON dosen.id_dosen = dosen_matkul.id_dosen 
          WHERE dosen_matkul.id_matkul = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_matkul);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['id_dosen'] . "'>" . $row['nama_dosen'] . "</option>";
}

echo $options;
