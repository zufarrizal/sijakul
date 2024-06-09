<?php
include 'db.php';

$id = $_POST['id'];

$query = "DELETE FROM kelas_matkul WHERE id_kelasmatkul = '$id'";
if (mysqli_query($conn, $query)) {
    echo 'success';
} else {
    echo 'error';
}
