<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sijakul";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SHOW TABLES";
$result = $conn->query($sql);

$tables = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

$data = [];
foreach ($tables as $table) {
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $data[$table] = $row['count'];
}

$conn->close();
echo json_encode($data);
