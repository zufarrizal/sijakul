<?php
include 'db_connection.php';

$query = "
    SELECT j.id_jadwal, j.hari, j.jam_mulai, j.jam_selesai, k.nama_kelas, m.nama_matkul, d.nama_dosen, r.nama_ruangan
    FROM jadwal j
    JOIN kelas k ON j.id_kelas = k.id_kelas
    JOIN matkul m ON j.id_matkul = m.id_matkul
    JOIN dosen d ON j.id_dosen = d.id_dosen
    JOIN ruangan r ON j.id_ruangan = r.id_ruangan
";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    echo '<tr>
        <td>' . $row['id_jadwal'] . '</td>
        <td>' . strtoupper($row['hari']) . '</td>
        <td>' . $row['jam_mulai'] . '</td>
        <td>' . $row['jam_selesai'] . '</td>
        <td>' . strtoupper($row['nama_kelas']) . '</td>
        <td>' . strtoupper($row['nama_matkul']) . '</td>
        <td>' . strtoupper($row['nama_dosen']) . '</td>
        <td>' . strtoupper($row['nama_ruangan']) . '</td>
        <td>
            <button class="btn btn-warning edit-btn" data-id="' . $row['id_jadwal'] . '"><i class="fas fa-edit"></i> Edit</button>
            <button class="btn btn-danger delete-btn" data-id="' . $row['id_jadwal'] . '"><i class="fas fa-trash-alt"></i> Hapus</button>
        </td>
    </tr>';
}

$conn->close();
