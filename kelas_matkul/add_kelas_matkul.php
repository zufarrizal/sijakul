<?php
include 'db.php';

$id_kelas = strtoupper($_POST['id_kelas']);
$id_matkul = strtoupper($_POST['id_matkul']);

$query = "SELECT * FROM kelas_matkul WHERE id_kelas = '$id_kelas' AND id_matkul = '$id_matkul'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo 'duplicate';
} else {
    $query = "INSERT INTO kelas_matkul (id_kelas, id_matkul) VALUES ('$id_kelas', '$id_matkul')";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
