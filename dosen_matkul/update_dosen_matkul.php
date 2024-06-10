<?php
include 'db_connection.php'; // Menghubungkan ke database

$id_dosenmatkul = $_POST['id_dosenmatkul'];
$id_dosen = strtoupper($_POST['id_dosen']);
$id_matkul = strtoupper($_POST['id_matkul']);

// Check for duplicate
$query = "SELECT * FROM dosen_matkul WHERE id_dosen = ? AND id_matkul = ? AND id_dosenmatkul != ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $id_dosen, $id_matkul, $id_dosenmatkul);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'duplicate';
} else {
    $query = "UPDATE dosen_matkul SET id_dosen = ?, id_matkul = ? WHERE id_dosenmatkul = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $id_dosen, $id_matkul, $id_dosenmatkul);
    $stmt->execute();
    echo 'success';
}

$stmt->close();
$conn->close();
