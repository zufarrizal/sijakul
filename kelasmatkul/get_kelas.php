<?php
include 'db.php';

$query = "SELECT * FROM kelas";
$result = mysqli_query($conn, $query);
$options = '';

while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row['id_kelas']}'>{$row['nama_kelas']}</option>";
}

echo $options;
