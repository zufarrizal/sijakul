<?php
include 'db_connection.php'; // Menghubungkan ke database

$query = "
    SELECT dm.id_dosenmatkul, d.nama_dosen, m.nama_matkul
    FROM dosen_matkul dm
    JOIN dosen d ON dm.id_dosen = d.id_dosen
    JOIN matkul m ON dm.id_matkul = m.id_matkul
";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<tr>
        <td>' . $row['id_dosenmatkul'] . '</td>
        <td>' . strtoupper($row['nama_dosen']) . '</td>
        <td>' . strtoupper($row['nama_matkul']) . '</td>
        <td>
            <button class="btn btn-warning edit-btn" data-id="' . $row['id_dosenmatkul'] . '"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-danger delete-btn" data-id="' . $row['id_dosenmatkul'] . '"><i class="fas fa-trash-alt"></i> Hapus</button>
        </td>
    </tr>';
}

$conn->close();
