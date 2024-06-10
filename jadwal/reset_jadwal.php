<?php
require 'db_connection.php';

// Hapus semua data jadwal
$sql = "DELETE FROM jadwal";
if ($conn->query($sql)) {
    echo "success";
} else {
    echo "Error: " . $conn->error;
}
