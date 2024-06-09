<?php
include 'db_connection.php'; // Menghubungkan ke database

$id_dosen = strtoupper($_POST['id_dosen']);
$id_matkul = strtoupper($_POST['id_matkul']);

// Check for duplicate
$query = "SELECT * FROM dosen_matkul WHERE id_dosen = ? AND id_matkul = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_dosen, $id_matkul);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo 'duplicate';
} else {
    $query = "INSERT INTO dosen_matkul (id_dosen, id_matkul) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_dosen, $id_matkul);
    $stmt->execute();
    echo 'success';
}

$stmt->close();
$conn->close();
