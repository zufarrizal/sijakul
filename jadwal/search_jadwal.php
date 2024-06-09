<?php
require 'db_connection.php';

$query = $_GET['query'];
$column = $_GET['column'];

$sql = "SELECT jadwal.*, kelas.nama_kelas, matkul.nama_matkul, dosen.nama_dosen, ruangan.nama_ruangan 
        FROM jadwal 
        JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
        JOIN matkul ON jadwal.id_matkul = matkul.id_matkul
        JOIN dosen ON jadwal.id_dosen = dosen.id_dosen
        JOIN ruangan ON jadwal.id_ruangan = ruangan.id_ruangan";

if ($column == 'nama_matkul') {
    $sql .= " WHERE matkul.nama_matkul LIKE ?";
} elseif ($column == 'nama_dosen') {
    $sql .= " WHERE dosen.nama_dosen LIKE ?";
} elseif ($column == 'nama_kelas') {
    $sql .= " WHERE kelas.nama_kelas LIKE ?";
} elseif ($column == 'nama_ruangan') {
    $sql .= " WHERE ruangan.nama_ruangan LIKE ?";
} else {
    $sql .= " WHERE jadwal.$column LIKE ?";
}

$stmt = $conn->prepare($sql);

if ($stmt) {
    $search_query = "%" . $query . "%";
    $stmt->bind_param("s", $search_query);
    $stmt->execute();
    $result = $stmt->get_result();

    $jadwals = "";
    while ($row = $result->fetch_assoc()) {
        $jadwals .= "<tr>";
        $jadwals .= "<td>" . $row['hari'] . "</td>";
        $jadwals .= "<td>" . $row['jam_mulai'] . "</td>";
        $jadwals .= "<td>" . $row['jam_selesai'] . "</td>";
        $jadwals .= "<td>" . $row['nama_kelas'] . "</td>";
        $jadwals .= "<td>" . $row['nama_matkul'] . "</td>";
        $jadwals .= "<td>" . $row['nama_dosen'] . "</td>";
        $jadwals .= "<td>" . $row['nama_ruangan'] . "</td>";
        $jadwals .= "<td>
                        <button class='btn btn-sm btn-primary edit-btn' data-id='" . $row['id_jadwal'] . "'><i class='fas fa-edit'></i> Edit</button>
                        <button class='btn btn-sm btn-danger delete-btn' data-id='" . $row['id_jadwal'] . "'><i class='fas fa-trash-alt'></i> Hapus</button>
                    </td>";
        $jadwals .= "</tr>";
    }

    echo $jadwals;
} else {
    echo "Error: " . $conn->error;
}
