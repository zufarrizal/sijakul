<?php
require 'db_connection.php';

// Ambil kolom dan query dari input
$column = mysqli_real_escape_string($conn, $_GET['column']);
$query = mysqli_real_escape_string($conn, $_GET['query']);

// Peta kolom input ke kolom yang ada di tabel join
$column_map = [
    'kelas' => 'kelas.nama_kelas',
    'matkul' => 'matkul.nama_matkul',
    'dosen' => 'dosen.nama_dosen',
    'ruangan' => 'ruangan.nama_ruangan'
];

// Cek apakah kolom yang dimasukkan valid untuk menghindari SQL Injection
if (!array_key_exists($column, $column_map)) {
    echo "Kolom pencarian tidak valid.";
    exit;
}

$mapped_column = $column_map[$column];

// Buat query dengan join ke tabel referensi
$sql = "SELECT jadwal.*, kelas.nama_kelas, matkul.nama_matkul, dosen.nama_dosen, ruangan.nama_ruangan 
        FROM jadwal 
        JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
        JOIN matkul ON jadwal.id_matkul = matkul.id_matkul
        JOIN dosen ON jadwal.id_dosen = dosen.id_dosen
        JOIN ruangan ON jadwal.id_ruangan = ruangan.id_ruangan
        WHERE $mapped_column LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

// Cek apakah query berhasil dijalankan
if ($result) {
    // Loop melalui hasil query dan tampilkan data
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id_jadwal'] . "</td>";
        echo "<td>" . $row['hari'] . "</td>";
        echo "<td>" . $row['jam_mulai'] . "</td>";
        echo "<td>" . $row['jam_selesai'] . "</td>";
        echo "<td>" . $row['nama_kelas'] . "</td>";
        echo "<td>" . $row['nama_matkul'] . "</td>";
        echo "<td>" . $row['nama_dosen'] . "</td>";
        echo "<td>" . $row['nama_ruangan'] . "</td>";
        echo "<td><button class='btn edit-btn btn-warning' data-id='" . $row['id_jadwal'] . "'><i class='fas fa-edit'></i> Edit</button><button class='btn delete-btn btn-danger' data-id='" . $row['id_jadwal'] . "'><i class='fas fa-trash'></i> Delete</button></td>";
        echo "</tr>";
    }
} else {
    // Tampilkan pesan kesalahan jika query gagal
    echo "Kesalahan dalam eksekusi query: " . mysqli_error($conn);
}

// Tutup koneksi ke database
mysqli_close($conn);
