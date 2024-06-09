<?php
include 'db_connection.php';

$query = "SELECT * FROM matkul";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id_matkul'] . '">' . strtoupper($row['nama_matkul']) . '</option>';
}

$conn->close();
