<?php
include 'db.php';

$query = $_GET['query'];
$column = $_GET['column'];

$column = ($column == 'kelas') ? 'k.nama_kelas' : 'm.nama_matkul';

$query = "
    SELECT km.id_kelasmatkul, k.nama_kelas, m.nama_matkul 
    FROM kelas_matkul km
    JOIN kelas k ON km.id_kelas = k.id_kelas
    JOIN matkul m ON km.id_matkul = m.id_matkul
    WHERE $column LIKE '%$query%'
";
$result = mysqli_query($conn, $query);
$rows = '';

while ($row = mysqli_fetch_assoc($result)) {
    $rows .= "<tr>
                <td>{$row['id_kelasmatkul']}</td>
                <td>{$row['nama_kelas']}</td>
                <td>{$row['nama_matkul']}</td>
                <td>
                    <button class='btn btn-warning edit-btn' data-id='{$row['id_kelasmatkul']}'><i class='fas fa-edit'></i> Edit</button>
                    <button class='btn btn-danger delete-btn' data-id='{$row['id_kelasmatkul']}'><i class='fas fa-trash-alt'></i> Hapus</button>
                </td>
              </tr>";
}

echo $rows;
