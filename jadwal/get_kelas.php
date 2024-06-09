<?php
include 'db_connection.php';

$query = "SELECT * FROM kelas";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id_kelas'] . '">' . strtoupper($row['nama_kelas']) . '</option>';
}

$conn->close();
