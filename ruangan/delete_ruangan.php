<?php
include 'db_connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM ruangan WHERE id_ruangan='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
