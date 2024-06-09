<?php
require 'db_connection.php';

$id_kelas = $_GET['id_kelas'];

$query = "SELECT matkul.id_matkul, matkul.nama_matkul 
          FROM matkul 
          JOIN kelas_matkul ON matkul.id_matkul = kelas_matkul.id_matkul 
          WHERE kelas_matkul.id_kelas = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_kelas);
$stmt->execute();
$result = $stmt->get_result();

$options = "<option value=''>Pilih Mata Kuliah</option>";
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='" . $row['id_matkul'] . "'>" . $row['nama_matkul'] . "</option>";
}

echo $options;
