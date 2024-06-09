<?php
include 'db.php';

$query = "SELECT * FROM matkul";
$result = mysqli_query($conn, $query);
$options = '';

while ($row = mysqli_fetch_assoc($result)) {
    $options .= "<option value='{$row['id_matkul']}'>{$row['nama_matkul']}</option>";
}

echo $options;
