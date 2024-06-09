<?php
include 'db_connection.php';

$sql = "SELECT * FROM kelas";
$result = mysqli_query($conn, $sql);
$kelas_data = '';

while ($row = mysqli_fetch_assoc($result)) {
    $kelas_data .= '<tr>';
    $kelas_data .= '<td>' . $row['id_kelas'] . '</td>';
    $kelas_data .= '<td>' . $row['nama_kelas'] . '</td>';
    $kelas_data .= '<td>' . $row['kapasitas'] . '</td>';
    $kelas_data .= '<td>
        <button class="btn btn-warning edit-btn" data-id="' . $row['id_kelas'] . '"><i class="fas fa-edit"></i> Edit</button>
        <button class="btn btn-danger delete-btn" data-id="' . $row['id_kelas'] . '"><i class="fas fa-trash"></i> Hapus</button>
    </td>';
    $kelas_data .= '</tr>';
}

echo $kelas_data;
