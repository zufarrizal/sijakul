<?php
include 'db.php';

$id_kelasmatkul = $_POST['id_kelasmatkul'];
$id_kelas = strtoupper($_POST['id_kelas']);
$id_matkul = strtoupper($_POST['id_matkul']);

$query = "SELECT * FROM kelas_matkul WHERE id_kelas = '$id_kelas' AND id_matkul = '$id_matkul' AND id_kelasmatkul != '$id_kelasmatkul'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo 'duplicate';
} else {
    $query = "UPDATE kelas_matkul SET id_kelas = '$id_kelas', id_matkul = '$id_matkul' WHERE id_kelasmatkul = '$id_kelasmatkul'";
    if (mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
