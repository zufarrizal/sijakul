<?php
include 'db_connection.php'; // Menghubungkan ke database

$query = "SELECT * FROM dosen";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id_dosen'] . '">' . strtoupper($row['nama_dosen']) . '</option>';
}

$conn->close();
