<?php
include 'db_connection.php';

$query = $_GET['query'];
$column = $_GET['column'];

$sql = "SELECT * FROM matkul WHERE $column LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

$output = '';
while ($row = mysqli_fetch_assoc($result)) {
    $output .= '<tr>';
    $output .= '<td>' . $row['id_matkul'] . '</td>';
    $output .= '<td>' . $row['nama_matkul'] . '</td>';
    $output .= '<td>' . $row['sks'] . '</td>';
    $output .= '<td>
        <button class="btn btn-warning edit-btn" data-id="' . $row['id_matkul'] . '"><i class="fas fa-edit"></i> Edit</button>
        <button class="btn btn-danger delete-btn" data-id="' . $row['id_matkul'] . '"><i class="fas fa-trash"></i> Hapus</button>
    </td>';
    $output .= '</tr>';
}

echo $output;
