<?php
include 'db_connection.php';

$query = "SELECT * FROM ruangan";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id_ruangan'] . '">' . strtoupper($row['nama_ruangan']) . '</option>';
}

$conn->close();
